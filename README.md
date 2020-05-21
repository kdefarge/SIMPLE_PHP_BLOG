# SIMPLE PHP BLOG [![Codacy Badge](https://app.codacy.com/project/badge/Grade/24b84b46fa3d4eb4baf369824800dbc0)](https://www.codacy.com/manual/kdefarge/SIMPLE_PHP_BLOG?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=kdefarge/SIMPLE_PHP_BLOG&amp;utm_campaign=Badge_Grade)

My professional blog

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

What things you need to install the software and how to install them

[SASS](https://sass-lang.com/)

[Composer](https://getcomposer.org/) 

```
MySQL
```

```
PHP 7 or more
```

### Installing

Install database with install_db.sql script

```
database\install_db.sql
```

Check you have installed sass command in your system and after use composer command

```
composer install
```

Update database parameter in config.php

```
<?php

return (object) array(
    'host' => 'mysql:host=localhost;dbname=blog;charset=utf8',
    'username' => 'root',
    'password' => ''
);

?>
```

### Compiling Sass (DEV)

If you need compile sass files 

```
sass --watch sass:public/css/ --style=compressed --no-source-map
```

Or 

```
sass sass:public/css/ --style=compressed --no-source-map
```

## Built With

* [Composer](https://getcomposer.org/) - A Dependency Manager for PHP
* [SASS](https://sass-lang.com/) - Professional grade CSS extension
* [Bootstrap](https://getbootstrap.com/) - front-end framework
* [Jquery](https://jquery.com/) - JavaScript library
* [Twig](https://twig.symfony.com/) - Modern template engine for PHP

## Authors

* **Kevin DEFARGE** - *Initial work* - [kdefarge](https://github.com/kdefarge)

## License

This project is licensed under the GNU General Public License v3.0 - see the [LICENSE.md](LICENSE.md) file for details