# Acme-Catalog
A simple E-Commerce website where customers can browse wonderful products from the world of Looney Toons! This is a full stack application that incorporates HTML, CSS, JavaScript, PHP, and MariaDB. It is currently deployed and operating on my remote server which can be accessed using the link below. The project incorporates login/registration validation using encryption and salting, session identity, a full table catalog, unique pictures and descriptions for each item, and a simplistic checkout feature. Please enjoy!

Click here to login and browse the catalog: [Clickable Text] (https://jb-projects.freehosting.dev/catalog/)

##Frontend
HTML & CSS: Provides the structure and styling of the website, allowing for a glassmorphic style for many of the components within the catalog
JavaScript: Supports real-time form validation when the user registers a new account and password, allowing for responsive feedback

##Backend
PHP: The main controller logic of the website. Acts as a seamless bridge between the database and views like the catalog and details pages. Keeps track of sessions and cookies to allow the user to remain logged in, even if they close their browser. It also provides SHA-512 encryption and salting to user passwords before storing them in the database

##Database
MariaDB: The primary database for this application. It stores user account information that is securely encrypted, as well as product details to be fetched and rendered on the subsequent webpages. It also contain product images for each item that incorporated into the catalog. Accessed via PhpMyAdmin and sqlconnection()
