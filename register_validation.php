<?php

$errors = [];
$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = htmlspecialchars($_POST['first_name'] ?? '');
    $lastName = htmlspecialchars($_POST['last_name'] ?? '');
    $address = htmlspecialchars($_POST['address'] ?? '');
    $country = htmlspecialchars($_POST['country'] ?? '');
    $gender = htmlspecialchars($_POST['gender'] ?? '');
    $skills = $_POST['skills'] ?? [];
    $username = htmlspecialchars($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $department = htmlspecialchars($_POST['department'] ?? '');
    $captcha = htmlspecialchars($_POST['captcha'] ?? '');

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
    if ($captcha !== 'polish') $errors[] = "Invalid captcha";

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

        $formData = [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'address' => $address,
            'country' => $country,
            'gender' => $gender,
            'skills' => $skills,
            'username' => $username,
            'password' => $hashedPassword,
            'department' => $department,
            'profile_picture' => $imagePath
        ];

        $file = 'data.json';
        $existingData = [];

        if (file_exists($file)) {
            $jsonContent = file_get_contents($file);
            $existingData = json_decode($jsonContent, true) ?? [];
        }

        $existingData[] = $formData;
        file_put_contents($file, json_encode($existingData, JSON_PRETTY_PRINT));

        $successMessage = "Registration Successful. <a href='login.php'>login now</a>";
    }
}
