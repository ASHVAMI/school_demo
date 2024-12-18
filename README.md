
# School Management System

A PHP-based school management system with student and class management capabilities, including image upload functionality.

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- PHP Extensions:
  - PDO
  - PDO_MySQL
  - GD (for image processing)
  - FileInfo

## Installation

1. Clone the repository:
   
git clone https://github.com/yourusername/school_demo.git
cd school_demo

1. Create a MySQL database:

CREATE DATABASE school_db;

3. Import the database schema:

mysql -u your_username -p school_db < schema.sql

4. Configure the database connection:
- Open `config/database.php`
- Update the following variables with your database credentials:
  ```php
  private $host = "localhost";
  private $db_name = "school_db";
  private $username = "your_username";
  private $password = "your_password";

5. Set up the uploads directory:

mkdir uploads
chmod 777 uploads


## Project Structure

```
school_demo/
├── config/           # Database configuration
├── classes/          # Class definitions
├── includes/         # Reusable components
├── uploads/          # Uploaded images
├── assets/          # CSS, JavaScript files
└── *.php            # Main PHP files
```

## Features

- Complete CRUD operations for students and classes
- Image upload with validation
- Responsive design using Bootstrap
- Form validation and error handling
- Security measures:
  - SQL injection prevention
  - XSS prevention
  - Input validation
  - Secure file uploads

## Usage

1. Start your local web server (Apache/Nginx)
2. Navigate to the project URL in your browser:


## Main Pages

- `index.php` - List all students
- `create.php` - Add new student
- `edit.php` - Edit existing student
- `view.php` - View student details
- `delete.php` - Delete student
- `classes.php` - Manage classes

## Development Setup

### For Windows (XAMPP)

1. Install XAMPP
2. Clone the repository to `C:\xampp\htdocs\school_demo`
3. Start Apache and MySQL from XAMPP Control Panel
4. Access the application at `http://localhost/school_demo`

### For Linux (Ubuntu/Debian)

1. Install required packages:

sudo apt update
sudo apt install apache2 php mysql-server php-mysql php-gd

2. Enable PHP extensions:

sudo phpenmod pdo pdo_mysql fileinfo gd

3. Restart Apache:

sudo service apache2 restart

## Security Considerations

1. File Upload Security:
   - Only allows image files (jpg, png)
   - Validates file size and type
   - Generates unique filenames
   - Restricts upload directory permissions

2. Database Security:
   - Uses PDO prepared statements
   - Input validation and sanitization
   - Prevents SQL injection

3. XSS Prevention:
   - HTML escaping
   - Input sanitization
   - Output encoding

## Troubleshooting

### Common Issues

1. Upload directory permissions:
   
chmod 777 uploads

1. Database connection issues:
- Verify database credentials
- Ensure MySQL service is running
- Check database user permissions

1. Image upload fails:
- Check PHP upload_max_filesize in php.ini
- Verify GD extension is enabled
- Ensure uploads directory exists and is writable

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a new Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Acknowledgments

- Bootstrap for responsive design
- PHP community for best practices and security guidelines
  
>>>>>>> decfa90 (Initial commit)
