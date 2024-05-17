<?php
session_start();
include_once "config.php";

$searchTerm = mysqli_real_escape_string($conn, $_GET['search']);

$sql = "SELECT * FROM users WHERE (fname LIKE '%{$searchTerm}%' OR lname LIKE '%{$searchTerm}%') AND unique_id != {$_SESSION['unique_id']}";
$output = '';
$query = mysqli_query($conn, $sql);

if (mysqli_num_rows($query) > 0) {
  while ($row = mysqli_fetch_assoc($query)) {
    $output .= '<a href="chat.php?user_id=' . $row['unique_id'] . '">
                  <div class="content">
                    <img src="php/images/' . $row['img'] . '" alt="">
                    <div class="details">
                      <span>' . $row['fname'] . ' ' . $row['lname'] . '</span>
                      <p>' . $row['status'] . '</p>
                    </div>
                  </div>
                </a>';
  }
} else {
  $output .= 'No users found';
}

echo $output;
