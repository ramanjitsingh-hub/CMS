<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (isset($_FILES["paper_file"]) && isset($_SESSION['user_id'])) {
    $file = $_FILES["paper_file"];
    $fileName = basename($file["name"]);
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Check if the file is a valid document (pdf, doc, docx, etc.)
    $allowedExtensions = array('pdf', 'doc', 'docx');
    if (!in_array($fileExtension, $allowedExtensions)) {
      echo "Invalid file format. Only PDF, DOC, and DOCX files are allowed.";
      exit;
    }

    // Get the binary data of the uploaded file
    $fileData = file_get_contents($file["tmp_name"]);

    $connection =mysqli_connect("localhost", "root", "", "cms");

    // Insert the file data into the database along with the user ID
    $query = "INSERT INTO papers (user_id, file_name, file_data, file_extension) VALUES (?, ?, ?, ?)";
    $statement = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($statement, 'isss', $_SESSION['user_id'], $fileName, $fileData, $fileExtension);
    if (mysqli_stmt_execute($statement)) {
      echo "File uploaded and saved to the database successfully!";
      header("Location: dash.php");
    } else {
      echo "Error uploading file and saving to the database.";
    }
    mysqli_stmt_close($statement);
    mysqli_close($connection);
  } else {
    echo "No file uploaded or user session not available.";
  }
}
?>

