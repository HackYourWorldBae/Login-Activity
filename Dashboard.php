<?php session_start() ?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Welcome - Secure System</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <div class="landing-container">
    <div class="landing-box">
      <h1>🎉 <span id="welcomeMsg">Welcome! <?php echo $_SESSION['username'] ?></span></h1>
      <p>You have successfully logged in to the secure system.</p>
      <div class="landing-buttons">
      <?php echo '<a href="logout.php">Logout</a>'; ?>
      </div>
    </div>
  </div>
</body>
</html>
