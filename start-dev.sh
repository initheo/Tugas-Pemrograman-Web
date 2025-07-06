#!/bin/bash

# Start Backend (Laravel)
echo "Starting Laravel backend..."
cd backend-apps
php artisan serve --port=8000 &
BACKEND_PID=$!

# Wait a moment for backend to start
sleep 3

# Start Frontend (Vue.js)
echo "Starting Vue.js frontend..."
cd ..
npm run dev &
FRONTEND_PID=$!

echo "Backend started on http://localhost:8000"
echo "Frontend started on http://localhost:5173"
echo "Press Ctrl+C to stop both servers"

# Function to cleanup processes on exit
cleanup() {
    echo "Stopping servers..."
    kill $BACKEND_PID 2>/dev/null
    kill $FRONTEND_PID 2>/dev/null
    exit
}

# Trap Ctrl+C and call cleanup
trap cleanup INT

# Wait indefinitely
wait
