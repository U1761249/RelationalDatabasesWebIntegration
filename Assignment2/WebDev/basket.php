<?php
require 'header.php';
require 'includes/config.php';
session_start();

if(isset($_POST['clear'])){unset($_SESSION['basket']);}
if(!isset($_SESSION['basket'])){
    echo "Your basket is empty.";
    require 'footer.php';
}

else {

    echo '<td><form method=post><button type=submit name=clear /> Clear Basket </button><br/></form></td>';

   require 'includes/displayBasket.php';

    echo 'Total cost = £' . sizeof($_SESSION['basket'])*5.99 . ". ";
    echo 'Please click Purchase to complete this transaction. ';
    echo '  <nav>
                <a href="#"
            </nav>
            <ul>
                <li><a href="purchase.php">Purchase</a></li>
            </ul>';

    require 'footer.php';
}
if (isset($_POST['remove'])){
    for ($i = 0; $i < sizeof($_SESSION['basket']); $i++){
        if($_SESSION['basket'][$i] == $_POST['remove']){
            unset($_SESSION['basket'][$i]);
            header("Refresh:0");
            break;
        }
    }
}



