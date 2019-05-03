<?php

if (isset($_POST['login-Submit'])){

    require 'config.php';

    $email = $_POST['email'];
    //$email = "TestData@home.co.uk";
    $pass = $_POST['password'];
    //$pass = "pass";


    $personSQL = "SELECT personid, personname, personemail, custpassword FROM fss_Person 
                    INNER JOIN fss_Customer ON personid = custid && personemail = ?";
    $stmt = mysqli_prepare($conn, $personSQL);

    if (!$stmt->bind_param("s", $email)) {
        header("Location: ../index.php?error=sqlerror1");
        exit();
    }
    else {
        if (!$stmt->execute()) {
            header("Location: ../index.php?error=sqlerror2");
            exit();
        }
        else {
            $result = mysqli_stmt_get_result($stmt);

            if (!$row = mysqli_fetch_assoc($result)) {
                header("Location: ../index.php?error=invaliddetails1"); // No rows of that email found
                exit();
            } else {

                $passCheck = password_verify($pass, $row['custpassword']);
                if (!$passCheck){
                    header("Location: ../index.php?error=invaliddetails2"); // Invalid password for that email
                    exit();
                }
                else {

                    session_start();

                    if (!session_start()) die('Cannot start session');

                    else{
                        $_SESSION['userId'] = (int) $row['personid'];
                        $_SESSION['userName'] = $row['personname'];

                        header("Location: ../index.php?signin=success?username=" . $row['personname']);
                        exit();
                    }
                }
            }
        }
    }
}
else {  // Invalid method used to get to this page
    header("Location: ../index.php?");
    exit();
}