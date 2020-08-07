<?php
session_start();
session_destroy();
header('Location:login_main\login_main.php');
?>