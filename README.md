# hris

A Laravel human resources information system with role-based access to employee and operational workflows.

[Repository](https://github.com/MirzaAlbab/hris)

## Features

- Employee, department, and role management
- Attendance, payroll, and leave-request modules
- Leave approval and rejection actions
- Task management and dashboard routes

## Technology

`php` ^8.2 · `laravel/framework` ^12.0 · `laravel/tinker` ^2.10.1

## Getting started

Install PHP compatible with `composer.json`, Composer, Node.js, and a database supported by the application.

```bash
git clone https://github.com/MirzaAlbab/hris.git
cd hris
```

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Set `APP_URL` and the `DB_*` values in `.env` for your local database. Configure any mail, payment, or other external service used by this project.

```bash
php artisan migrate
npm install
npm run build
php artisan serve
```

Open the URL printed by Artisan. For ongoing frontend development, run `npm run dev` in another terminal.

## Development and checks

```bash
php artisan test
```

Review `tests/` for the current test scope. A configured test runner does not imply coverage of every business workflow.

## Project structure

- `app/` — Application source
- `config/` — Application configuration
- `database/` — Migrations, factories, and seeders
- `public/` — Public web assets and entry points
- `resources/` — Frontend templates and assets
- `routes/` — HTTP route definitions
- `tests/` — Test suite and support files

## Project notes

Roles referenced by routes include HR, Developer, and Sales. Review account provisioning and record-level access rules before deployment. Uses Laravel 12.

## Framework

Built with [Laravel](https://laravel.com/docs). Framework packages and third-party dependencies retain their own licenses.

## License

No root `LICENSE` file was present in the reviewed repository. Consult the repository owner about reuse; dependencies and third-party assets retain their own terms.
