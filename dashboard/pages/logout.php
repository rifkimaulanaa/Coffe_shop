<?php
// Mulai session
session_start();

session_destroy();

header('Location: sign-in.php');
?>