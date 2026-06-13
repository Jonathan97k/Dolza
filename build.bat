@echo off
REM Dolza Real Estate - Production Build Script
echo === Dolza Production Build ===
echo.

cd /d "%~dp0"

echo [1/5] Generating app key (if missing)...
php artisan key:generate --force

echo [2/5] Caching config...
php artisan config:cache

echo [3/5] Caching routes...
php artisan route:cache

echo [4/5] Caching views...
php artisan view:cache

echo [5/5] Running migrations...
php artisan migrate --force

echo.
echo === Build complete! ===
echo Upload everything EXCEPT: .git, node_modules, .env
echo Then run: php artisan db:seed --force
pause
