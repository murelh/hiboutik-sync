# hiboutik-sync
Hiboutik Sync is a Wordpress plugin. It allows you to synchronize your Hiboutik stock and WooCommerce website.

## How to use

1. Activate WooCommerce API and save credentials
1. Activate Hiboutik API and save credentials
1. Install Hiboutik Sync on your website
1. Go to Hiboutik Sync setting file and fill variable with the correct values
1. Activate Callback URL on your Hiboutik account and set :  http://www.yourwebsite.com/hiboutik-woocommerce-sync


## How does it work ?

Each time a sale is closed from your Hiboutik account, il will call the callback url and send sale informations (HTTP POST request).
Once Hiboutik Sync is installed on you website, it will respond to the url http://www.yourwebsite.com/hiboutik-woocommerce-sync and will try to catch avaible POST data.
It will ask to Hiboutik the order's details from sale ID previously receved. What Hiboutik will respond by giving exact quantity of product sold.
And finally, Hiboutik Sync will contact your WooCommerce API and reduce the stock of the given product.

*The very important thing to know is that products match on Hiboutik products's barcode and WooCommerce products's UGS number (also called SKU number).*
