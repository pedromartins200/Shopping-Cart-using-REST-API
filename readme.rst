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
What is CodeIgniter
###################

CodeIgniter is an Application Development Framework - a toolkit - for people
who build web sites using PHP. Its goal is to enable you to develop projects
much faster than you could if you were writing code from scratch, by providing
a rich set of libraries for commonly needed tasks, as well as a simple
interface and logical structure to access these libraries. CodeIgniter lets
you creatively focus on your project by minimizing the amount of code needed
for a given task.

*******************
Release Information
*******************

This repo contains in-development code for future releases. To download the
latest stable release please visit the `CodeIgniter Downloads
<https://codeigniter.com/download>`_ page.

**************************
Changelog and New Features
**************************

You can find a list of all changes for each release in the `user
guide change log <https://github.com/bcit-ci/CodeIgniter/blob/develop/user_guide_src/source/changelog.rst>`_.

*******************
Server Requirements
*******************

PHP version 5.6 or newer is recommended.

It should work on 5.3.7 as well, but we strongly advise you NOT to run
such old versions of PHP, because of potential security and performance
issues, as well as missing features.

************
Installation
************

Please see the `installation section <https://codeigniter.com/user_guide/installation/index.html>`_
of the CodeIgniter User Guide.

*******
License
*******

Please see the `license
agreement <https://github.com/bcit-ci/CodeIgniter/blob/develop/user_guide_src/source/license.rst>`_.

*********
Resources
*********

-  `User Guide <https://codeigniter.com/docs>`_
-  `Language File Translations <https://github.com/bcit-ci/codeigniter3-translations>`_
-  `Community Forums <http://forum.codeigniter.com/>`_
-  `Community Wiki <https://github.com/bcit-ci/CodeIgniter/wiki>`_
-  `Community Slack Channel <https://codeigniterchat.slack.com>`_

Report security issues to our `Security Panel <mailto:security@codeigniter.com>`_
or via our `page on HackerOne <https://hackerone.com/codeigniter>`_, thank you.

***************
Acknowledgement
***************

The CodeIgniter team would like to thank EllisLab, all the
contributors to the CodeIgniter project and you, the CodeIgniter user.
