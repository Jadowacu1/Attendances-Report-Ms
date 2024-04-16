<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('location:index.php');
} elseif ($_SESSION['type'] != 'student') {
    header('location:index.php');
}
