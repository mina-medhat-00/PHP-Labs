<?php
session_start();

if (!isset($_SESSION['user'])) {
    echo "<p>Login required <a href='login.php'>Login here</a>.</p>";
    exit;
}

$dataFile = 'data.json';
$users = [];

if (file_exists($dataFile)) {
    $json = file_get_contents($dataFile);
    $users = json_decode($json, true);
    if (!is_array($users)) {
        $users = [];
    }
} else {
    echo "<p>No data found.</p>";
    exit;
}
?>


<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="./assets/style.css">
    <title>Users</title>
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
        <h2>Registered Users</h2>

        <?php if (empty($users)) : ?>
            <p>No users registered yet.</p>
        <?php else : ?>
            <table>
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Address</th>
                        <th>Country</th>
                        <th>Gender</th>
                        <th>Skills</th>
                        <th>Username</th>
                        <th>Department</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['first_name']) ?></td>
                            <td><?= htmlspecialchars($user['last_name']) ?></td>
                            <td><?= htmlspecialchars($user['address']) ?></td>
                            <td><?= htmlspecialchars($user['country']) ?></td>
                            <td><?= htmlspecialchars($user['gender']) ?></td>
                            <td><?= htmlspecialchars(implode(", ", $user['skills'])) ?></td>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td><?= htmlspecialchars($user['department']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>

</body>

</html>