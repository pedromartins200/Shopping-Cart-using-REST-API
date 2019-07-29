###################
My implementation
###################

A simple client application using a REST API for the backend.

The system allows to add items to the cart, update the quantities, order the cart content, view cart items, add a voucher (discount) to the order. Also items are displayed according to their category.

In the future, a stock management system could be done and token base authentication for the API, but it seemed overkill to me.

I used codeigniter 3, guzzle for the API requests, and phil sturgeon's rest server. I used php 7.3.7 but 7.0+ may work.


Keep in mind the base_url (check application/config/config.php) and also the database configurations (application/config/development/database.php). Base url is what gives trouble when people import codeigniter projects.

###################
API Usage
###################

First thing you should do is register in the API, which will return you a user ID and API key.
With this combination, you can add items to the cart, update, delete, remove items and also order the cart content (with voucher option).

Without an API key you can view products in store and respective categories. 
Again, a token base authentication is more "secure" but its not necessary for a demo application.

You can use POSTMAN to check the API.


###################
API Documentation
###################

For ``monospaced text``, use two "backquotes" instead.

*   Mark bulleted lists with one of three symbols followed by a space:

    1. asterisk (``*``)
    2. hyphen (``-``)
    3. plus sign (``+``)


