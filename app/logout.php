<?php
session_start();
//unset($_SESSION['nama']);
//unset($_SESSION['unit']);
session_destroy();
header('Location: ../');
?>