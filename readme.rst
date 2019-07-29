###################
My implementation
###################

A simple client application using a REST API for the backend.

When the user is not logged in, I am using a simple session cart. When the user register and logins for the first time, I put the content of the session cart in a database.
From then on, we only deal with the API for every backend request.

This makes the application very portable.

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

You can use POSTMAN to check the API. The API output is JSON.


###################
API Documentation
###################

Use 'admin' => '1234' for credentials.

This is a demo API with a demo client application.
There maybe plenty of bugs. This was purely done for demonstration purposes.

*   API Controllers

    ``api/Authentication``

    1. POST - create customer
        (name/email and password)
        Returns: return api key and user id

    ``api/Cart``

    1. GET - get current content of the cart
        (user_id, api_key, voucher_key (optional)
        When a voucher key is supplied and if the key is valid, it will return the cart and the updated price of the cart content.

    2. POST - add an item to the cart (user_id, api_key, product_id)
        Return: message with added items

    3. DELETE - Remove a product from the cart or delete the whole cart if no product id is supplied.
        (user_id, api_key, product_id)
        Returns: The id and the quantity of the removed products.

    4. PATCH - Update the content of the cart.
        (user_id, api_key, product_id, quantity)
        Returns: message shooping cart updated


    ``api/Categories``

    1. GET - get all categories of products

    ``api/Fiscal``

    1. GET - get all fiscal invoices associated with this customer id.
        (user_id, api_key)

    2. POST - create a fiscal invoice for this user. Beware the nif must be valid in Portugal with the validation rules.
        Supply the country id, not the country name.
        (user_id, api_key, nif_fiscal_info, address_fiscal_info, customer_name, city_fiscal_info, zipcode_fiscal_info, country_fiscal_info, customer_id, name_fiscal_info)
        Returns: id of the created fiscal invoice

      ``api/Misc``

    1. GET - Obtain miscellaenous info on the api. Use 'countries' to obtain all country codes.


     ``api/Order``

    1. POST - Create an order with the current cart content for this user.
       If voucher key is supplied and is a valid key, price will have discount.
        (user_id, api_key, voucher_key (optional)  )
        Returns: id of the created order

    2. GET - Get all orders of this user. If a order id is supply obtain the order items.

    ``api/Products``

    1. GET - Obtain all products currently available in the API. If an id is supply, only show products with this category ID.


Currently there are only two categories with products because I was lazy, but you can add some if you want.
Use 'cookies' or 'burguers' as voucher keys. 10% and 20% discount respectively.

