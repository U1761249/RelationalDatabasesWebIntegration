<?php

require "header.php";

echo '<main><h1>Personal Details</h1>';
session_start();

if(isset($_POST['changeDetails'])){
    header("Location: account.php");
}

if (!isset($_GET['error'])){
    if ($_GET['error'] == "accountundefined"){
        echo '<p>You must sign in first.</p>';
    }
}

?>
    <main>
        <form action="includes/alterPassword.php" method ="post">
            <input type="password" name="pass1" placeholder="Password" required>
            <input type="password" name="pass2" placeholder="Confirm Password" required>
            <button type="submit" name="set-changes">Confirm Changes</button>
        </form>
    </main>
    <td><form method=post><button type=submit name=changeDetails /> Change Details </button><br/></form></td>


<?php
require "footer.php";
?>