<?php

$folder = "../../logs/cam/";

/*
ensure cam folder exists
*/

if (!file_exists($folder)) {

    mkdir($folder, 0777, true);

}

/*
receive base64 image
*/

$json = file_get_contents("php://input");

$data = json_decode($json);

/*
validate image
*/

if (isset($data->image)) {

    $img = $data->image;

    $img = str_replace("data:image/png;base64,", "", $img);

    $img = str_replace(" ", "+", $img);

    $decoded = base64_decode($img);

    /*
    create filename
    */

    $filename = "img_" . time() . ".png";

    /*
    save image
    */

    file_put_contents($folder . $filename, $decoded);

    /*
    return response
    */

    echo json_encode([

        "status" => "saved",
        "file" => $filename

    ]);

}

?>