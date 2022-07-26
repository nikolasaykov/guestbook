# Guest book

* Create comments
* Show comments (pagination)

## Installation
From the root folder, run
```bash
composer install
```
Again from the root folder, create initial tables with:
```bash
php ./cli/migrate.php
```

## Start project

```bash
./start.sh
```

http://localhost

## Stop project

```bash
./stop.sh
```

## Running tests
From the root directory run
```bash
./vendor/bin/phpunit test/..
```

## Bash in PHP container

```bash
./cli.sh
```

# Database

Inside the container, in php code: `mysql:3306 root:root`

With client on host: `localhost:3306 root:root`

You can find an example of connecting to database in `index.php` so you don't waste time doing this.