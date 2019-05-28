# cardate-iissi

## Installation

### Dependecies
Install dependencies with https://getcomposer.org into the project folder
> composer install

### Database access
Create config/config.php with your database credentials 
```
<?php

require_once 'urls.php';

// define('DEBUG', true);

// Database credentials
define('DBTYPE', 'oci');
define('DB', 'localhost');
define('USER', '');
define('PASSWORD', '');
define('CHARSET', 'UTF8');

// 404 page redirect
define('HTTP404', '/404');

?>
```
