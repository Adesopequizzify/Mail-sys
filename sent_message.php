<?php
session_start();
require_once 'config.php';

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

// Retrieve the sent emails
$limit = 10; // Number of emails per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Count total number of emails
$countQuery = "SELECT COUNT(*) AS total FROM sent_mail";
$countResult = mysqli_query($conn, $countQuery);
$row = mysqli_fetch_assoc($countResult);
$totalEmails = $row['total'];

// Calculate total number of pages
$totalPages = ceil($totalEmails / $limit);

// Retrieve emails for the current page
$query = "SELECT * FROM sent_mail ORDER BY sent_at DESC LIMIT $offset, $limit";
$result = mysqli_query($conn, $query);

// Function to truncate long messages
function truncateMessage($message, $length) {
    if (strlen($message) > $length) {
        $truncatedMessage = substr($message, 0, $length) . '...';
    } else {
        $truncatedMessage = $message;
    }
    return $truncatedMessage;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sent Emails</title>
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

        .email-container {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .email-container:hover {
            background-color: rgba(255, 255, 255, 0.5);
        }

        .email-subject {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .email-info {
            font-size: 14px;
            color: #666;
        }

        .pagination {
            margin-top: 20px;
            text-align: center;
        }

        .pagination a {
            color: #000;
            text-decoration: none;
            padding: 8px 16px;
            transition: background-color 0.3s ease;
        }

        .pagination a:hover {
            background-color: #a0aec0;
        }

        .current-page {
            background-color: #718096;
            color: #fff;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border-radius: 10px;
            max-width: 600px;
        }

        .modal-close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .delete-icon {
            color: red;
            margin-left: 10px;
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
            <h1>Sent Emails</h1>
        </div>

        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <div class="email-container" onclick="openModal('<?php echo $row['email']; ?>', '<?php echo $row['subject']; ?>', '<?php echo $row['message']; ?>')">
                <div class="email-subject"><?php echo $row['subject']; ?></div>
                <div class="email-info">
                    <span><?php echo $row['email']; ?></span>
                    <span><?php echo $row['sent_at']; ?></span>
                    <i class="fas fa-trash delete-icon" onclick="deleteEmail(<?php echo $row['id']; ?>)"></i>
                </div>
                <div class="email-message"><?php echo truncateMessage($row['message'], 100); ?></div>
            </div>
        <?php endwhile; ?>

        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <a href="?page=<?php echo $i; ?>" <?php if ($i == $page) echo 'class="current-page"'; ?>><?php echo $i; ?></a>
            <?php endfor; ?>
        </div>

        <!-- Modal -->
        <div id="modal" class="modal">
            <div class="modal-content">
                <span class="modal-close" onclick="closeModal()">&times;</span>
                <div id="email-info"></div>
                <div id="email-message"></div>
            </div>
        </div>

        <script>
            function openModal(email, subject, message) {
                document.getElementById('email-info').innerHTML = "<strong>Email:</strong> " + email + "<br><strong>Subject:</strong> " + subject;
                document.getElementById('email-message').innerHTML = "<strong>Message:</strong> " + message;
                document.getElementById('modal').style.display = "block";
            }

            function closeModal() {
                document.getElementById('modal').style.display = "none";
            }

            function deleteEmail(id) {
                if (confirm("Are you sure you want to delete this email?")) {
                    window.location.href = "delete_email.php?id=" + id;
                }
            }
        </script>
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
