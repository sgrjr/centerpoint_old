cd ..
php artisan migrate:fresh
pause
php artisan database:rebuild seed
pause