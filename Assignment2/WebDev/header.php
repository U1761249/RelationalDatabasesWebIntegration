<!DOCTYPE html>
<html>

<body>

    <header>
    <nav>
        <a href="#"
    </nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="account.php">Account</a></li>
            <li><a href="orders.php">Orders</a></li>
            <li><a href="basket.php">Basket</a></li>
        </ul>
        <div class="header-login">
            <?php
            session_start();
            if (isset($_SESSION['userId'])){
                echo
                '<form action="includes/logout.php" method ="post">
                    <button type="submit" name="logout-Submit">Logout</button>
                </form>';
            }
            else {
                echo
                '
                <form action="includes/signInCheck.php" method ="post">
                    <input type="text" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit" name="login-Submit">Login</button>
                </form>
                <a href="signup.php">Signup</a>';
            }
            ?>


        </div>
        <?php echo "____________________________________________________________________________________________________"; ?>
    </header>