<?php
require 'config.php';
session_start();

$cno = $_POST['cno'];
$ctype = $_POST['ctype'];
$cexpr = date("m:y", strtotime($_POST['cexpr']));

$SQL = "INSERT INTO fss_Payment (amount, paydate, shopid, ptid) VALUES(?,?,?,?);";
$stmt = mysqli_prepare($conn, $SQL);

$filmprice = 5.99;
$amount = sizeof($_SESSION['basket']) * $filmprice;
$paydate = (string)date("Y-m-d");
$shopid = 1;
$ptid = 2;

if (!$stmt->bind_param("dsii", $amount, $paydate, $shopid, $ptid)) {
    header("Location: ../index.php?error=sqlerror1");
    exit();
} else {
    if (!$stmt->execute()) {
        header("Location: ../index.php?error=sqlerror2");
        exit();
    } else {
        $payid = mysqli_insert_id($conn); // get the last inserted value
        if ($payid == null) {
            header("Location: ../index.php?error=sqlerror3");
            exit();
        } else {
            $SQL = "INSERT INTO fss_OnlinePayment(payid, custid) VALUES (?,?)";
            $stmt = mysqli_prepare($conn, $SQL);
            if (!$stmt->bind_param("ii", $payid, $_SESSION['userId'])) {
                header("Location: ../index.php?error=sqlerror4");
                exit();
            } else {
                if (!$stmt->execute()) {
                    header("Location: ../index.php?error=sqlerror5");
                    exit();
                } else {
                    $SQL = "INSERT INTO fss_CardPayment(payid, cno, ctype, cexpr) VALUES(?,?,?,?)";
                    $stmt = mysqli_prepare($conn, $SQL);
                    if (!$stmt->bind_param("iiss", $payid, $cno, $ctype, $cexpr)) {
                        header("Location: ../index.php?error=sqlerror6");
                        exit();
                    } else {
                        if (!$stmt->execute()) {
                            header('Location: ../index.php?error=sqlerror7?');
                            exit();
                        } else {
                            foreach ($_SESSION['basket'] as $filmid) {
                                $_SESSION['currentFilm'] = $filmid;
                                require 'purchaseBasketItems.php';
                                unset($_SESSION['currentFilm']);

                            }
                            unset($_SESSION['basket']);
                            header("Location: ../index.php");
                            exit();
                        }
                    }
                }
            }
        }
    }
}

