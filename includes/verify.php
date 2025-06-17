<?php
session_start();
if (empty($_SESSION['logged_in'])) {
    header('Location: ../index.html');
    exit();
}
?>