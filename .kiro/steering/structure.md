# Project Structure

## Root Directory Layout

```
lapas-jombang/
├── app/                    # Application core
├── bootstrap/              # Framework bootstrap
├── config/                 # Configuration files
├── database/               # Migrations, seeders, factories
├── public/                 # Web root (index.php, assets)
├── resources/              # Views, CSS, JS source
├── routes/                 # Route definitions
├── storage/                # Logs, cache, uploads
├── tests/                  # Test suites
└── vendor/                 # Composer dependencies
```

## App Directory Structure

### Controllers (`app/Http/Controllers/`)

**Admin Controllers** (`Admin/`)
- `DashboardController.php` - Main admin dashboard and statistics
- `ExecutiveDashboardController.php` - Executive-level analytics
- `KunjunganController.php` - Visit management (CRUD, verification, offline registration)
- `AntrianController.php` - Queue control system
- `QueueController.php` - Queue state management API
- `WbpController.php` - Inmate (WBP) management with restrictions
- `VisitorController.php` - Visitor database management
- `BannerController.php` - Homepage banner/slideshow management
- `NewsController.php` - News content management
- `AnnouncementController.php` - Announcements management
- `ProductController.php` - Product/gallery management
- `PegawaiController.php` - Staff management
- `GaleriController.php` - Gallery management
- `SurveyController.php` - Survey/IKM management
- `UserController.php` - User account management (super admin only)
- `VisitConfigController.php` - Visit system configuration
- `BroadcastController.php` - Mass notification system
- `InstitutionalInfoController.php` - Institution profile (vision, mission, etc.)
- `FinancialReportController.php` - Public financial reports
- `ReportCategoryController.php` - Report category management

**Public Controllers** (root level)
- `HomeController.php` - Homepage and public pages
- `KunjunganController.php` - Public visit registration and status
- `DisplayController.php` - Public queue display (TV screens)
- `AuthController.php` - Authentication
- `ProfileController.php` - User profile management
- `ContactController.php` - Contact form
- `SurveyController.php` - Public survey submission

**Auth Controllers** (`Auth/`)
- Laravel Breeze authentication scaffolding
- Password reset functionality

### Models (`app/Models/`)

**Core Models**
- `Kunjungan.php` - Visit records (main entity)
- `Wbp.php` - Inmates (Warga Binaan Pemasyarakatan)
- `WbpRestriction.php` - Inmate visit restrictions
- `ProfilPengunjung.php` - Visitor profiles
- `Pengikut.php` - Visitor followers/companions
- `Pendaftar.php` - Visit registrants

**Content Models**
- `News.php` - News articles
- `Announcement.php` - Announcements
- `Product.php` - Products/gallery items
- `Banner.php` - Homepage banners
- `Galeri.php` - Gallery items
- `InstitutionalInfo.php` - Institution information

**System Models**
- `User.php` - Admin users
- `Survey.php` - Satisfaction surveys
- `VisitSetting.php` - Visit configuration
- `VisitSchedule.php` - Visit schedules
- `AntrianStatus.php` - Queue status
- `BroadcastLog.php` - Broadcast history
- `BroadcastFailedLog.php` - Failed broadcasts
- `BroadcastTemplate.php` - Notification templates
- `FinancialReport.php` - Financial reports
- `ReportCategory.php` - Report categories
- `Contact.php` - Contact messages
- `Pegawai.php` - Staff records

### Commands (`app/Console/Commands/`)

- `AutoUpdateAntrian.php` - Automatic queue updates
- `SendVisitReminders.php` - Visit reminder notifications
- `MarkVisitsAsCompleted.php` - Auto-complete expired visits
- `KunjunganCheckWa.php` - WhatsApp notification checker
- `KunjunganTestNotify.php` - Test notification system
- `ExportKunjunganCommand.php` - Visit data export
- `TestMailConnection.php` - Email configuration test

### Other App Directories

- `app/Enums/` - Enumerations (e.g., `KunjunganStatus.php`)
- `app/Events/` - Event classes (e.g., `AntrianUpdated.php`)
- `app/Exports/` - Excel export classes (Maatwebsite/Excel)

## Routes (`routes/web.php`)

Routes are organized into logical groups:

1. **Public Pages** - Homepage, FAQ, contact, gallery, profile
2. **Visit Registration** - Guest registration, status check, ticket printing
3. **Authentication** - Login, logout, password reset
4. **User Area** - Visit history, profile management
5. **Admin Dashboard** - All admin roles (dashboard, reports, logs, surveys)
6. **Visit Operations** - super_admin + admin_registrasi (visit CRUD, queue, WBP, settings)
7. **Content Management** - super_admin + admin_humas (news, announcements, products, institutional info)
8. **Super Admin Only** - Executive dashboard, user management, profile settings

## Resources (`resources/`)

```
resources/
├── views/              # Blade templates
│   ├── admin/         # Admin panel views
│   ├── auth/          # Authentication views
│   ├── components/    # Reusable Blade components
│   ├── layouts/       # Layout templates
│   └── *.blade.php    # Public page views
├── css/               # Tailwind CSS source
└── js/                # JavaScript source (Alpine.js, Turbo)
```

## Database (`database/`)

```
database/
├── migrations/        # Database schema migrations
├── seeders/          # Database seeders
└── factories/        # Model factories for testing
```

## Public Assets (`public/`)

```
public/
├── img/              # Static images (logo, etc.)
├── build/            # Vite compiled assets (auto-generated)
└── storage/          # Symlinked to storage/app/public
```

## Configuration Files

Key configuration files in `config/`:
- `database.php` - Database connections
- `queue.php` - Queue configuration (Redis)
- `cache.php` - Cache configuration (Redis)
- `mail.php` - Email configuration
- `filesystems.php` - Storage configuration

## Naming Conventions

- **Controllers**: PascalCase with `Controller` suffix
- **Models**: PascalCase, singular (e.g., `Kunjungan`, `Wbp`)
- **Database Tables**: snake_case, plural (e.g., `kunjungans`, `wbps`)
- **Routes**: kebab-case for URLs (e.g., `/kunjungan/daftar`)
- **Views**: kebab-case for filenames (e.g., `create-offline.blade.php`)
- **Methods**: camelCase (e.g., `createOffline()`)

## Key Architectural Notes

1. **RBAC Implementation**: Middleware-based role checking in route groups
2. **Base64 Storage**: KTP photos and QR codes stored in database as LongText
3. **Eager Loading**: Extensive use of `with()` to optimize N+1 queries
4. **API Routes**: Mixed in `web.php` with `/api/` prefix for AJAX endpoints
5. **Real-time Updates**: Redis + Events for queue broadcasting
6. **Throttling**: Rate limiting on guest submissions and login attempts
