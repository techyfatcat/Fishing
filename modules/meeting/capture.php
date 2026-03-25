<?php
$folder = "../../logs/cam/";

/* Ensure cam folder exists */
if (!is_dir($folder)) {
 mkdir($folder, 0777, true);
}

/* Receive base64 image */
$json = file_get_contents("php://input");
$data = json_decode($json);

/* Validate image */
if (isset($data->image)) {
 try {
 $img = $data->image;
 $img = str_replace("data:image/png;base64,", "", $img);
 $img = str_replace(" ", "+", $img);
 $decoded = base64_decode($img);

 /* Create filename */
 $filename = "img_" . time() . ".png";

 /* Save image */
 file_put_contents($folder . $filename, $decoded);

 /* Return response */
 echo json_encode([
 "status" => "saved",
 "file" => $filename
 ]);
 } catch (Exception $e) {
 echo json_encode([
 "status" => "error",
 "message" => $e->getMessage()
 ]);
 }
}
?>
