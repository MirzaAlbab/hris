# Local demo walkthrough

The demo uses fictional people and known local-only credentials. It is intended for evaluating the interface and workflows on your own machine.

## Docker setup

```bash
docker compose -f compose.demo.yaml up --build
```

Wait for the server-ready message, then open http://localhost:8000. The first run builds frontend assets, installs production PHP dependencies, migrates a dedicated SQLite database, and runs `DemoSeeder`. Later starts preserve existing record changes.

The database lives at `/app/storage/demo/database.sqlite` in a dedicated named volume. The application runs as an unprivileged user. An application key is generated on startup, so restarting requires signing in again.

Stop the demo while keeping data:

```bash
docker compose -f compose.demo.yaml down
```

To reset **only this Compose project's demo data**, remove its demo volume and start again:

```bash
docker compose -f compose.demo.yaml down --volumes
docker compose -f compose.demo.yaml up
```

## Accounts

All accounts use `demo-password`:

| Email | Employee | Role |
| --- | --- | --- |
| `hr@hris.example` | Avery Morgan | HR |
| `developer@hris.example` | Jordan Lee | Developer |
| `sales@hris.example` | Riley Taylor | Sales |

`DemoSeeder` is separate from `DatabaseSeeder`. It links each login to an employee and role, avoids duplicating the same sample records on rerun, and only runs in `local` or `testing` environments. Rerunning resets demo passwords and can add new date-based records as the month changes; it does not erase existing records.

## Suggested walkthrough

1. Sign in as HR. Check dashboard totals and the twelve-month attendance chart.
2. Open Leave Request and confirm Jordan Lee's vacation request. Reject can reverse the decision.
3. Open Task to see assignments for all three employees.
4. Use Logout, then sign in as Developer. Mark the release checklist Done, then Pending.
5. Check Leave Request, Presences, and Payrolls as the employee. Only that employee's records appear. Opening `/employees` returns 403.
6. Sign in as Sales to explore Riley Taylor's records and assignment.

Attendance self check-in retains the application's location-based UI. Browser location permission and the configured office coordinates are relevant to that flow; the smoke tests focus on task and leave workflows.

## Setup without Docker

Use a fresh checkout so demo settings cannot replace an existing application's `.env`:

```bash
composer install
npm ci
npm run build
cp .env.demo.example .env
php artisan key:generate
touch database/demo.sqlite
php artisan migrate
php artisan db:seed --class=DemoSeeder
php artisan serve --port=8000
```

The sample environment uses `database/demo.sqlite` relative to the project root. Set an absolute path if your server uses another working directory. Do not point the demo at a production database.

## Browser checks and screenshots

With the demo running:

```bash
npm ci
npx playwright install chromium
npm run test:browser
```

The browser checks change fictional leave and task statuses. They are repeatable against the same demo and must not target real employee data.

Refresh README screenshots on a POSIX shell:

```bash
CAPTURE_DEMO_SCREENSHOTS=1 npm run test:browser
```

This writes `dashboard.png`, `leave-requests.png`, and `employee-tasks.png` under `docs/screenshots/`. Review images before committing.

For an existing Chromium installation, set `PLAYWRIGHT_CHROMIUM_EXECUTABLE_PATH` to its executable. `DEMO_URL` overrides the default `http://127.0.0.1:8000` target.

## Deployment scope

Compose exposes only localhost, uses a PHP development server, and supplies known demo passwords. A hosted deployment needs its own application key, HTTPS, account provisioning, database configuration, and production server setup.
