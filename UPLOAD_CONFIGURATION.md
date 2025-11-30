# Bulk Image Upload Configuration

To enable uploading 100+ images, you need to configure PHP settings on your server.

## PHP Configuration

### Option 1: php.ini (Recommended for production)
Edit your `php.ini` file and set:
```ini
max_file_uploads = 100
upload_max_filesize = 10M
post_max_size = 100M
memory_limit = 256M
max_execution_time = 300
max_input_time = 300
```

### Option 2: .htaccess (Apache)
The `.htaccess` file in the `public` directory has been updated with these settings.

### Option 3: .user.ini (PHP-FPM/cPanel)
A `.user.ini` file has been created in the `public` directory with these settings.

## After Configuration

1. **Restart your web server** (Apache/Nginx)
2. **Restart PHP-FPM** (if using PHP-FPM)
3. **Clear any PHP opcache** if enabled

## Verify Configuration

Run this command to check your current PHP settings:
```bash
php -r "echo 'max_file_uploads: ' . ini_get('max_file_uploads') . PHP_EOL; echo 'upload_max_filesize: ' . ini_get('upload_max_filesize') . PHP_EOL; echo 'post_max_size: ' . ini_get('post_max_size') . PHP_EOL;"
```

## Notes

- Dropzone uploads files individually, so `max_file_uploads` limit applies per request
- With `parallelUploads: 5`, up to 5 files upload simultaneously
- The system will automatically queue and process all files
- Progress is shown in real-time during upload

