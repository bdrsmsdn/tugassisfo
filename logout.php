<?php
session_start();
$_SESSION["username"]='';
$_SESSION["nama_pegawai"]='';

unset($_SESSION["username"]);
unset($_SESSION["nama_pegawai"]);

session_unset();
session_destroy();
header("Location: index.php");