<?php session_start();
    session_destroy();
    header("Location: /bc-login.php");
?>