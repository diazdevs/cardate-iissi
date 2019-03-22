<?php
session_start();
 
require_once 'core/database.php';
require_once 'core/model.php';
require_once 'core/forms.php';
require_once 'core/controller.php';
require_once 'core/paginator.php';
require_once 'core/main.php';
require_once 'config/config.php';


$connection = new Database(); // PDO connection
$app = new App();
$connection->close(); // Close PDO connection
?>