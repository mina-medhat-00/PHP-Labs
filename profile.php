<?php
include './src/db.php';
session_start();

$userData = null;
if (isset($_SESSION['user'])) {
    $username = $_SESSION['user'];
    $result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    $userData = $result->fetch_assoc();
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./styles/style.css">
    <title>Profile</title>
</head>

<body>

    <nav>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
    </nav>

    <main>
        <h2>Profile</h2>

        <?php if ($userData): ?>
            <p><strong>Welcome, <?= htmlspecialchars($userData['firstName']) ?></strong></p>
            <img src="<?= htmlspecialchars($userData['profile_picture']) ?>" alt="Profile Picture">
            <ul>
                <li><strong>Full Name:</strong> <?= htmlspecialchars($userData['firstName'] . ' ' . $userData['lastName']) ?></li>
                <li><strong>Address:</strong> <?= htmlspecialchars($userData['address']) ?></li>
                <li><strong>Country:</strong> <?= htmlspecialchars($userData['country']) ?></li>
                <li><strong>Gender:</strong> <?= htmlspecialchars($userData['gender']) ?></li>
                <li><strong>Skills:</strong> <?= htmlspecialchars($userData['skills']) ?></li>
                <li><strong>Username:</strong> <?= htmlspecialchars($userData['username']) ?></li>
                <li><strong>Department:</strong> <?= htmlspecialchars($userData['department']) ?></li>
            </ul>
        <?php elseif (isset($_SESSION['user'])): ?>
            <p>User not found</p>
        <?php else: ?>
            <p>You must login first <a href="login.php">Login</a></p>
        <?php endif; ?>
    </main>

</body>

</html>