how to install / cara menginstall

1. clone this repository `git clone git@github.com:fadhil-riyanto/jujurCBT.git`
2. `cd jujurCBT`
3. make sure mariadb running by type `systemctl status mariadb`
4. change .env database section with your own credential
5. run `composer install`
6. run migration `php artisan migrate`
7. run server `php artisan serve`

optional, if you see and error such missing assets, don't forget to install vite
as shown below
8. npm install -g vite
9. run `vite build`