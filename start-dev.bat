@echo off
start "Laravel Server" cmd /k "php artisan serve"
start "Vite Dev Server" cmd /k "npm run dev"
start "Laravel Queue Worker" cmd /k "php artisan queue:work"
