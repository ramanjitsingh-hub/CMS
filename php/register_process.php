<?php

$conn = mysqli_connect("localhost", "root", "", "cms");
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"]; 
    
    $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
    mysqli_query($conn, $query);
  
    
    header("Location: ../pages/login/login.html");
    exit();
  }
?>