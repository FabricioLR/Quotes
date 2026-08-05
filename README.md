# Citações Online
A web platform built with Laravel for discovering, searching, and managing literary and philosophical quotes, categorized by themes and authors.

## Technical Stack & Features

* **Backend Framework:** Laravel 13
* **Runtime:** PHP 8.3 / 8.4
* **Database:** PostgreSQL (with `unaccent` extension enabled for accent-insensitive searching)
* **Frontend:** Vite, TailwindCSS (v4), Alpine/Blade Templating
* **Sitemap Generation:** Automated dynamic XML sitemap support via `spatie/laravel-sitemap`
* **Search Engine:** Accent-insensitive, case-insensitive search across quotes, authors, and categories
* **Admin Dashboard:** Includes bulk JSON/TXT import capabilities for seeding quotes, along with author and category management
* **CI/CD & Containerization:** Docker environment with Docker Compose setups for local development and production, powered by a Jenkins deployment pipeline


## Prerequisites
* Docker & Docker Compose

## Getting Started

### Docker

1. **Clone the repository:**
```bash
git clone <repository-url>
cd Quotes
```

2. **Setup environment variables:**
```bash
cp .env.example .env

```

3. **Spin up the development environment:**
```bash
docker compose up -d

```

The application will automatically install composer/npm dependencies, run database migrations, seed initial data, and start up the server.


4. **Access the application:**
* **Web App:** `http://localhost:8000`
* **Vite Dev Server:** `http://localhost:5173`

## Environment Variables

Key configurable variables in your `.env` file:

| Variable | Description | Default |
| --- | --- | --- |
| `APP_NAME` | Application title | `Quotes`<br> |
| `DB_CONNECTION` | Database engine | `pgsql`<br> |
| `DB_HOST` | Database host | `db`<br> |
| `DB_DATABASE` | PostgreSQL database name | `dev`<br> |
| `DB_USERNAME` | PostgreSQL user | `dev`<br> |
| `DB_PASSWORD` | PostgreSQL password | `dev`<br> |
| `DEFAULT_ADMIN_EMAIL` | Credentials for seed administrator | `admin@admin.com`<br> |
| `DEFAULT_ADMIN_PASSWORD` | Credentials for seed administrator | `admin`<br> |
| `DEFAULT_ADMIN_NAME` | Credentials for seed administrator | `admin`<br> |

## Project Structure Highlights

* **`app/Console/Commands/GenerateSitemap.php`**: Artisan command (`sitemap:generate`) to build the dynamic XML sitemap.
* **`app/Services/`**: Dedicated business logic services for Authors, Categories, Quotes, Search, and Admin Panel functionality.
* **`docker/`**: Includes custom `Dockerfile`, Nginx configs, and entrypoint scripts for build stages.
* **`Jenkinsfile`**: Automated Jenkins pipeline configured to build and deploy Docker production containers (`docker-compose.prod.yaml`).

## Commands & Utility Scripts

* **Generate Sitemap:**
```bash
php artisan sitemap:generate
```