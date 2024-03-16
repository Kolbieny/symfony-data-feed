# Symfony data feed

### Description

The application in it's current state imports the data from .xml file to the database.

### Configuration

The project is provided with ready docker configuration.
When the image will be configured, these commands will be helpful: 

```
composer install
bin/console doctrine:database:create
bin/console doctrine:migrations:migrate
```

The .xml file should be included in `data/` directory. To run the application follow the pattern:
```
bin/console app:item:import <yourfilename>.xml 
```

Errors are logged in `var/log/error.log`

The project has also some unit / integration tests.

```
bin/phpunit
vendor/bin/behat
```

Behat tests use a test env database. To configured it manually, use the commands below:
```
bin/console doctrine:database:create --env=test
bin/console doctrine:migrations:migrate --env=test
```
