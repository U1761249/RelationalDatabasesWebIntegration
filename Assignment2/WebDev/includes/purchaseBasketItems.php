<?php
require 'config.php';
session_start();

$filmid = $_SESSION['currentFilm'];
$SQL = "INSERT INTO fss_FilmPurchase(payid, filmid, shopid, price) VALUES (?,?,?,?)";
$stmt = mysqli_prepare($conn, $SQL);
if (!$stmt->bind_param("iiid", $payid, $filmid, $shopid, $filmprice)) {
    header("Location: ../index.php?error=sqlerror9");
    exit();
} else {
    if (!$stmt->execute()) {
        header("Location: ../index.php?error=sqlerror10");
        exit();
    } else {
        $fpid = mysqli_insert_id($conn);

        $SQL = "SELECT addid FROM fss_CustomerAddress WHERE custid = ?";
        $stmt = mysqli_prepare($conn, $SQL);
        if (!$stmt->bind_param("i", $_SESSION['userId'])) {
            header("Location: ../index.php?error=sqlerror11");
            exit();
        } else {
            if (!$stmt->execute()) {
                header("Location: ../index.php?error=sqlerror12");
                exit();
            } else {
                $result = mysqli_stmt_get_result($stmt);

                if (!$row = mysqli_fetch_assoc($result)) {
                    header("Location: ../index.php?error=sqlerror13"); // No rows of that email found
                    exit();
                } else {
                    $addid = $row['addid'];
                    $SQL = "INSERT INTO fss_OnlinePurchase (fpid, addid) VALUES(?,?)";
                    $stmt = mysqli_prepare($conn, $SQL);
                    if (!$stmt->bind_param("ii", $fpid, $addid)) {
                        header("Location: ../index.php?error=sqlerror14");
                        exit();
                    } else {
                        if (!$stmt->execute()) {
                            echo $stmt->error;
                            exit();
                        }
                    }
                }
            }
        }
    }
}