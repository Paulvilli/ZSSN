# ZSSN
API rest
Installation
---------------------------------------

The project dependencies are managed by [composer](https://getcomposer.org).

```cli
composer install
```
The database connection is configured in the src/Model/Db file. Modify the database details (host, username, password, etc.) according to your environment.

The front-end is configured to connect on a specific port. If you need to change this port, locate the SurvivorRoute file, usually in src/Route/SurvivorRoute.php.

Running PHPUnit Tests
To run PHPUnit tests, use the following command in your terminal:

Copy code
vendor/bin/phpunit test/SurvivorControllerTest.php

Make sure PHPUnit is installed and configured in your project.
