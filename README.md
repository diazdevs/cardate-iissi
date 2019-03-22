# cardate-iissi

## Installation

### Dependecies
Install dependencies with https://getcomposer.org
> composer install

### Database access
Replace config/config.php with your database credentials 
```
<?php

require_once 'urls.php';

// define('DEBUG', true);

// Database credentials
define('DBTYPE', 'oci');
define('DB', '');
define('USER', '');
define('PASSWORD', '');
define('CHARSET', 'UTF8');

// 404 page redirect
define('HTTP404', '/404');

?>
```
