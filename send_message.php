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

// Initialize variables
$to = '';
$subject = '';
$message = '';
$successMessage = '';
$errorMessage = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $to = $_POST['to'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $isHTML = isset($_POST['html']);

    // Validate form data
    if (empty($to) || empty($subject) || empty($message)) {
        $errorMessage = 'Please fill in all fields.';
    } else {
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
            $mail->addAddress($to); // Set the recipient email address
            $mail->isHTML($isHTML); // Set whether the email is HTML

            // Save the sent email to the database
            $sql = "INSERT INTO sent_mail (email, subject, message) VALUES ('$to', '$subject', '$message')";
            mysqli_query($conn, $sql);

            // Send the email
            $mail->Subject = $subject;
            $mail->Body = $message;
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
    <title>Send Message</title>
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
            padding: 50px;
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
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            resize: vertical;
        }

        .form-group .error-message {
            color: red;
            margin-top: 5px;
        }

        .success-message {
            text-align: center;
            color: green;
            margin-bottom: 10px;
        }

        .error-message {
            text-align: center;
            color: red;
            margin-bottom: 10px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4299e1;
            color: white;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }
        .back-button,
        .view-button {
          position: absolute;
          top: 10px;
          right: 10px;
          background-color: #4299e1;
          color: white;
          border: none;
          border-radius: 5px;
          padding: 10px 20px;
          font-size: 16px;
          cursor: pointer;
        }
        
        .back-button i,
        .view-button i {
          margin-right: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Send Message</h2>
        </div>
        <?php if (!empty($successMessage)) : ?>
            <div class="success-message">
                <i class="fas fa-check-circle"></i>
                <?php echo $successMessage; ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($errorMessage)) : ?>
            <div class="error-message">
                <i class="fas fa-times-circle"></i>
                <?php echo $errorMessage; ?>
            </div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="to">To:</label>
                <input type="email" id="to" name="to" value="<?php echo $to; ?>" required>
            </div>
            <div class="form-group">
                <label for="subject">Subject:</label>
                <input type="text" id="subject" name="subject" value="<?php echo $subject; ?>" required>
            </div>
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="5" required><?php echo $message; ?></textarea>
            </div>
            <div class="form-group">
                <input type="checkbox" id="html" name="html">
                <label for="html">Send as HTML</label>
            </div>
            <div class="form-group">
                <button type="submit" class="btn">Send</button>
            </div>
        </form>
        <a href="index.php" class="back-button">
            <i class="fas fa-arrow-left"></i>
            Back
        </a>
        <a href="view_message.php" class="view-button">
            <i class="fas fa-eye"></i>
            View Messages
        </a>
        <!-- Rest of the HTML code -->
    </div>
    </div>
</body>

</html>
