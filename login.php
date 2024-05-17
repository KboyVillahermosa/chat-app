<?php 
  session_start();
  if(isset($_SESSION['unique_id'])){
    header("location: users.php");
  }
?>

<?php include_once "header.php"; ?>
<body>
  <style>
    body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background: url('bg_uspf_chat.png') no-repeat center center fixed;
    background-size: cover;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
}
.container {
    display: flex;
    width: 65%; /* Adjust as needed */
    border: 1px solid #cccccc00; /* Add a border around the container */
    border-radius: 15px; /* Add border-radius to round the corners of the container, adjust as needed */
    overflow: hidden; /* Hide overflow content (like rounded corners) */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Add box shadow */
}

.left-section,
.right-section {
    width: 50%;
}

.left-section {
    padding: 20px;
    background-color: #ffffff;
    border-radius: 15px 0 0 15px; /* Round only the left corners of the left section */
}

.header {
    display: flex;
    flex-direction: column; /* Align items in a column */
    align-items: center; /* Center items horizontally */
}

.logo {
    max-width: 150px; /* Adjust as needed */
    height: auto;
    margin-bottom: 1px; /* Add margin between logo and text */
}

.welcome-message {
    text-align: center;
}

.bold {
    font-family: 'Arial', sans-serif; /* Set your desired font family */
    font-size: 24px; /* Adjust the font size as needed */
    font-weight: bold; /* Set the font weight to bold */
    color: #333; /* Set the text color */
}

.form {
    margin-top: 20px;
    
}

.field {
    margin-bottom: 15px;
}

label {
    display: block;
    margin-bottom: 5px;
}

.field input {
    width: 100%; /* Adjust the width as needed */
    height: 42px;
    padding: 5px;
    background-color: #f7f7f7e8; /* Set the background color to gray */
    border: none; /* Remove borders on all sides */
    border-radius: 5px; /* Add border-radius for rounded corners */
    outline: none; /* Remove outline on focus */
}
.field input:focus + label,
.field input:placeholder-shown + label {
    top: 0;
    font-size: 12px;
}
.field input::placeholder {
    color: #999; /* Set the color for the placeholders */
    font-style: italic; /* Optionally set the font style to italic */
}

.forgot-password {
    display: block;
    font-size: 14px;
    margin-top: 5px;
}

.field.button input[type="submit"] {
    background-color: #27225f; /* You can change this color code to the blue shade you prefer */
    color: #fff;
}

.signup-link {
    text-align: center;
}

.sign-up-button {
    color: #27225f;
    font-weight: bold;
    text-decoration: underline;
    cursor: pointer;
}

.right-section {
    text-align: center;
    overflow: hidden; /* Hide overflow content (like rounded corners) */
}

.image-container {
    position: relative;
}

.right-section img {
    max-width: 100%;
    height: auto;
    border-radius: 2px; /* Border-radius for the image */
    display: block; /* Remove extra spacing caused by inline elements */
}

.container {
    display: flex;
    width: 50%;
    margin: 50px auto;
    background-color: #ffffff;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    overflow: hidden;
}

.left-section {
    flex: 1;
    padding: 20px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.right-section {
    flex: 1;
    overflow: hidden;
}

.image-container {
    height: 100%;
}

.image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 10px;
    transition: transform 0.5s ease;
}

.image-container:hover img {
    transform: scale(1.1);
}
  </style>
  <div class="wrapper">
    <section class="form login">
      <header>Realtime Chat App</header>
      <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="error-text"></div>
        <div class="field input">
          <label>Email Address</label>
          <input type="text" name="email" placeholder="Enter your email" required>
        </div>
        <div class="field input">
          <label>Password</label>
          <input type="password" name="password" placeholder="Enter your password" required>
          <i class="fas fa-eye"></i>
        </div>
        <div class="field button">
          <input type="submit" name="submit" value="Continue to Chat">
        </div>
      </form>
      <div class="link">Not yet signed up? <a href="index.php">Signup now</a></div>
    </section>
  </div>
  
  <script src="javascript/pass-show-hide.js"></script>
  <script src="javascript/login.js"></script>

</body>
</html>
