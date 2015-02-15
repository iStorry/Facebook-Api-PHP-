<?php
session_start();
require_once 'Facebook_App.php';
$app = new Facebook_App();
echo '<a href='.$app->xLogin().'> '.$app->xLogin().' </a>';
