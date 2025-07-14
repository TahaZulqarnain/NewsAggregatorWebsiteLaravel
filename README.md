# Laravel News Aggregator

A Laravel 11 application that aggregates articles from multiple external news APIs and stores them locally. It uses scheduled tasks for regular updates, repository pattern for code structure, and logs every API interaction.

---

## Features

-  Fetches articles from:
  - [NewsAPI.org](https://newsapi.org/)
  - [New York Times](https://developer.nytimes.com/)
  - [EventRegistry (NewsAPI.ai)](https://eventregistry.org/).

-  Stores data in MySQL with fields: `title`, `description`, `content`, `author`, `source`, `category`, `published_at`, and `image`.
-  Cron runs every 10 minutes using Laravel’s scheduler or you can run it manually.
-  Logs each API request/response in `api_logs` table (success & failure).
-  Sample Postman Collection provided.
-  Database zip file also provided

---

## ⚙️ Requirements

- PHP 8.2+
- Laravel 11
- Composer
- MySQL
- Git
- (Optional) Postman

---

## 🧑‍💻 Installation (Local Dev)

1. **Clone the repository**
   ```bash
   git clone https://github.com/TahaZulqarnain/NewsAggregatorWebsiteLaravel.git
   cd news-website

## Install Dependencies

composer install
npm install && npm run dev

## Copy .env file

cp .env.example .env
php artisan key:generate

## Setup Database

Create a MySQL DB (e.g., news_website)
Update .env with DB credentials

## Run Scheduler Locally

php artisan schedule:work

## Run the APP

php artisan serve
