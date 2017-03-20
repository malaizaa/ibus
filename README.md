ibus
====

##Tech stack:##
* Symfony 3.2.X
* Php 7.0.X
* PHPUnit 6.0.7

## Before start script: ##
```
composer install
```

## If you want to add CRUD way created routes to container use this command (if you are running on PROD env): ##
```
php bin/console cache:clear --env=prod --no-debug
```

##Test run:##
`phpunit`
