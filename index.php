<?php
session_start();

// Check if the username is set in the session
if (!isset($_SESSION["username"])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Retrieve the username from the session
$username = $_SESSION["username"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
    /* CSS styles omitted for brevity */
  body {
      background-color: #F0F4F8;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
    }

    .container {
      background-color: rgba(255, 255, 255, 0.15);
      border-radius: 20px;
      padding: 50px; /* Increased padding */
      box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
    }

    .header {
      text-align: center;
      margin-bottom: 20px;
    }

    .welcome {
      font-size: 24px;
      color: #000;
      margin-bottom: 10px;
    }

    .username {
      font-size: 20px;
      color: #000;
      font-weight: bold;
    }

    .buttons {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-bottom: 40px;
    }

    .button {
      background-color: rgba(255, 255, 255, 0.25);
      border: none;
      border-radius: 10px;
      padding: 10px 20px;
      margin-bottom: 10px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      display: flex;
      align-items: center;
    }

    .button i {
      margin-right: 10px;
    }

    .button:hover {
      background-color: rgba(255, 255, 255, 0.5);
    }

    .logout {
      text-align: center;
    }

    .logout a {
      color: #000;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .logout a:hover {
      color: #a0aec0;
    }
    /* Rest of the CSS styles remain the same */
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <div class="welcome">Welcome,</div>
      <div class="username"><?php echo $username; ?></div>
    </div>
    <div class="buttons">
      <button onclick="window.location.href='view_message.php'"
    class="button">
        <i class="fas fa-envelope"></i>
        View Messages
      </button>
      <button onclick="window.location.href='send_message.php'" class="button">
        <i class="fas fa-paper-plane"></i>
        Send Message
      </button>
      <button onclick="window.location.href='sent_message.php'" class="button">
        <i class="fas fa-file-alt"></i>
        View Sent Messages
      </button>
    </div>
    <div class="logout">
      <a href="logout.php">
        <i class="fas fa-sign-out-alt"></i>
        Logout
      </a>
    </div>
  </div>
</body>

</html>
