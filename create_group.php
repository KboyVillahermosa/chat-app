<?php
session_start();
include_once "php/config.php";

if (isset($_POST['group_name']) && isset($_POST['user_ids'])) {
    $group_name = mysqli_real_escape_string($conn, $_POST['group_name']);
    $user_ids = $_POST['user_ids'];
    $creator_id = $_SESSION['unique_id'];

    // Insert group into the database
    $sql = "INSERT INTO groups (group_name, created_by) VALUES ('$group_name', '$creator_id')";
    if (mysqli_query($conn, $sql)) {
        $group_id = mysqli_insert_id($conn);

        // Insert creator into group members
        $sql = "INSERT INTO group_members (group_id, user_id) VALUES ('$group_id', '$creator_id')";
        mysqli_query($conn, $sql);

        // Insert other members into group members
        foreach ($user_ids as $user_id) {
            $sql = "INSERT INTO group_members (group_id, user_id) VALUES ('$group_id', '$user_id')";
            mysqli_query($conn, $sql);
        }

        // Redirect to a success page or group chat page
        header("Location: group_chat.php?group_id=$group_id");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "All fields are required.";
}
?>
