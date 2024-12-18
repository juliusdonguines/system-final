<?php
require 'db.php'; // Include your database connection

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the data from the form
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $middlename = mysqli_real_escape_string($conn, $_POST['middlename']); // Add this
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $birthday = mysqli_real_escape_string($conn, $_POST['birthday']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $repassword = mysqli_real_escape_string($conn, $_POST['repassword']);

    // Check if passwords match
    if ($password !== $repassword) {
        echo "Passwords do not match!";
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if the email or username already exists
    $check_email_query = "SELECT * FROM users WHERE email = '$email' OR username = '$username'";
    $result = $conn->query($check_email_query);

    if ($result->num_rows > 0) {
        echo "Email or Username already exists!";
    } else {
        // Insert the new user into the database
        $query = "
            INSERT INTO users (firstname, middlename, lastname, username, birthday, email, password) 
            VALUES ('$firstname', '$middlename', '$lastname', '$username', '$birthday', '$email', '$hashed_password')";

        if ($conn->query($query) === TRUE) {
            echo "Registration successful!";
            // Optionally, redirect to login page or dashboard
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>
