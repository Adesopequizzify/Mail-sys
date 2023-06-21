<?php
session_start();
require_once 'config.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';
require_once 'PHPMailer/src/Exception.php';

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

// Retrieve the email address from the query parameter
$email = $_GET["email"] ?? '';

// Initialize variables
$subject = '';
$message = '';
$successMessage = '';
$errorMessage = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Validate form data
    if (empty($subject) || empty($message)) {
        $errorMessage = 'Please fill in all fields.';
    } else {
        // Prepare the email content
        $name = $_SESSION["username"];
        $mailContent = "<strong>$name</strong><br>";
        $mailContent .= "<p>$message</p>";

        // Send the email
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        try {
            // Configure SMTP settings
            $mail->isSMTP();
            $mail->Host = 'mail.quizzify.com.ng'; // Replace with your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'adesope@quizzify.com.ng'; // Replace with your email address
            $mail->Password = 'Adeniyi20#'; // Replace with your email password
            $mail->Port = 465; // Replace with your SMTP port
            $mail->SMTPSecure = 'ssl';

            // Set the email content
            $mail->setFrom('Adesope@quizzify.com.ng', 'Adesope Muiz'); // Replace with your email address and name
            $mail->addAddress($email); // Set the recipient email address

            // Save the sent email to the database
            $sql = "INSERT INTO sent_mail (email, subject, message) VALUES ('$email', '$subject', '$message')";
            mysqli_query($conn, $sql);

            // Send the email
            $mail->Subject = $subject;
            $mail->Body = $mailContent;
            $mail->isHTML(true);
            $mail->send();

            $successMessage = 'Mail sent successfully.';
        } catch (Exception $e) {
            $errorMessage = 'Mail was not sent. Please try again later.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reply</title>
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

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-size: 16px;
            font-weight: bold;
            color: #000;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .button {
            background-color: rgba(255, 255, 255, 0.25);
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            margin-top: 10px;
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

        .back-button {
            text-align: center;
            margin-top: 20px;
        }

        .back-button a {
            color: #000;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .back-button a:hover {
            color: #a0aec0;
        }

        .success-message {
            color: green;
            margin-top: 10px;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Reply to Message</h1>
        </div>

        <?php if (!empty($successMessage)) : ?>
            <div class="success-message">
                <?php echo $successMessage; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($errorMessage)) : ?>
            <div class="error-message">
                <?php echo $errorMessage; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="subject">Subject:</label>
                <input type="text" id="subject" name="subject" value="<?php echo $subject; ?>">
            </div>

            <div class="form-group">
                <label for="message">Message:</label>
                <textarea id="message" name="message"><?php echo $message; ?></textarea>
            </div>

            <button type="submit" class="button">
                <i class="fas fa-paper-plane"></i>
                Send
            </button>
        </form>

        <div class="back-button">
            <a href="view_message.php">
                <i class="fas fa-arrow-left"></i>
                Back
            </a>
        </div>
    </div>
</body>

</html>
