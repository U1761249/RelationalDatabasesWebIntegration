<?php
require 'config.php';
session_start();

        $SQL = "SELECT addstreet, addcity, addpostcode FROM fss_Address WHERE addid = (
                              SELECT addid FROM fss_CustomerAddress WHERE custid = ?)";
        $stmt = mysqli_prepare($conn, $SQL);
        if (!$stmt->bind_param("i", $_SESSION['userId'])) {
            header("Location: ../index.php?error=sqlerror");
            exit();
        }
        else {
            if (!$stmt->execute()) {
                header("Location: ../index.php?error=sqlerror");
                exit();
            } else {
                $result = mysqli_stmt_get_result($stmt);


                if (!$row = mysqli_fetch_assoc($result)){
                    $message = "You must have an address for your account";
                    echo "<script type='text/javascript'>alert('$message');</script>";
                    header("Location: ../account.php?");
                    exit();
                }
                else{
                    echo 'The address that the films will be delivered to is: '
                    . $row['addstreet'] . " "
                    . $row['addcity'] . " "
                    . $row['addpostcode'] . ".";
                    echo "  Please check this is correct before continuing - This can be changed within the Account page.";
                }


            }

    }