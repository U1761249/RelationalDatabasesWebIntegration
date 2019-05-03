<?php
session_start();
require "header.php";
require 'includes/config.php';

echo '<main><h1>Personal Details</h1>';

if(isset($_POST['changePassword'])){
    header("Location: changePassword.php");
}

if (!isset($_GET['error'])){
    if ($_GET['error'] == "accountundefined"){
        echo '<p>You must sign in first.</p>';
    }
}

?>
    <main>
        <form action="includes/changeDetails.php" method ="post">
            <input type="text" name="name" placeholder="Name" required>
            <input type="text" name="phone" placeholder="Phone number" required>
            <input type="text" name="street" placeholder="Street and Number" required>
            <input type="text" name="city" placeholder="City" required>
            <input type="text" name="postcode" placeholder="Postcode" required>
            <button type="submit" name="set-changes">Confirm Changes</button>
        </form>
    </main>
    <td><form method=post><button type=submit name=changePassword /> Change Password </button><br/></form></td>


<?php
require "footer.php";
?>