<?php
require 'config.php';
session_start();
if (isset($_POST['set-changes'])) {

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $postcode = $_POST['postcode'];

    if (!isset($_SESSION['userId'])){
        header("Location: ../account.php?error=accountundefined");
        exit();
    }
    else {
        $personQuery = "UPDATE fss_Person SET personname = ?, personphone = ? WHERE personid = ?";
        $stmt = mysqli_prepare($conn, $personQuery);
        if (!$stmt->bind_param("ssi", $name, $phone, $_SESSION['userId'])) {
            header("Location: ../index.php?error=sqlerror1");
            exit();
        } else {
            if (!$stmt->execute()) {
                header("Location: ../index.php?error=sqlerror2");
                exit();
            }
            $addressQuery = "INSERT INTO fss_Address(addstreet, addcity, addpostcode) VALUES(?,?,?)";
            $stmt = mysqli_prepare($conn, $addressQuery);
            if (!$stmt->bind_param("sss", $street, $city, $postcode)) {
                header("Location: ../index.php?error=sqlerror3");
                exit();
            } else {
                if (!$stmt->execute()) {
                    header("Location: ../index.php?error=sqlerror4");
                    exit();
                }
                else{
                    //Get the new addressId
                    $addressIDQuery = "SELECT addid FROM fss_Address WHERE addstreet = ? AND addcity = ? AND addpostcode = ?";
                    $stmt = mysqli_prepare($conn, $addressIDQuery);
                    if (!$stmt->bind_param("sss", $street, $city, $postcode)) {
                        header("Location: ../index.php?error=sqlerror5");
                        exit();
                    }
                    else {
                        if (!$stmt->execute()) {
                            header("Location: ../index.php?error=sqlerror6");
                            exit();
                        }
                        else{
                            $result = mysqli_stmt_get_result($stmt);
                            $row = mysqli_fetch_assoc($result);
                            $addid =(int) $row['addid'];

                           $SQL = "SELECT addid, custid FROM fss_CustomerAddress WHERE custid = ?";
                            $stmt = mysqli_prepare($conn, $SQL);
                            if (!$stmt->bind_param("i", $_SESSION['userId'])) {
                                header("Location: ../index.php?error=sqlerror7");
                                exit();
                            }
                            else {
                                if (!$stmt->execute()) {
                                    header("Location: ../index.php?error=sqlerror8");
                                    exit();
                                } else {
                                    $result = mysqli_stmt_get_result($stmt);

                                    if (!$row = mysqli_fetch_assoc($result)){
                                        $customerAddressSQL = "INSERT INTO fss_CustomerAddress(addid, custid) VALUES (?,?)";
                                    }
                                    else{
                                        $customerAddressSQL = "UPDATE fss_CustomerAddress SET addid = ? WHERE custid = ?";
                                    }
                                    $stmt = mysqli_prepare($conn, $customerAddressSQL);
                                    if (!$stmt->bind_param("ii", $addid, $_SESSION['userId'])) {
                                        header("Location: ../index.php?error=sqlerror9");
                                        exit();
                                    }
                                    else {
                                        if (!$stmt->execute()) {
                                            header("Location: ../index.php?error=sqlerror10");
                                            exit();
                                        }
                                        else{
                                            header("Location: ../index.php?update=success");
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
else{header("Location: ../account.php?");
    exit();}