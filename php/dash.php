<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../pages/dash/dashboard_styles.css">
  <title>Researcher Dashboard</title>
</head>
<body>
  <div class="header">
    <h1>Welcome, Researcher!</h1>
    <a href="../../php/logout.php">Logout</a>
  </div>
  <div class="container">
    <div class="sidebar">
      <h2>Dashboard Navigation</h2>
      <ul>
        <li><a href="#papers">My Papers</a></li>
        <li><a href="#collaboration">Collaboration</a></li>
        <li><a href="#tasks">Tasks</a></li>
        <!-- Add more navigation links for other functionalities -->
      </ul>
    </div>
    <div class="main-content">
      <section id="papers">
        <h2>My Papers</h2>
        <p>Here, you can manage your research papers and add notes or annotations.</p>
        <div class="upload-paper-container">
          <label for="paper_file" class="custom-file-label">Choose a file</label>
          <input type="file" id="paper_file" name="paper_file" accept=".pdf,.doc,.docx" />
          <button class="upload-button">Upload Paper</button>
        </div>
        
        <h3>Uploaded Papers:</h3>


        <?php
        session_start();
        $connection = mysqli_connect("localhost", "root", "", "cms");
        
        
        // Fetch the papers from the database for the current user
        if (isset($_SESSION['user_id'])) {
          $userId = $_SESSION['user_id'];
          $query = "SELECT * FROM papers WHERE user_id = ?";
          $statement = mysqli_prepare($connection, $query);
          mysqli_stmt_bind_param($statement, 'i', $userId);
          mysqli_stmt_execute($statement);
          $result = mysqli_stmt_get_result($statement);
        
          while ($row = mysqli_fetch_assoc($result)) {
            $fileExtension = strtolower($row['file_extension']);
            $iconPath = '../icons/' . ($fileExtension === 'pdf' ? 'pdf.png' : 'doc.png');
            echo '<div class="paper-item">';
            echo '<img src="' . $iconPath . '" alt="Paper Icon">';
            echo '<a href="download_paper.php?id=' . $row['id'] . '">' . $row['file_name'] . '</a>';
            echo '</div>';
          }
        
          mysqli_stmt_close($statement);
        }
        mysqli_close($connection);
        ?>
      </section>
      <section id="collaboration">
        <h2>Collaboration</h2>
        <!-- Implement collaboration features -->
        <p>Collaborate with other researchers by sharing papers and annotations.</p>
      </section>
      <section id="tasks">
        <h2>Tasks</h2>
        <!-- Implement task management features -->
        <p>Keep track of your research-related tasks and deadlines.</p>
      </section>
      <!-- Add more sections for other functionalities -->
    </div>
  </div>
</body>
</html>
