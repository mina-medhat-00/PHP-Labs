<?php
session_start();

$userData = null;
if (isset($_SESSION['user'])) {
    $username = $_SESSION['user'];
    $file = 'data.json';

    if (file_exists($file)) {
        $jsonContent = file_get_contents($file);
        $users = json_decode($jsonContent, true);

        foreach ($users as $user) {
            if ($user['username'] === $username) {
                $userData = $user;
                break;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="./assets/style.css">
    <title>Profile</title>
</head>

<body>

    <nav>
        <a href="register.php">Register</a>
        <a href="login.php">Login</a>
        <a href="profile.php">Profile</a>
        <a href="users.php">Users</a>
        <a href="logout.php">Logout</a>
    </nav>

    <main>
        <h2>Profile</h2>

        <?php if ($userData): ?>
            <p><strong>Welcome, <?= htmlspecialchars($userData['first_name']) ?>!</strong></p>
            <img src="<?= htmlspecialchars($userData['profile_picture']) ?>" alt="Profile Picture">
            <ul>
                <li><strong>Full Name:</strong> <?= htmlspecialchars($userData['first_name'] . ' ' . $userData['last_name']) ?></li>
                <li><strong>Address:</strong> <?= htmlspecialchars($userData['address']) ?></li>
                <li><strong>Country:</strong> <?= htmlspecialchars($userData['country']) ?></li>
                <li><strong>Gender:</strong> <?= htmlspecialchars($userData['gender']) ?></li>
                <li><strong>Skills:</strong> <?= htmlspecialchars(implode(', ', $userData['skills'])) ?></li>
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