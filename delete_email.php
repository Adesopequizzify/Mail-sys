<?php
session_start();
require_once 'config.php';

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Retrieve the email, subject, and message with the given ID
    $query = "SELECT email, subject, message FROM sent_mail WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $email = $row['email'];
    $subject = $row['subject'];
    $message = $row['message'];

    // Delete the email with the given ID
    $deleteQuery = "DELETE FROM sent_mail WHERE id = $id";
    mysqli_query($conn, $deleteQuery);

    // Display the success message and animated icon
    $successMessage = 'Message deleted successfully.';
    $iconClass = 'fas fa-check-circle text-green-500 animate-bounce';
}
header("Location: sent_message.php");
    exit();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Message</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* CSS styles omitted for brevity */
        .icon {
            font-size: 24px;
            margin-right: 10px;
            animation-duration: 1s;
            animation-fill-mode: both;
        }

        .text-green-500 {
            color: #10B981;
        }

        .animate-bounce {
            animation-name: bounce;
            animation-iteration-count: infinite;
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(-25%);
            }
            50% {
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <?php if (isset($successMessage)) : ?>
            <div class="success-message">
                <i class="<?php echo $iconClass; ?>"></i>
                <?php echo $successMessage; ?>
            </div>
        <?php endif; ?>
        <!-- Rest of the code omitted for brevity -->
    </div>
</body>

</html>
