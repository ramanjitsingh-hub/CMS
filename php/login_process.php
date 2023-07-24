<?php
// Start the session (if not already started)
session_start();

// Check if the login form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Replace 'your_db_host', 'your_db_user', 'your_db_password', and 'your_db_name' with your actual database credentials
  $connection = mysqli_connect("localhost", "root", "", "cms");

  // Get the submitted username and password
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Validate user credentials and fetch user data from the database using prepared statements
  $query = "SELECT id FROM users WHERE username = ? AND password = ?";
  $statement = mysqli_prepare($connection, $query);
  mysqli_stmt_bind_param($statement, 'ss', $username, $password);
  mysqli_stmt_execute($statement);
  mysqli_stmt_store_result($statement);

  if (mysqli_stmt_num_rows($statement) === 1) {
    mysqli_stmt_bind_result($statement, $userId);
    mysqli_stmt_fetch($statement);

    // Successful login: Store the user ID in the session
    $_SESSION['user_id'] = $userId;
    $_SESSION['username'] = $username;


    // Redirect the user to the dashboard or any other desired page
    header("Location: dash.php");
    exit;
  } else {
    // Invalid credentials, redirect back to the login page with an error message
    echo "eroor"; // You can customize the error parameter as needed
    exit;
  }

  mysqli_stmt_close($statement);
  mysqli_close($connection);
}
?>
