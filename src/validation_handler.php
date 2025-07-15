<?php
include 'db.php';
session_start();

// login validation
$loginError = '';
$loggedInUser = null;

if (isset($_POST["login"])) {
    $username = htmlspecialchars($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $loginError = 'Username and password are required';
        return;
    }

    $result = mysqli_query($conn, "SELECT username,hashedPassword FROM users WHERE username='$username'");
    $user = $result->fetch_assoc();
    mysqli_close($conn);

    if (password_verify($password, $user['hashedPassword'])) {
        $loggedInUser = $user;
        $_SESSION['user'] = $username;
    }

    if (!$loggedInUser) {
        $loginError = 'Invalid username or password';
    }
}

// registration validation

$errors = [];
$success = false;

if (isset($_POST["register"])) {
    $firstName = htmlspecialchars($_POST['first_name'] ?? '');
    $lastName = htmlspecialchars($_POST['last_name'] ?? '');
    $address = htmlspecialchars($_POST['address'] ?? '');
    $country = htmlspecialchars($_POST['country'] ?? '');
    $gender = htmlspecialchars($_POST['gender'] ?? '');
    $skills = $_POST['skills'] ?? [];
    $username = htmlspecialchars($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $department = htmlspecialchars($_POST['department'] ?? '');

    // input validation
    if ($firstName === '') $errors[] = "First name is required";
    if ($lastName === '') $errors[] = "Last name is required";
    if ($address === '') $errors[] = "Address is required";
    if ($country === '') $errors[] = "Country is required";
    if (!in_array($gender, ['Male', 'Female'])) $errors[] = "Gender must be selected";
    if (!is_array($skills) || count($skills) === 0) $errors[] = "At least one skill must be selected";
    if ($username === '') $errors[] = "Username is required";
    if (strlen($password) < 6) $errors[] = "Password must be at least 6 characters long";
    if ($department === '') $errors[] = "Department is required";

    // profile picture validation
    $imagePath = '';
    if (!isset($_FILES['profile_image'])) {
        $errors[] = "Profile image is missing in request.";
    } elseif ($_FILES['profile_image']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "An error occurred during file upload (code: " . $_FILES['profile_image']['error'] . ")";
    } else {
        $imageTmpPath = $_FILES['profile_image']['tmp_name'];
        $imageName = basename($_FILES['profile_image']['name']);
        $imageExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png'];

        if (!in_array($imageExtension, $allowedExtensions)) {
            $errors[] = "Only JPG, JPEG, and PNG files are allowed";
        } else {
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $newImageName = uniqid('avatar_') . '.' . $imageExtension;
            $imagePath = $uploadDir . $newImageName;

            if (!move_uploaded_file($imageTmpPath, $imagePath)) {
                $errors[] = "Upload failed: unable to move file";
            }
        }
    }

    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $skillsData = implode(",", $skills);

        // add to db
        $query = "INSERT INTO users (firstName, lastName, address, country, gender, skills, username, hashedPassword, department, profile_picture)
        VALUES ('$firstName','$lastName','$address','$country','$gender','$skillsData','$username','$hashedPassword','$department','$newImageName')";
        $result = mysqli_query($conn, $query);
        if ($result) $success = true;
        mysqli_close($conn);
    }
}
