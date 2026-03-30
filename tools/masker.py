import sys
import os

def generate_manual_mask(target_url, fake_domain, keyword):
    """
    Creates a manual masked URL using the @ authority bypass.
    Does not rely on external APIs to avoid blacklisting.
    """
    # 1. Sanitize Target URL (Remove protocol for the @ part)
    # We need the protocol at the start, but not for the host part
    real_host = target_url.replace("https://", "").replace("http://", "")
    
    # 2. Sanitize Fake Domain (Remove protocol if user typed it)
    clean_fake = fake_domain.replace("https://", "").replace("http://", "")

    # 3. Construct the Mask
    # Result: https://instagram.com-login-verify@your-link.ngrok-free.app
    masked_link = f"https://{clean_fake}-{keyword}@{real_host}"
    
    return masked_link

if __name__ == "__main__":
    # Header for the techyfatcat tool
    print("\n\033[95m--- MANUAL URL MASKER (API-BYPASS) ---\033[0m")
    
    # Logic to handle both CLI arguments from .sh or manual input
    if len(sys.argv) > 1:
        real = sys.argv[1]
        print(f"\033[94m[*] Target Tunnel Detected:\033[0m {real}")
    else:
        real = input("\033[1;37mEnter Real URL (Ngrok/CF):\033[0m ")
    
    fake = input("\033[1;37mEnter Fake Domain (e.g., google.com):\033[0m ")
    key  = input("\033[1;37mEnter Keyword (e.g., free-storage):\033[0m ")
    
    if not real or not fake:
        print("\033[91m[!] Error: Real URL and Fake Domain are required.\033[0m")
        sys.exit(1)

    result = generate_manual_mask(real, fake, key)
    
    print(f"\n\033[92m[+] MASK GENERATED SUCCESSFULLY\033[0m")
    print(f"\033[1;34m━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\033[0m")
    print(f" \033[1;37mLink:\033[0m \033[4;92m{result}\033[0m")
    print(f"\033[1;34m━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\033[0m")
    print("\033[90mNote: This bypasses shortener blacklists by using direct authority.\033[0m\n")