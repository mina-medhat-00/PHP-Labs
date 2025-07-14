<?php include 'login_validation.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="./assets/style.css">
    <title>Login</title>
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
        <h2>Login</h2>

        <?php if ($loginError): ?>
            <div class="error-list">
                <p><?= htmlspecialchars($loginError) ?></p>
            </div>
        <?php endif; ?>

        <?php if ($loggedInUser): ?>
            <?= header("Location: profile.php") ?>
        <?php else: ?>
            <form method="POST" action="login.php">
                <div class="form-item">
                    <label>Username:</label>
                    <input type="text" name="username" required>
                </div>
                <div class="form-item">
                    <label>Password:</label>
                    <input type="password" name="password" required>
                </div>

                <button type="submit" name="login">Login</button>
            </form>
        <?php endif; ?>
    </main>

</body>

</html>