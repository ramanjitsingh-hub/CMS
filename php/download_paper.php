<?php
session_start();

if (isset($_GET['id']) && isset($_SESSION['user_id'])) {
  $paperId = $_GET['id'];
  $userId = $_SESSION['user_id'];

  // Replace 'your_db_host', 'your_db_user', 'your_db_password', and 'your_db_name' with your actual database credentials
  $connection = mysqli_connect("localhost", "root", "", "cms");

  // Fetch the file data from the database for the current user
  $query = "SELECT file_name, file_data, file_extension FROM papers WHERE id = ? AND user_id = ?";
  $statement = mysqli_prepare($connection, $query);
  mysqli_stmt_bind_param($statement, 'ii', $paperId, $userId);
  mysqli_stmt_execute($statement);
  mysqli_stmt_store_result($statement);

  if (mysqli_stmt_num_rows($statement) === 1) {
    mysqli_stmt_bind_result($statement, $fileName, $fileData, $fileExtension);
    mysqli_stmt_fetch($statement);

    // Provide the appropriate content type for the file
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $fileName . '.' . $fileExtension . '"');

    // Output the file data
    echo $fileData;
  } else {
    echo "You do not have permission to access this file.";
  }

  mysqli_stmt_close($statement);
  mysqli_close($connection);
}
?>
