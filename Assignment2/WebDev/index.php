<?php
require "header.php";
require 'includes/config.php';


echo '<main><h1>Film Service</h1>';
session_start();
        if (isset($_SESSION['userId'])){
           $userName = $_SESSION['userName'];
            echo '<p>Welcome ' . $userName . '</p>';
        }
        else{
            echo '<p>Welcome guest user</p>';
        }

        require 'includes/indexFilms.php';

     require "footer.php";
?>
