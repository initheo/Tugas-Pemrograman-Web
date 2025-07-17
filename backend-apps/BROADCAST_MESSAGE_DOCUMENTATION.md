# Broadcast Message System Documentation

## Overview
Sistem broadcast message telah diimplementasikan untuk mengirim pesan ke semua pengguna melalui email. Sistem ini menggunakan Laravel Jobs untuk memproses pengiriman email secara asynchronous.

## Files Created/Modified

### 1. BroadcastMessageJob.php
**Location:** `app/Jobs/BroadcastMessageJob.php`
**Purpose:** Job untuk mengirim pesan broadcast ke semua pengguna

**Features:**
- Mengambil semua user dari database
- Mengirim email ke setiap user menggunakan BroadcastMessageMail
- Logging untuk tracking pengiriman
- Error handling per user
- Tetap menjalankan event broadcasting untuk real-time

### 2. BroadcastMessageMail.php
**Location:** `app/Mail/BroadcastMessageMail.php`
**Purpose:** Mailable class untuk format email broadcast

**Features:**
- Template email yang responsive
- Personalisasi dengan nama user
- Subject yang jelas
- Clean design

### 3. broadcast-message.blade.php
**Location:** `resources/views/emails/broadcast-message.blade.php`
**Purpose:** Template email untuk broadcast message

**Features:**
- Responsive design
- Professional styling
- Personalized greeting
- Clear message display
- Company branding

### 4. BroadcastController.php
**Location:** `app/Http/Controllers/BroadcastController.php`
**Purpose:** Controller untuk menangani API requests broadcast

**Features:**
- `sendMessage()` - Queue job untuk pengiriman
- `sendMessageNow()` - Eksekusi langsung untuk testing
- Validation input
- Proper error handling
- JSON responses

### 5. SendBroadcastMessage.php
**Location:** `app/Console/Commands/SendBroadcastMessage.php`
**Purpose:** Artisan command untuk mengirim broadcast via CLI

## API Endpoints

### 1. Queue Broadcast Message
```http
POST /api/broadcast/send
Authorization: Bearer {token}
Content-Type: application/json

{
    "message": "Pesan yang akan dikirim ke semua pengguna"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Broadcast message has been queued and will be sent to all users.",
    "data": {
        "broadcast_message": "Pesan yang akan dikirim ke semua pengguna",
        "timestamp": "2025-07-17T10:30:00.000000Z"
    }
}
```

### 2. Send Broadcast Message Immediately
```http
POST /api/broadcast/send-now
Authorization: Bearer {token}
Content-Type: application/json

{
    "message": "Pesan yang akan dikirim langsung ke semua pengguna"
}
```

## CLI Command

### Send Broadcast Message
```bash
php artisan broadcast:send "Pesan broadcast untuk semua pengguna"
```

## Usage Examples

### 1. Via API (Recommended)
```javascript
// Frontend JavaScript
const response = await fetch('/api/broadcast/send', {
    method: 'POST',
    headers: {
        'Authorization': `Bearer ${authToken}`,
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({
        message: 'Sistem akan maintenance pada hari Minggu pukul 02:00 WIB'
    })
});
```

### 2. Via CLI
```bash
# Production
php artisan broadcast:send "Promo spesial bulan ini: Diskon 50% untuk semua layanan!"

# Development
php artisan broadcast:send "Testing broadcast message system"
```

### 3. Via Code
```php
// Dalam controller atau service lain
use App\Jobs\BroadcastMessageJob;

BroadcastMessageJob::dispatch('Pesan penting untuk semua pengguna');
```

## Requirements

### Email Configuration
Pastikan email configuration sudah diatur di `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="LaundryEase"
```

### Queue Configuration
Untuk production, gunakan database atau Redis queue:
```env
QUEUE_CONNECTION=database
# atau
QUEUE_CONNECTION=redis
```

## Running the System

### 1. Development (Sync Queue)
```bash
# Queue akan dijalankan langsung
php artisan broadcast:send "Test message"
```

### 2. Production (Background Queue)
```bash
# Start queue worker
php artisan queue:work

# Atau gunakan supervisor untuk auto-restart
php artisan queue:work --daemon
```

## Monitoring

### Log Files
- Check logs: `storage/logs/laravel.log`
- Queue jobs: `storage/logs/queue.log`

### Database Queue Table
Jika menggunakan database queue:
```sql
SELECT * FROM jobs WHERE queue = 'default';
SELECT * FROM failed_jobs;
```

## Testing

### 1. Test Email Template
```php
// Via tinker
php artisan tinker

use App\Mail\BroadcastMessageMail;
use App\Models\User;
Mail::to('test@example.com')->send(new BroadcastMessageMail('Test message', User::first()));
```

### 2. Test Job
```php
// Via tinker
use App\Jobs\BroadcastMessageJob;
BroadcastMessageJob::dispatch('Test broadcast message');
```

## Security & Permissions

- ✅ Hanya admin yang bisa mengirim broadcast message
- ✅ Input validation untuk mencegah XSS
- ✅ Rate limiting bisa ditambahkan di route
- ✅ Logging untuk audit trail

## Performance Considerations

- ✅ Menggunakan queue untuk menghindari timeout
- ✅ Error handling per user untuk mencegah total failure
- ✅ Batch processing bisa ditambahkan untuk user yang banyak
- ✅ Email throttling bisa dikonfigurasi

## Troubleshooting

### Common Issues:
1. **Email tidak terkirim**: Check email configuration dan credentials
2. **Queue tidak berjalan**: Pastikan `php artisan queue:work` running
3. **Permission denied**: Pastikan user memiliki role admin
4. **Memory limit**: Untuk user banyak, pertimbangkan chunking

### Debug Commands:
```bash
# Check email config
php artisan config:show mail

# Check queue status
php artisan queue:work --verbose

# Clear cache
php artisan cache:clear
php artisan config:clear
```
