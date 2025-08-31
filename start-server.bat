@echo off
echo Starting Hotel Management System...
echo.
echo Server will be available at:
echo - http://localhost:8000
echo - http://127.0.0.1:8000
echo.
echo Press Ctrl+C to stop the server
echo.
php artisan serve --host=0.0.0.0 --port=8000
pause
