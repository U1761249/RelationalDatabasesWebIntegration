<?php

require "header.php";
?>

<main>
    <h1>Signup</h1>
    <?php
    if (isset($_GET['error'])){
        if ($_GET['error'] == "sqlerror"){
            echo '<p>Something went wrong with the sql statement</p>';
        }
        else if ($_GET['error'] == "emailtaken"){
            echo '<p>That email is taken. Please select a new email.</p>';
        }
        else if ($_GET['error'] == "passworddiscrepency"){
            echo '<p>The Passwords provided don\'t match. Please enter matching passwords.</p>';
        }
        else if ($_GET['error'] == "invalidemail"){
            echo '<p>That email invalid. Please select a new email.</p>';
        }
    }
    ?>
    <form action="includes/signUpCheck.php" method="post">
        <input type="text" name="newEmail" value="<?php echo $_GET['email'] ?>" placeholder="Email" required>
        <input type="password" name="pass1" placeholder="Password" required>
        <input type="password" name="pass2" placeholder="Confirm password" required>
        <button type="submit" name="signup-Submit">Signup</button>
    </form>
</main>

<?php
require "footer.php";
?>
