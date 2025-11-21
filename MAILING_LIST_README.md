# Mailing List System - Documentation

## Overview

This is a simple mailing-list system built with Laravel that allows admins to:
- Create groups (e.g., "Marketing", "Developers", "VIP Customers")
- Add users (name + email) to any group
- Send a single email to all members of a selected group

## Why Laravel?

Laravel was chosen for this project because:
1. **Built-in Email Support**: Laravel has excellent email functionality with the Mail facade and Mailable classes
2. **Eloquent ORM**: Makes database operations simple and intuitive
3. **Validation**: Built-in validation system with clear error messages
4. **API Routes**: Easy to create RESTful APIs
5. **Security**: CSRF protection, SQL injection prevention, and more built-in
6. **Existing Project**: The project is already using Laravel, so it integrates seamlessly

## Database Schema

### Tables

#### `groups`
- `id` (primary key)
- `name` (string, unique)
- `description` (text, nullable)
- `created_at` (timestamp)
- `updated_at` (timestamp)

#### `users`
- `id` (primary key)
- `name` (string)
- `email` (string, unique)
- `password` (string, hashed)
- `role` (string)
- `created_at` (timestamp)
- `updated_at` (timestamp)

#### `group_members` (pivot table)
- `id` (primary key)
- `group_id` (foreign key to groups)
- `user_id` (foreign key to users)
- `created_at` (timestamp)
- `updated_at` (timestamp)
- Unique constraint on (`group_id`, `user_id`)

## API Endpoints

All API endpoints are prefixed with `/api/mailing-list`

### Groups

- `GET /api/mailing-list/groups` - List all groups
- `POST /api/mailing-list/groups` - Create a new group
  ```json
  {
    "name": "Marketing",
    "description": "Marketing team members"
  }
  ```
- `GET /api/mailing-list/groups/{id}` - Get a specific group with members
- `PUT /api/mailing-list/groups/{id}` - Update a group
- `DELETE /api/mailing-list/groups/{id}` - Delete a group
- `POST /api/mailing-list/groups/{groupId}/add-user/{userId}` - Add user to group
- `DELETE /api/mailing-list/groups/{groupId}/remove-user/{userId}` - Remove user from group

### Users

- `GET /api/mailing-list/users` - List all users
- `POST /api/mailing-list/users` - Create a new user
  ```json
  {
    "name": "John Doe",
    "email": "john@example.com"
  }
  ```
- `GET /api/mailing-list/users/{id}` - Get a specific user
- `PUT /api/mailing-list/users/{id}` - Update a user
- `DELETE /api/mailing-list/users/{id}` - Delete a user

### Email

- `POST /api/mailing-list/groups/{groupId}/send-email` - Send email to all group members
  ```json
  {
    "subject": "Important Announcement",
    "body": "<h1>Hello!</h1><p>This is the email body with HTML support.</p>"
  }
  ```

## Setup Instructions

### 1. Install Dependencies

```bash
composer install
```

### 2. Environment Configuration

Copy `.env.example` to `.env` if you haven't already:

```bash
cp .env.example .env
```

### 3. Configure Email Settings

Edit your `.env` file and add email configuration. Here are examples for different providers:

#### Gmail (SMTP)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

#### Mailtrap (for testing)
```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

#### SendGrid
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your-sendgrid-api-key
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-verified-email@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Run Migrations

```bash
php artisan migrate
```

This will create the `groups` and `group_members` tables.

### 6. Start the Development Server

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

## Accessing the Mailing List System

1. Log in as an admin user
2. Navigate to the admin dashboard
3. Click on "Mailing List" in the sidebar
4. You'll see the mailing list management interface

## Features

### Frontend UI

The frontend provides:
- **Groups Management**: Create, view, and delete groups
- **Users Management**: Create, view, and delete users
- **Add Users to Groups**: Add users to any group
- **Send Emails**: Compose and send HTML emails to all members of a group
- **Real-time Updates**: Lists update automatically after operations

### Input Validation

- Group names must be unique
- Email addresses must be valid and unique
- Required fields are validated on both frontend and backend
- Error messages are displayed clearly

### Error Handling

- API endpoints return JSON responses with success/error status
- Frontend displays user-friendly error messages
- Validation errors are shown for each field
- Network errors are caught and displayed

## Testing the System

### 1. Create a Group

1. Click "New Group" button
2. Enter a group name (e.g., "Marketing")
3. Optionally add a description
4. Click "Create"

### 2. Create Users

1. Click "New User" button
2. Enter name and email
3. Click "Create"

### 3. Add Users to Group

1. Click "Add User" on any group card
2. Select a user from the dropdown
3. Click "Add"

### 4. Send Email

1. Select a group from the dropdown
2. Enter email subject
3. Enter email body (HTML supported)
4. Click "Send Email"

## Email Configuration Notes

### Gmail Setup

If using Gmail, you need to:
1. Enable 2-factor authentication
2. Generate an "App Password" (not your regular password)
3. Use the app password in `MAIL_PASSWORD`

### Testing with Mailtrap

Mailtrap is great for testing because it captures all emails without actually sending them. Sign up at https://mailtrap.io for free.

## Troubleshooting

### Emails Not Sending

1. Check your `.env` file has correct email settings
2. Verify SMTP credentials are correct
3. Check Laravel logs: `storage/logs/laravel.log`
4. For Gmail, ensure you're using an App Password, not your regular password

### API Errors

1. Check browser console for JavaScript errors
2. Check Laravel logs for backend errors
3. Verify CSRF token is being sent (check meta tag in layout)

### Database Issues

1. Run `php artisan migrate:fresh` to reset database (WARNING: deletes all data)
2. Check database connection in `.env`
3. Verify migrations ran successfully

## File Structure

```
app/
├── Http/
│   └── Controllers/
│       └── Api/
│           ├── GroupController.php
│           ├── UserController.php
│           └── EmailController.php
├── Mail/
│   └── GroupEmail.php
└── Models/
    ├── Group.php
    └── User.php

database/
└── migrations/
    ├── 2025_11_21_141127_create_groups_table.php
    └── 2025_11_21_141134_create_group_members_table.php

resources/
└── views/
    ├── admin/
    │   └── mailing-list.blade.php
    └── emails/
        └── group-email.blade.php

routes/
└── api.php
```

## Security Considerations

- All API routes should be protected with authentication middleware in production
- CSRF protection is enabled for all forms
- Input validation prevents SQL injection and XSS attacks
- Email addresses are validated before sending

## Future Enhancements

Possible improvements:
- Email templates
- Scheduled emails
- Email history/logging
- Bulk user import (CSV)
- Email preview before sending
- Unsubscribe functionality
- Email analytics (open rates, etc.)

## Support

For issues or questions, check:
- Laravel documentation: https://laravel.com/docs
- Laravel Mail documentation: https://laravel.com/docs/mail

