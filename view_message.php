<?php
session_start();

// Check if the username is set in the session
if (!isset($_SESSION["username"])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Include the config.php file for database connection
require_once "config.php";

// Pagination settings
$perPage = 4;
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($currentPage - 1) * $perPage;

// Retrieve messages from the database
$query = "SELECT * FROM contact_messages ORDER BY sent_at DESC LIMIT $start, $perPage";
$result = mysqli_query($conn, $query);
$messages = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Count total messages for pagination
$totalQuery = "SELECT COUNT(*) as total FROM contact_messages";
$totalResult = mysqli_query($conn, $totalQuery);
$totalMessages = mysqli_fetch_assoc($totalResult)['total'];
$totalPages = ceil($totalMessages / $perPage);

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Messages</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* CSS styles omitted for/* CSS styles for view_message.php */

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

.welcome {
    font-size: 24px;
    color: #000;
    margin-bottom: 10px;
}

.messages {
    margin-bottom: 20px;
}

.message {
    background-color: #fff;
    border-radius: 10px;
    padding: 10px;
    margin-bottom: 20px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.message-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.message-email {
    font-size: 18px;
    font-weight: bold;
    color: #000;
}

.message-name {
    font-size: 16px;
    color: #000;
}

.message-content {
    font-size: 16px;
    color: #000;
    margin-bottom: 10px;
}

.message-reply a {
    color: #000;
    text-decoration: none;
}

.message-reply a:hover {
    color: #a0aec0;
}

.pagination {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}

.pagination a,
.pagination span {
    display: inline-block;
    padding: 5px 10px;
    margin-right: 5px;
    background-color: #a0aec0;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    cursor: pointer;
}

.pagination a:hover {
    background-color: #718096;
}

.current-page {
    background-color: #4a5568;
}

.navigation {
    text-align: center;
    margin-bottom: 20px;
}

.navigation a {
    color: #000;
    text-decoration: none;
    transition: color 0.3s ease;
}
/* CSS styles for view_message.php */

.container {
    /* Existing container styles */
}

.messages {
    margin-bottom: 20px;
}

.message {
    background-color: #fff;
    border-radius: 10px;
    padding: 10px;
    margin-bottom: 20px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.message-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.message-name {
    font-size: 16px;
    font-weight: bold;
    color: #000;
}

.message-email {
    display: none;
}

.message-content {
    font-size: 16px;
    color: #000;
    margin-bottom: 10px;
}

.message-reply a {
    color: #000;
    text-decoration: none;
}

.message-reply a:hover {
    color: #a0aec0;
}

.pagination {
    /* Existing pagination styles */
}

.current-page {
    /* Existing current page styles */
}

.navigation {
    /* Existing navigation styles */
}

.logout {
    /* Existing logout styles */
}



    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="welcome">Welcome, <?php echo $_SESSION["username"]; ?></div>
        </div>

<div class="messages">
    <?php foreach ($messages as $message) : ?>
        <div class="message">
            <div class="message-info">
                <div class="message-name"><?php echo $message['name']; ?></div>
                <div class="message-email"><?php echo $message['email']; ?></div>
            </div>
            <div class="message-content">
                <div class="message-text"><?php echo $message['message']; ?></div>
            </div>
            <div class="message-reply">
                <a href="reply.php?email=<?php echo $message['email']; ?>">
                    <i class="fas fa-reply"></i>
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</div>


        <div class="pagination">
            <?php if ($currentPage > 1) : ?>
                <a href="view_message.php?page=<?php echo ($currentPage - 1); ?>">Previous</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <?php if ($i == $currentPage) : ?>
                    <span class="current-page"><?php echo $i; ?></span>
                <?php else : ?>
                    <a href="view_message.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($currentPage < $totalPages) : ?>
                <a href="view_message.php?page=<?php echo ($currentPage + 1); ?>">Next</a>
            <?php endif; ?>
        </div>

        <div class="navigation">
            <a href="index.php">
                <i class="fas fa-arrow-left"></i>
                Back
            </a>
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
