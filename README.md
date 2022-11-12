# Grepsr Assignment Project

## Table of Contents

- [About](#about)
- [Getting Started](#getting_started)

## About <a name = "about"></a>

*This is a assignment project for Software Engineer role in grepsr*

## Getting Started <a name = "getting_started"></a>


```shell
composer install

```
**And Run individual file with**
```shell
    php {filename}
```



### Prerequisites


### **make sure you have php version greater than 7.3 installed**

#### **Install composer if not already installed by running the lines below**
```shell

php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"

