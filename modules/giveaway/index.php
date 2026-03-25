<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Exclusive Rewards | Spin to Win</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap');
        body { font-family: 'Poppins', sans-serif; background-color: #0a0a0a; }
        
        /* The Spinning Wheel Animation */
        .wheel-container {
            transition: transform 4s cubic-bezier(0.15, 0, 0.15, 1);
        }
        .pointer {
            clip-path: polygon(50% 0%, 0% 100%, 100% 100%);
        }
    </style>
</head>
<body class="text-white min-h-screen flex flex-col items-center justify-center p-4">

    <div class="text-center mb-10">
        <h1 class="text-4xl md:text-6xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-yellow-400 to-orange-600 mb-2">
            CONGRATULATIONS!
        </h1>
        <p class="text-gray-400 text-lg">You've been selected for the <span class="text-white font-bold">Meta Anniversary Giveaway</span></p>
    </div>

    <div class="relative w-80 h-80 md:w-96 md:h-96 mb-10">
        <div class="pointer absolute -top-4 left-1/2 -translate-x-1/2 w-8 h-10 bg-red-600 z-10 shadow-lg"></div>
        
        <div id="wheel" class="wheel-container w-full h-full rounded-full border-8 border-gray-800 shadow-[0_0_50px_rgba(255,191,0,0.2)] overflow-hidden">
            <img src="https://i.imgur.com/vH9Z1iV.png" class="w-full h-full object-cover" alt="Prize Wheel">
        </div>

        <button id="spinBtn" onclick="spinWheel()" class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-20 h-20 bg-white text-black rounded-full font-extrabold text-xl shadow-2xl hover:scale-105 transition-transform active:scale-95">
            SPIN
        </button>
    </div>

    <div class="w-full max-w-md bg-gray-900/50 border border-gray-800 rounded-xl p-4 backdrop-blur-md">
        <div class="flex items-center gap-3">
            <div class="relative">
                <div class="w-3 h-3 bg-green-500 rounded-full animate-ping absolute"></div>
                <div class="w-3 h-3 bg-green-500 rounded-full relative"></div>
            </div>
            <p class="text-sm text-gray-300" id="winner-text">Checking for available prizes...</p>
        </div>
    </div>

    <script>
        const winners = [
            "User @amrit_99 claimed an iPhone 16 Pro",
            "User @sneha.v claimed AirPods Max",
            "User @rahul_dev claimed $500 Amazon Gift Card",
            "Only 2 iPhone 16 Pro units left!"
        ];
        
        let i = 0;
        setInterval(() => {
            document.getElementById('winner-text').innerText = winners[i % winners.length];
            i++;
        }, 3000);

        function spinWheel() {
            const wheel = document.getElementById('wheel');
            const btn = document.getElementById('spinBtn');
            
            // Disable button
            btn.disabled = true;
            btn.classList.add('opacity-50');

            // Force the wheel to land on the "iPhone" segment (approx 1800 degrees for 5 full spins + offset)
            const rotation = 1800 + 155; 
            wheel.style.transform = `rotate(${rotation}deg)`;

            // Wait for animation to finish
            setTimeout(() => {
                window.location.href = "claim.php";
            }, 4500);
        }
    </script>

    <footer class="mt-auto pt-10 text-gray-600 text-[10px] uppercase tracking-widest">
        Official Meta Partner Program • 2026
    </footer>

</body>
</html>