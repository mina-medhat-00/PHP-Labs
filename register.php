<?php include './src/validation_handler.php'; ?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./styles/style.css">
    <title>Register</title>
</head>

<body>

    <nav>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
    </nav>

    <main>
        <h2>Registration Form</h2>

        <?php if (!empty($errors)): ?>
            <div class="error-list">
                <h3>Errors:</h3>
                <ul>
                    <?php foreach ($errors as $err): ?>
                        <li><?= htmlspecialchars($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ($success):
            header("Location: login.php");
        endif; ?>

        <form name="register" method="POST" action="register.php" enctype="multipart/form-data">
            <div class="form-item">
                <label>First Name:</label>
                <input type="text" name="first_name" required>
            </div>
            <div class="form-item">
                <label>Last Name:</label>
                <input type="text" name="last_name" required>
            </div>
            <div class="form-item">
                <label>Address:</label>
                <textarea name="address" required></textarea>
            </div>
            <div class="form-item">
                <label>Country:</label>
                <select name="country" required>
                    <option value="">Select</option>
                    <option value="Egypt">Egypt</option>
                    <option value="Sudan">Sudan</option>
                    <option value="England">England</option>
                </select>
            </div>
            <div class="form-item">
                <label>Gender:</label>
                <input type="radio" name="gender" value="Male" required> Male
                <input type="radio" name="gender" value="Female"> Female
            </div>
            <div class="form-item">
                <label>Skills:</label>
                <input type="checkbox" name="skills[]" value="PHP"> PHP
                <input type="checkbox" name="skills[]" value="MySQL"> MySQL
                <input type="checkbox" name="skills[]" value="PostgreSQL"> PostgreSQL
                <input type="checkbox" name="skills[]" value="JavaScript"> JavaScript
            </div>
            <div class="form-item">
                <label>Username:</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-item">
                <label>Password:</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-item">
                <label>Department:</label>
                <input type="text" name="department" required>
            </div>
            <div class="form-item">
                <label>Profile Picture:</label>
                <input type="file" name="profile_image" accept="image/*" required>
            </div>
            <div class="form-item">
                <button type="submit" name="register">Submit</button>
                <button type="reset">Reset</button>
            </div>
        </form>
    </main>

</body>

</html>