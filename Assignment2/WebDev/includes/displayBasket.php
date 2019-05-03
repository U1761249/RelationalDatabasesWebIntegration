<?php
session_start();
echo '
    <style>
    table, th, td {
        border: 1px solid black;
    }
    </style>
    
    <table>
    
    <col width="250">
    <col width="50">
    <col width="50">
    
    <tr>
        <th><a href="?orderBy=filmtitle">Title:</a></th>
        <th><a href="?orderBy=filmrating">Rating:</a></th>
        <th>Price:</th>
        <th></th>
    </tr>
<tbody>';


foreach ($_SESSION['basket'] as $filmid){
    $stmt = mysqli_prepare($conn,
        "SELECT filmtitle, filmrating from fss_Film INNER JOIN fss_Rating ON fss_Film.ratid = fss_Rating.ratid WHERE filmid=?");
    if (!$stmt->bind_param("i", $filmid)) {
        header("Location: ../index.php?error=sqlerror1");
        exit();
    }
    else {
        if (!$stmt->execute()) {
            header("Location: ../index.php?error=sqlerror2");
            exit();
        }
        else {
            $result = mysqli_stmt_get_result($stmt);
            $row = $result->fetch_assoc();
            echo "<tr>
                    <td>" . $row['filmtitle'] . "</td>
                    <td>" . $row['filmrating'] . "</td>
                    <td>£5.99</td>
                    <td><form method=post><button type=submit name=remove  value=$filmid /> Remove </button><br/></form></td>
                </tr>";
        }
    }
}