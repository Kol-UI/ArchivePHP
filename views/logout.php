<?php

session_start();

require_once __DIR__ . '/../src/Manager/Pdo/PdoUserManager.php';

$user_manager = new PdoUserManager();


$user_manager->logout();

header('Location: login.php');