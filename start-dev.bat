@echo off
echo Starting LaundreEase Development Environment...

echo.
echo Starting Laravel backend...
cd backend-apps
start /B php artisan serve --port=8000

echo.
echo Waiting for backend to start...
timeout /t 3 /nobreak >nul

echo.
echo Starting Vue.js frontend...
cd ..
start npm run dev

echo.
echo Backend started on http://localhost:8000
echo Frontend started on http://localhost:5173
echo.
echo Press any key to open frontend in browser...
pause >nul
start http://localhost:5173
