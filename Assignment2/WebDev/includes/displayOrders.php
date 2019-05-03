<?php

$orderBy = array('filmtitle','price','addstreet','addcity','addpostcode','paydate','ctype','cno','cexpr');
$order = null;
if (isset($_GET['orderBy']) && in_array($_GET['orderBy'], $orderBy)) {
    $order = $_GET['orderBy'];

    $orderQuery = 'SELECT filmtitle, price, addstreet, addcity, addpostcode, paydate, ctype, cno, cexpr FROM fss_OnlinePurchase 
                  INNER JOIN fss_FilmPurchase ON fss_OnlinePurchase.fpid = fss_FilmPurchase.fpid
                  INNER JOIN fss_Address ON fss_OnlinePurchase.addid = fss_Address.addid
                  INNER JOIN fss_CustomerAddress ON fss_Address.addid = fss_CustomerAddress.addid
                  INNER JOIN fss_Film ON fss_FilmPurchase.filmid = fss_Film.filmid
                  INNER JOIN fss_Payment ON fss_FilmPurchase.payid = fss_Payment.payid
                  INNER JOIN fss_CardPayment ON fss_FilmPurchase.payid = fss_CardPayment.payid
                  WHERE custid = ? ORDER BY ' .$order;
}
else {
    $orderQuery = "SELECT filmtitle, price, addstreet, addcity, addpostcode, paydate, ctype, cno, cexpr FROM fss_OnlinePurchase 
                  INNER JOIN fss_FilmPurchase ON fss_OnlinePurchase.fpid = fss_FilmPurchase.fpid
                  INNER JOIN fss_Address ON fss_OnlinePurchase.addid = fss_Address.addid
                  INNER JOIN fss_CustomerAddress ON fss_Address.addid = fss_CustomerAddress.addid
                  INNER JOIN fss_Film ON fss_FilmPurchase.filmid = fss_Film.filmid
                  INNER JOIN fss_Payment ON fss_FilmPurchase.payid = fss_Payment.payid
                  INNER JOIN fss_CardPayment ON fss_FilmPurchase.payid = fss_CardPayment.payid
                  WHERE custid = ?";
}
$stmt = mysqli_prepare($conn, $orderQuery);
if (!$stmt->bind_param("i",  $_SESSION['userId'])) {
    header("Location: index.php?error=sqlerror1");
    exit();
} else {
    if (!$stmt->execute()) {
        header("Location: index.php?error=sqlerror2");
        exit();
    }
    else{
        $orders = mysqli_stmt_get_result($stmt);
    }

}
if ($orders->num_rows > 0){
    echo '
    <main>
        <h1>Order History</h1>

        <table>
            <tr>
                <th><a href="?orderBy=filmtitle">Title:</a></th>
                <th><a href="?orderBy=price">Price:</a></th>
                <th><a href="?orderBy=addstreet">Street:</a></th>
                <th><a href="?orderBy=addcity">City:</a></th>
                <th><a href="?orderBy=addpostcode">Postcode:</a></th>
                <th><a href="?orderBy=paydate">Payment Date:</a></th>
                <th><a href="?orderBy=ctype">Card Type:</a></th>
                <th><a href="?orderBy=cno">Card Number:</a></th>
                <th><a href="?orderBy=cexpr">Card Exp Date:</a></th>
            </tr>
            <tbody>
            ';
    while ($row = $orders->fetch_assoc()) {

        $Title = $row['filmtitle'];
        $Price = $row['price'];
        $Street = $row['addstreet'];
        $City = $row['addcity'];
        $Postcode = $row['addpostcode'];
        $PaymentDate = $row['paydate'];
        $CardType = $row['ctype'];
        $CardNumber = $row['cno'];
        $CardExpDate = $row['cexpr'];

        echo "<tr>
                        <td>".$Title."</td><td>".$Price."</td><td>".$Street."</td>
                        <td>".$City."</td><td>".$Postcode."</td><td>".$PaymentDate."</td>
                        <td>".$CardType."</td><td>".$CardNumber."</td><td>".$CardExpDate."</td>
                    </tr>";
    }
    echo "</tbody></table>";
}
else {
    echo 'You have no items in your order history.';
}

echo '</main>';