## how to install

1. clone this repository `git clone https://github.com/fadhil-riyanto/jujurCBT.git`
2. change working directory `cd jujurCBT`
3. make sure mariadb installed and running by type `sudo systemctl status mariadb` or run mariadb `sudo systemctl start mariadb`
4. change .env.example database section with your own credential used in mariadb
5. run `composer install` to install needed dependencies
6. run `npm install` to install vite, etc
7. run `npm run dev` to build static files etc or `npx vite build` to build the files
8. run migration `php artisan migrate` to create needed table on the selected database
9. run server `php artisan serve` to run development server

note: make sure you have npm installed

## Contribution, and issues
Contributions are welcome, if you have any issue, just open new issue.

## maintainer
<a href="https://github.com/fadhil-riyanto/">@fadhil-riyanto</a>

## license
GPL-2.0 license 