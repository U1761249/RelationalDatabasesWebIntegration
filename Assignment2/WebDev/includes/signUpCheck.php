<?php

if (isset($_POST['signup-Submit'])) {

    require 'config.php';

    $email = $_POST['newEmail'];
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];

//Error handling
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {    // Validate email is a valid email.
        header("Location: ../signup.php?error=invalidemail");
        exit();
    } elseif ($pass1 !== $pass2) {
        header("Location: ../signup.php?error=passworddiscrepency&email=" . $email);
        exit();
    }

    // Check if the email is available

    $findExistingSQL = "SELECT personid FROM fss_Person WHERE personemail = ?";
    $stmt = mysqli_prepare($conn, $findExistingSQL);

    if (!$stmt->bind_param("s", $email)) {
        header("Location: ../signup.php?error=sqlerror1");
        exit();
    } else {
        if (!$stmt->execute()) {
            header("Location: ../signup.php?error=sqlerror2");
            exit();
        } else {
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                header("Location: ../signup.php?error=emailtaken?email=$email");
                exit();
            } else {

                // Try to create the new account

                $newPersonSQL = "INSERT INTO fss_Person (personname, personphone, personemail) VALUES (?,?,?)";
                $stmt = mysqli_prepare($conn, $newPersonSQL);

                $name = "REQUIRES DATA";
                $phone = "00000000000";

                if (!$stmt->bind_param("sss", $name, $phone, $email)) {
                    header("Location: ../signup.php?error=sqlerror3");
                    exit();
                } else {
                    if (!$stmt->execute()) {
                        header("Location: ../signup.php?error=sqlerror4");
                        exit();
                    } else {
                        //Get new person's personid

                        $findExistingSQL = "SELECT personid, personname FROM fss_Person WHERE personemail = ?";
                        $stmt = mysqli_prepare($conn, $findExistingSQL);

                        if (!$stmt->bind_param("s", $email)) {
                            header("Location: ../signup.php?error=sqlerror5");
                            exit();
                        } else {
                            if (!$stmt->execute()) {
                                header("Location: ../signup.php?error=sqlerror6");
                                exit();
                            } else {
                                $result = mysqli_stmt_get_result($stmt);
                                $row = mysqli_fetch_assoc($result);

                                if ($row['personid'] == null) {
                                    header("Location: ../signup.php?error=sqlerror7");
                                    exit();
                                } else {

                                    //Add customer to fss_Customer
                                    $id = (int) $row['personid'];
                                    $hashPass = password_hash($pass1, PASSWORD_DEFAULT);
                                    $currentDate = (string) date("Y-m-d");
                                    $defaultDate = date("Y-m-d", strtotime("2000-01-01"));
                                    $stmt = mysqli_prepare($conn,
                                        "INSERT INTO fss_Customer (custid, custregdate, custendreg, custpassword) VALUES (?,?,?,?)");

                                    if (!$stmt->bind_param("isss", $id, $currentDate, $defaultDate, $hashPass)) {
                                        header("Location: ../signup.php?error=sqlerror8");
                                        exit();
                                    }
                                    else {
                                        if (!$stmt->execute()) {
                                            header("Location: ../signup.php?error=sqlerror9");
                                            exit();
                                        }
                                        else {
                                            session_start();

                                            if (!session_start()) die('Cannot start session');

                                            else {
                                                $_SESSION['userId'] = (int)$row['personid'];
                                                $_SESSION['userName'] = $row['personname'];

                                                header("Location: ../account.php?registration=success");
                                                exit();
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
else {header("Location: ../signup.php?");
    exit();}

