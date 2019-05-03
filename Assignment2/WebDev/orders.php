<?php
require "header.php";
require 'includes/config.php';

session_start();
if (!isset($_SESSION['userId'])){
    header("Location: index.php?error=accountundefined");
    exit();
}
else {

    require 'includes/displayOrders.php';

}

require "footer.php";
