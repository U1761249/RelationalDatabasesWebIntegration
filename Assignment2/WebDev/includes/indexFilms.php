<?php

// Set up the table of films
echo '
    <style>
    table, th, td {
        border: 1px solid black;
    }
    </style>
    
    <table>
    
    <col width="250">
    <col width="50">
    <col width="600">
    <col width="50">
    <col width="200">
    
    <tr>
        <th><a href="?orderBy=filmtitle">Title:</a></th>
        <th><a href="?orderBy=filmrating">Rating:</a></th>
        <th>Description:</th>
        <th>Price:</th>
        <th>PURCHASE:</th>
    </tr>
<tbody>';
$orderBy = array('filmtitle', 'filmrating');
$order = null;
if (isset($_GET['orderBy']) && in_array($_GET['orderBy'], $orderBy)) {
    $order = $_GET['orderBy'];

    $result = mysqli_query($conn,
        'SELECT filmid, filmtitle, filmrating, filmdescription from fss_Film INNER JOIN fss_Rating ON fss_Film.ratid = fss_Rating.ratid ORDER BY ' .$order);
}
else {
    $result = mysqli_query($conn,
        "SELECT filmid, filmtitle, filmrating, filmdescription from fss_Film INNER JOIN fss_Rating ON fss_Film.ratid = fss_Rating.ratid");
}

while ($row = $result->fetch_assoc()) {
    $id = $row['filmid'];

    echo "<tr>
            <td>".$row['filmtitle']."</td>
            <td>".$row['filmrating']."</td>
            <td>".$row['filmdescription']."</td>
            <td>£5.99</td>
            <td><form method=post><button type=submit name=buy  value=$id /> Buy </button><br/></form></td>";
    echo "</tr>";
}

if (isset($_POST['buy'])){
    if (!isset($_SESSION['userName'])){
        $message = "You must sign in first.";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
    else{
        $toAdd = (int) $_POST['buy'];
        if (!isset($_SESSION['basket'])) {
            $_SESSION['basket'] = array();
            $message = "New Basket was created";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
        array_push($_SESSION['basket'], $toAdd);
        $message = "Film was added to the basket.";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }

}


echo '</tbody></table></main>';





