# CharnaWHMCS
A WHMCS Payment Gateway for accepting CharnaCoin

## Dependancies
This plugin is rather simple but there are a few things that need to be set up before hand.

* A web server! Ideally with the most recent versions of PHP and mysql

* The charnacoin wallet-cli and Charnacoin wallet-rpc tools found [here](https://www.Charnacoin.com/#wallet)

* [WHMCS](https://www.whmcs.com/)
This charnacoin plugin is an payment gateway for WHMCS

## Step 1: Activating the plugin
* Downloading: First of all, you will need to download the plugin.  If you wish, you can also download the latest source code from GitHub. This can be done with the command `git clone https://github.com/charnacrypto/charnawhmcs.git` or can be downloaded as a zip file from the GitHub web page.


* Put the plugin in the correct directory: You will need to put the folder named `charna` from this repo/unzipped release into the wordpress plugins directory. This can be found at `whmcspath/module/gateways/`

* Activate the plugin from the WordPress admin panel: Once you login to the admin panel in WHMCS, click on "Payment Gateways" under "Settings". Then simply click "Activate" where it says "CharnaCoin - Payment Gateway"

## Step 2: Get a charnacoin daemon to connect to

### Option 1: Running a full node yourself

To do this: start the charnacoin daemon on your server and leave it running in the background. This can be accomplished by running `./charnacoind` inside your monero downloads folder. The first time that you start your node, the daemon will download and sync the entire blockchain. This can take several hours and is best done on a machine with at least 4GB of ram, an SSD hard drive (with at least 15GB of free space), and a high speed internet connection.

## Step 3: Setup your  monero wallet-rpc

* Setup a charnacoin wallet using the charnacoin-wallet-cli tool. If you do not know how to do this you can learn about it at [charnacoin.com](https://charnacoin.com/#wallet)

* Start the Wallet RPC and leave it running in the background. This can be accomplished by running `./charnacoin-wallet-rpc --rpc-bind-port 18082 --rpc-login username:password --log-level 2 --wallet-file /path/walletfile` where "username:password" is the username and password that you want to use, seperated by a colon and  "/path/walletfile" is your actual wallet file. If you wish to use a remote node you can add the `--daemon-address` flag followed by the address of the node. `--daemon-address node.address.here` for example.



## Info on server authentication
It is reccommended that you specify a username/password with your wallet rpc. This can be done by starting your wallet rpc with `charnacoin-wallet-rpc --rpc-bind-port 18082 --rpc-login username:password --wallet-file /path/walletfile` where "username:password" is the username and password that you want to use, seperated by a colon. Alternatively, you can use the `--restricted-rpc` flag with the wallet rpc like so `./charnacoin-wallet-rpc --testnet --rpc-bind-port 18082 --restricted-rpc --wallet-file wallet/path`.

## Donating Me
CHRC Address : `CkSAnjQk2ptgiKHCrs1pmWLzPaqccVHa82ajbnZcVvsnbcLwK43JZozZxdxn3fMD4Jacfb5N4jtjz11kgDBvAk3R9YQkEh2`
