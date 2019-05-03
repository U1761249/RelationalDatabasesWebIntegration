<?php
require 'config.php';
session_start();

$pass1 = $_POST['pass1'];
$pass2 = $_POST['pass2'];

if ($pass1 !== $pass2) {
    header("Location: ../changePassword.php?error=passworddiscrepency");
    exit();
}
else{
    $hashPass = password_hash($pass1, PASSWORD_DEFAULT);
    $stmt = mysqli_prepare($conn,
        "UPDATE fss_Customer SET custpassword = ? WHERE custid = ?");

    if (!$stmt->bind_param("si",  $hashPass, $_SESSION['userId'])) {
        header("Location: ../signup.php?error=sqlerror8");
        exit();
    }
    else {
        if (!$stmt->execute()) {
            header("Location: ../signup.php?error=sqlerror9");
            exit();
        }
        else{
            header('Location: ../index.php?update=success');
            exit();
        }
    }
}