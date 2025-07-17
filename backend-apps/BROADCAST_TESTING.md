# Testing Broadcast Feature

## Prerequisites
1. Make sure queue worker is running:
```bash
cd backend-apps
php artisan queue:work
```

## Frontend Testing
1. Login sebagai admin
2. Akses halaman Broadcast via sidebar menu
3. Tulis pesan di textarea
4. Klik "Send Broadcast"
5. Response akan langsung kembali dengan status "queued"
6. Email akan dikirim di background via queue worker

## Backend API Testing

### Send Broadcast Message
```bash
curl -X POST http://localhost:8000/api/broadcast/send-now \
  -H "Authorization: Bearer YOUR_ADMIN_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"message": "Test broadcast message"}'
```

### Check Queue Status
```bash
curl -X GET http://localhost:8000/api/broadcast/queue-status \
  -H "Authorization: Bearer YOUR_ADMIN_TOKEN"
```

## Expected Response

### Broadcast Send Response
```json
{
  "success": true,
  "message": "Broadcast message has been queued and will be sent to all users shortly.",
  "data": {
    "broadcast_message": "Test broadcast message",
    "timestamp": "2025-07-17T10:30:00.000000Z",
    "status": "queued"
  }
}
```

### Queue Status Response
```json
{
  "success": true,
  "data": {
    "queue_status": "processing",
    "pending_jobs": 1,
    "failed_jobs": 0,
    "timestamp": "2025-07-17T10:30:00.000000Z"
  }
}
```

## Monitoring
- Check Laravel logs: `storage/logs/laravel.log`
- Monitor queue table: `SELECT * FROM jobs;`
- Check failed jobs: `SELECT * FROM failed_jobs;`

## Performance Benefits
- ✅ Response time: Instant (tidak menunggu email terkirim)
- ✅ Scalability: Queue dapat memproses multiple jobs
- ✅ Reliability: Failed jobs dapat di-retry
- ✅ Monitoring: Queue status dapat dimonitor
