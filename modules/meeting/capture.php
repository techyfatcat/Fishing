<?php
$date = date('d-M-Y_H-i-s');
$json = file_get_contents('php://input');
$data = json_decode($json);

if ($data && $data->image) {
    $img = $data->image;
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data_decoded = base64_decode($img);
    
    // Save to the logs/cam folder
    $file = "../../logs/cam/img_" . $date . ".png";
    file_put_contents($file, $data_decoded);
    
    echo json_encode(["status" => "success"]);
}
?>