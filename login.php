<?php
session_start();

$username = "Adesope";
$password = "1234muiz";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $enteredUsername = $_POST["username"];
    $enteredPassword = $_POST["password"];

    if ($enteredUsername === $username && $enteredPassword === $password) {
        // Set the username in the session
        $_SESSION["username"] = $username;
        // Redirect to the dashboard or another page on successful login
        header("Location: index.php");
        exit();
    } else {
        $error = "Incorrect password. Please try again.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Glassmorphism Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
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
            padding: 30px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .title {
            font-size: 24px;
            color: #000;
            margin-bottom: 10px;
        }

        .login-form {
            display: flex;
            flex-direction: column;
            border: 2px solid rgba(0, 0, 0, 0.2);
            /* Form border */
            padding: 20px;
            border-radius: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-size: 16px;
            color: #000;
            font-weight: bold;
        }

        .form-group input {
            padding: 10px;
            border: none;
            border-bottom: 2px solid rgba(0, 0, 0, 0.2);
            /* Underline border */
            background-color: rgba(255, 255, 255, 0.25);
            color: #000;
        }

        .form-group input:focus {
            outline: none;
            background-color: rgba(255, 255, 255, 0.5);
        }

        .submit-btn {
            background-color: rgba(255, 255, 255, 0.25);
            border: 2px solid rgba(0, 0, 0, 0.2);
            /* Button border */
            border-radius: 10px;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            align-self: center;
            display: flex;
            align-items: center;
        }

        .submit-btn i {
            margin-right: 10px;
        }

        .submit-btn:hover {
            background-color: rgba(255, 255, 255, 0.5);
        }

        .form-group .input-icon {
            position: relative;
        }

        .form-group .input-icon i {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 10px;
            color: rgba(0, 0, 0, 0.5);
        }

        .error-message {
            color: #FF0000;
            font-size: 14px;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="title">Login</div>
        </div>
        <form class="login-form" method="POST" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <div class="input-icon">
                    <i class="fas fa-user"></i>
                    <input type="text" id="username" name="username" required>
                </div>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" required>
                </div>
            </div>
            <button class="submit-btn" type="submit">
                <i class="fas fa-sign-in-alt"></i>Login
            </button>
            <p class="error-message"><?php echo $error; ?></p>
        </form>
    </div>
</body>

</html>
