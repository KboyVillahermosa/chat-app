<?php
session_start();
include_once "php/config.php";
if (!isset($_SESSION['unique_id'])) {
    header("location: login.php");
    exit();
}

// Get group_id from URL parameter
if (isset($_GET['group_id'])) {
    $group_id = mysqli_real_escape_string($conn, $_GET['group_id']);
    
    // Fetch group name
    $sql_group_name = "SELECT group_name FROM groups WHERE id = ?";
    $stmt_group_name = mysqli_prepare($conn, $sql_group_name);
    mysqli_stmt_bind_param($stmt_group_name, "s", $group_id);
    mysqli_stmt_execute($stmt_group_name);
    mysqli_stmt_bind_result($stmt_group_name, $group_name);
    mysqli_stmt_fetch($stmt_group_name);
    mysqli_stmt_close($stmt_group_name);
    

    // Fetch group messages
    $sql_group_messages = "SELECT gm.message, gm.timestamp, u.fname, u.lname, u.img 
                           FROM group_messages gm 
                           JOIN users u ON gm.user_id = u.unique_id 
                           WHERE gm.group_id = ? ORDER BY gm.timestamp ASC";
    $stmt_group_messages = mysqli_prepare($conn, $sql_group_messages);
    mysqli_stmt_bind_param($stmt_group_messages, "s", $group_id);
    mysqli_stmt_execute($stmt_group_messages);
    mysqli_stmt_bind_result($stmt_group_messages, $message, $timestamp, $fname, $lname, $img);

    $messages = [];
    while (mysqli_stmt_fetch($stmt_group_messages)) {
        $messages[] = [
            'message' => $message,
            'timestamp' => $timestamp,
            'fname' => $fname,
            'lname' => $lname,
            'img' => $img
        ];
    }
    mysqli_stmt_close($stmt_group_messages);

} else {
    echo "Group ID not specified.";
    exit();
}

// Handle message submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $user_id = $_SESSION['unique_id'];

    if (!empty($message)) {
        $sql_message = "INSERT INTO group_messages (group_id, user_id, message) VALUES (?, ?, ?)";
        $stmt_message = mysqli_prepare($conn, $sql_message);
        mysqli_stmt_bind_param($stmt_message, "sss", $group_id, $user_id, $message);
        if (mysqli_stmt_execute($stmt_message)) {
            // Redirect to prevent form resubmission on refresh
            header("Location: group_chat.php?group_id=" . urlencode($group_id));
            exit();
        } else {
            echo "Failed to send message: " . mysqli_stmt_error($stmt_message);
        }
        mysqli_stmt_close($stmt_message);
    } else {
        echo "Message cannot be empty.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group Chat</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <style>
        /* Add your existing CSS here */

.chat-area {
    position: relative;
    display: flex;
    flex-direction: column;
    height: 100%;
}

.chat-box {
    flex: 1;
    overflow-y: auto;
    padding: 10px;
}

.chat {
    display: flex;
    align-items: flex-start;
    margin-bottom: 10px;
}

.chat.incoming {
    flex-direction: row;
}

.chat img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-right: 10px;
}

.chat .details {
    max-width: 70%;
}

.chat .details p {
    background-color: #f1f1f1;
    padding: 10px;
    border-radius: 10px;
    margin: 0;
}

.chat .details .time {
    font-size: 12px;
    color: #aaa;
}

.typing-area {
    display: flex;
    align-items: center;
    padding: 10px;
    border-top: 1px solid #ddd;
}

.typing-area .input-field {
    flex: 1;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    margin-right: 10px;
}

.typing-area button {
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 10px;
    cursor: pointer;
}

    </style>
    <div class="wrapper">
        <section class="chat-area">
            <header>
                <a href="groups.php" class="back-icon">&#9664;</a>
                <div class="content">
                    <img src="php/images/default.jpg" alt="">
                    <div class="details">
                        <span><?php echo htmlspecialchars($group_name); ?></span>
                    </div>
                </div>
            </header>
            <div class="chat-box">
                <?php
                foreach ($messages as $msg) {
                    echo '<div class="chat incoming">
                            <img src="php/images/'.$msg['img'].'" alt="">
                            <div class="details">
                                <p>'.$msg['fname'].' '.$msg['lname'].'<br>'.$msg['message'].'</p>
                                <span class="time">'.$msg['timestamp'].'</span>
                            </div>
                          </div>';
                }
                ?>
            </div>
            <form action="group_chat.php?group_id=<?php echo $group_id; ?>" class="typing-area" method="POST">
                <input type="text" name="message" class="input-field" placeholder="Type a message here...">
                <button type="submit"><i class="fas fa-paper-plane"></i></button>
            </form>
        </section>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
