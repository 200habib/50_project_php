# Blog Post System

A simple blog post system with comments functionality built in PHP.

## Project Structure
```
blog_post/
├── config.php      # Database and application configuration
├── functions.php   # Helper functions
├── index.php      # Main blog post page
├── style.css      # Styling
└── database.sql   # Database structure
```

## Setup Instructions

1. Import the database structure:
```sql
mysql -u root < database.sql
```

2. Configure your database settings in `config.php`:
- Update DB_USER and DB_PASS if needed
- Update BASE_URL according to your server configuration

3. Make sure your web server (Apache/Nginx) points to this directory

4. Open the blog post in your browser:
```
http://localhost/blog_post
```

## Features
- Single blog post display with image
- Comment system
- Clean and responsive design
- XSS protection
- Error handling
- Date formatting
