<?php
require 'header.php';
require 'includes/config.php';
session_start();

if(sizeof($_SESSION['basket']) == 0 || !isset($_SESSION['basket'])){
    header('Location: index.php');
}
else {
    echo 'Total cost = £' .sizeof($_SESSION['basket']) * 5.99. ". ";
    echo '
    <main>
        <form action="includes/purchaseBasket.php" method ="post">
            <input type="text" name="cno" placeholder="Card number" required>
            <input type="text" name="ctype" placeholder="Card Type" required>
            <input type="month" name="cexpr" placeholder="Card Expiry Date" required>
            <button type="submit" name="confirm_card_details">Confirm Card Details</button>
        </form>
    </main>
    ';

    require 'includes/getAddress.php';
}

require 'footer.php';