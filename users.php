<?php 
session_start();
include_once "php/config.php";
if (!isset($_SESSION['unique_id'])) {
    header("location: login.php");
}
?>
<?php include_once "header.php"; ?>
<body>
  <style>
    /* Add your existing CSS here */

.wrapper {
    max-width: 500px;
    margin: auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

.details span {
    font-size: 18px;
    font-weight: bold;
}

.details p {
    color: #666;
}

.search {
    margin-top: 20px;
    display: flex;
    align-items: center;
}

.search input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.search button {
    padding: 10px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    margin-left: 10px;
}

.users-list {
    margin-top: 20px;
    max-height: 300px;
    overflow-y: auto;
}

.create-group {
    margin-top: 20px;
    text-align: center;
}

.add-group-btn {
    padding: 10px 20px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.group-form-container {
    display: none;
    margin-top: 20px;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.group-form-container.active {
    display: block;
}

.field {
    margin-bottom: 10px;
}

.field label {
    display: block;
    margin-bottom: 5px;
}

.field input, .field select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
}


  </style>
  <div class="wrapper">
    <section class="users">
    <header>
        <div class="content">
          <?php 
          $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
          if (mysqli_num_rows($sql) > 0) {
              $row = mysqli_fetch_assoc($sql);
          }
          ?>
          <img src="php/images/<?php echo $row['img']; ?>" alt="">
          <div class="details">
            <span><?php echo $row['fname']. " " . $row['lname'] ?></span>
            <p><?php echo $row['status']; ?></p>
          </div>
        </div>
        <a href="php/logout.php?logout_id=<?php echo $row['unique_id']; ?>" class="logout">Logout</a>
      </header>
      <div class="search">
        <span class="text">Select a user to start chat</span>
        <input type="text" placeholder="Enter name to search...">
        <button><i class="fas fa-search"></i></button>
      </div>
      <div class="users-list">
        <!-- Dynamic users list will be loaded here by JavaScript -->
      </div>
      <div class="create-group">
        <button class="add-group-btn"><i class="fas fa-plus"></i> Create Group Chat</button>
      </div>
      <div class="group-form-container">
        <h2>Create Group Chat</h2>
        <form action="create_group.php" method="POST">
          <div class="field input">
            <label>Group Name</label>
            <input type="text" name="group_name" placeholder="Enter group name" required>
          </div>
          <div class="field input">
            <label>Add Users</label>
            <select name="user_ids[]" multiple required>
              <?php
              $users_sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id != {$_SESSION['unique_id']}");
              while ($user = mysqli_fetch_assoc($users_sql)) {
                  echo "<option value='{$user['unique_id']}'>{$user['fname']} {$user['lname']}</option>";
              }
              ?>
            </select>
          </div>
          <div class="field button">
            <input type="submit" value="Create Group">
          </div>
        </form>
      </div>
    </section>
  </div>

  <script src="javascript/users.js"></script>
  <script>
    // JavaScript for toggling the group creation form
    document.querySelector('.add-group-btn').addEventListener('click', () => {
      document.querySelector('.group-form-container').classList.toggle('active');
    });

    // JavaScript for loading users list and handling search functionality
    document.addEventListener('DOMContentLoaded', () => {
      const searchInput = document.querySelector('.search input');
      const usersList = document.querySelector('.users-list');

      // Function to load users
      function loadUsers(searchTerm = '') {
        let xhr = new XMLHttpRequest();
        xhr.open("GET", `php/search_users.php?search=${searchTerm}`, true);
        xhr.onload = () => {
          if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
              usersList.innerHTML = xhr.responseText;
            }
          }
        };
        xhr.send();
      }

      // Load users on page load
      loadUsers();

      // Add search functionality
      searchInput.addEventListener('keyup', () => {
        const searchTerm = searchInput.value;
        loadUsers(searchTerm);
      });
    });

  </script>
</body>
</html>
