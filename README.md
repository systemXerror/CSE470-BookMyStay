<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# Hotel Management System

A comprehensive Laravel-based hotel management system with booking, user management, and admin features.

## Features

- **User Management**: Registration, login, profile management
- **Hotel & Room Management**: Browse hotels, view room details, check availability
- **Booking System**: Make reservations with extra services and discount codes
- **Admin Panel**: Complete admin interface for managing hotels, rooms, bookings, and users
- **Special Offers**: Discount codes and promotional offers
- **Review System**: User reviews for hotels and rooms
- **Notification System**: Real-time notifications for bookings and updates

## Quick Start

### Prerequisites

- PHP 8.1 or higher
- Composer
- SQLite (included) or MySQL
- Web server (Apache/Nginx) or PHP built-in server

### Installation

1. **Clone or download the project**
   ```bash
   cd hotel_management
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Set up environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Run migrations and seeders**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

### Starting the Server

#### Option 1: Using the custom command
```bash
php artisan serve:hotel
```

#### Option 2: Using the batch file (Windows)
```bash
start-server.bat
```

#### Option 3: Using the PowerShell script (Windows)
```powershell
.\start-server.ps1
```

#### Option 4: Manual command
```bash
php artisan serve --host=0.0.0.0 --port=8000
```

### Access the Application

Once the server is running, you can access the application at:
- **Main site**: http://localhost:8000
- **Admin panel**: http://localhost:8000/admin/dashboard

### Default Login Credentials

**Admin User:**
- Email: admin@bookmystay.com
- Password: password

**Regular User:**
- Register a new account at http://localhost:8000/register

## Test Discount Codes

The system includes several test discount codes:

- **WELCOME10**: 10% off first booking (minimum $100)
- **SUMMER50**: $50 off bookings over $200
- **LUXURY20**: 20% off luxury suites (minimum $300)
- **WEEKEND25**: 25% off weekend bookings (minimum $150)

## Project Structure

```
hotel_management/
├── app/
│   ├── Http/Controllers/          # Controllers
│   ├── Models/                    # Eloquent models
│   └── Console/Commands/          # Custom Artisan commands
├── database/
│   ├── migrations/                # Database migrations
│   └── seeders/                   # Database seeders
├── resources/views/               # Blade templates
│   ├── admin/                     # Admin panel views
│   ├── user/                      # User interface views
│   └── auth/                      # Authentication views
├── routes/                        # Route definitions
├── public/                        # Public assets
└── config/                        # Configuration files
```

## Troubleshooting

### Connection Refused Error

If you get "localhost refused to connect":

1. **Use the correct host binding:**
   ```bash
   php artisan serve --host=0.0.0.0 --port=8000
   ```

2. **Check if port 8000 is available:**
   ```bash
   netstat -an | findstr :8000
   ```

3. **Try a different port:**
   ```bash
   php artisan serve --host=0.0.0.0 --port=8080
   ```

### Database Issues

1. **Reset database:**
   ```bash
   php artisan migrate:fresh --seed
   ```

2. **Clear cache:**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   ```

### Permission Issues

1. **Set proper permissions on storage and bootstrap/cache:**
   ```bash
   chmod -R 775 storage bootstrap/cache
   ```

## Development

### Adding New Features

1. **Create migration:**
   ```bash
   php artisan make:migration create_new_table
   ```

2. **Create model:**
   ```bash
   php artisan make:model ModelName
   ```

3. **Create controller:**
   ```bash
   php artisan make:controller ControllerName
   ```

4. **Create seeder:**
   ```bash
   php artisan make:seeder SeederName
   ```

### Code Style

The project follows Laravel conventions and PSR-12 coding standards.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

For support and questions, please refer to the Laravel documentation or create an issue in the project repository.
