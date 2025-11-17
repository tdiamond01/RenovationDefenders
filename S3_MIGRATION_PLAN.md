# S3 Video Storage Migration Plan

## Overview
Migrate video storage from local filesystem to Amazon S3 for better scalability, performance, and cost-effectiveness.

## Benefits
- **Scalability**: Unlimited storage capacity
- **Performance**: Better streaming performance with CloudFront CDN
- **Cost**: Cheaper than EBS storage ($0.023/GB vs $0.10/GB)
- **Reliability**: 99.999999999% durability
- **Bandwidth**: Offload video delivery from web server

---

## Implementation Steps

### 1. Create S3 Bucket
- Bucket name: `renovation-defenders-videos`
- Region: `us-west-2` (same as application)
- Block public access: OFF (videos need to be publicly accessible)
- Versioning: Optional
- Encryption: AES-256

### 2. Configure IAM Permissions
Add S3 permissions to existing IAM user or create new one:
```json
{
  "Version": "2012-10-17",
  "Statement": [
    {
      "Effect": "Allow",
      "Action": [
        "s3:PutObject",
        "s3:GetObject",
        "s3:DeleteObject",
        "s3:ListBucket"
      ],
      "Resource": [
        "arn:aws:s3:::renovation-defenders-videos",
        "arn:aws:s3:::renovation-defenders-videos/*"
      ]
    }
  ]
}
```

### 3. Install Required Packages
```bash
composer require league/flysystem-aws-s3-v3 "^3.0"
```

### 4. Configure Laravel Filesystem
Update `config/filesystems.php`:
```php
'disks' => [
    's3-videos' => [
        'driver' => 's3',
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION'),
        'bucket' => env('AWS_VIDEO_BUCKET'),
        'url' => env('AWS_VIDEO_URL'),
        'visibility' => 'public',
    ],
],
```

### 5. Environment Variables
Add to `.env` and Elastic Beanstalk environment:
```
AWS_VIDEO_BUCKET=renovation-defenders-videos
AWS_VIDEO_URL=https://renovation-defenders-videos.s3.us-west-2.amazonaws.com
```

Optional (if using CloudFront):
```
AWS_VIDEO_CLOUDFRONT_URL=https://d1234567890.cloudfront.net
```

### 6. Update Video Model
Add helper methods to generate S3 URLs:
```php
public function getVideoUrlAttribute()
{
    if ($this->storage_driver === 's3') {
        return Storage::disk('s3-videos')->url($this->storage_path);
    }
    return asset('storage/' . $this->storage_path);
}
```

### 7. Update Video Upload Logic
Modify `VideoController` to upload to S3:
```php
$path = $request->file('video_file')->store('videos', 's3-videos');
$video->storage_path = $path;
$video->storage_driver = 's3';
```

### 8. Database Schema Update
Add `storage_driver` column to track where video is stored:
```php
Schema::table('VIDEOS', function (Blueprint $table) {
    $table->string('STORAGE_DRIVER')->default('local')->after('VIDEO_URL');
});
```

### 9. Migrate Existing Videos
Script to move existing videos from local to S3:
```php
$videos = Video::where('STORAGE_DRIVER', 'local')->get();
foreach ($videos as $video) {
    $localPath = storage_path('app/public/' . $video->VIDEO_URL);
    if (file_exists($localPath)) {
        $s3Path = 'videos/' . basename($video->VIDEO_URL);
        Storage::disk('s3-videos')->put($s3Path, file_get_contents($localPath));
        $video->update([
            'VIDEO_URL' => $s3Path,
            'STORAGE_DRIVER' => 's3'
        ]);
    }
}
```

---

## File Structure Changes

### Current Structure
```
storage/app/public/videos/
  ├── video1.mp4
  ├── video2.mp4
  └── ...
```

### New Structure (S3)
```
s3://renovation-defenders-videos/
  └── videos/
      ├── video1.mp4
      ├── video2.mp4
      └── ...
```

---

## Testing Checklist

- [ ] S3 bucket created and configured
- [ ] IAM permissions set up
- [ ] Flysystem S3 package installed
- [ ] Environment variables configured
- [ ] New video uploads go to S3
- [ ] Video URLs resolve correctly
- [ ] Videos play in browser
- [ ] Existing videos migrated to S3
- [ ] Old local videos can be deleted
- [ ] Admin panel shows correct video URLs
- [ ] User dashboard plays videos from S3

---

## Optional: CloudFront CDN

For better performance and lower S3 costs:

### Benefits
- Faster video delivery worldwide
- Reduced S3 data transfer costs
- HTTPS by default
- Custom domain support

### Setup
1. Create CloudFront distribution
2. Origin: S3 bucket
3. Update `AWS_VIDEO_URL` to CloudFront URL
4. Optional: Add custom SSL certificate for videos.renovationdefenders.com

---

## Rollback Plan

If issues occur:
1. Keep local videos until migration is verified
2. Can switch back by changing `STORAGE_DRIVER` in database
3. S3 uploads can be re-downloaded if needed

---

## Cost Estimate

**S3 Storage:**
- 100GB videos = $2.30/month
- 1TB videos = $23/month

**Data Transfer:**
- First 100GB free
- $0.09/GB after that

**CloudFront (optional):**
- First 1TB free for 12 months
- $0.085/GB after that

**Total estimated cost for 100GB videos with moderate traffic:**
- ~$5-10/month

---

## Implementation Order

1. ✅ Create this plan
2. Create S3 bucket
3. Install Flysystem package
4. Update configuration files
5. Add database migration for storage_driver
6. Update Video model
7. Update VideoController upload logic
8. Test new uploads
9. Create migration script for existing videos
10. Run migration
11. Verify all videos work
12. Deploy to production
13. Optional: Set up CloudFront

