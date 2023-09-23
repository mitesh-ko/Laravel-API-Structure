<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>


## System requirements
- PHP 8.1^
- composer 2.5^
- MySQL (recommended)

## How to set up
- Clone this project `git clone https://github.com/mitesh-ko/EquityPandit-practical.git`
- Run this command to generate .env `composer run-script post-root-package-install`

### Production
- Run command `composer install --no-dev`
- Update the .env
```
APP_ENV=production
APP_DEBUG=false
```

### Development
- Run command `composer install`
- No need to update **APP_ENV** and **APP_DEBUG**

### Common steps
- Connect database
    ```
      DB_CONNECTION=mysql (recommended)
      DB_HOST=<DATABASE HOST>
      DB_PORT=<DATABASE PORT>
      DB_DATABASE=<DATABASE NAME>
      DB_USERNAME=<DATABASE USERNAME>
      DB_PASSWORD=<DATABASE PASSWORD>
    ```
- Run following command one by one
    - `php artisan migrate`
    - `php artisan db:seed`
