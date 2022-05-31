cd ..
php artisan migrate:fresh
pause
php artisan db:rebuild seed
pause