## how to install

1. clone this repository `git clone https://github.com/fadhil-riyanto/jujurCBT.git`
2. change working directory `cd jujurCBT`
3. make sure mariadb installed and running by type `sudo systemctl status mariadb`
4. change .env database section with your own credential used in mariadb
5. run `composer install` to install needed dependencies
6. run migration `php artisan migrate` to install needed table
7. run server `php artisan serve` to run development server

optional, if you see and error such missing assets, don't forget to install vite
as shown below
1. npm install -g vite
2. run `vite build` on working directory

note: make sure you have npm installed

## Contribution, and issues
Contributions are welcome, if you have any issue, just open new issue.

## maintainer
@fadhil-riyanto

## license
GPL-2.0 license 