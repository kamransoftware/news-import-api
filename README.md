# 📰 News Import API

This Laravel application provides a RESTful API to upload and process CSV files containing news articles asynchronously.

## 🚀 Features

- Upload CSV via API
- Async background processing (queue)
- Validates each row, saves errors to Excel
- Track import status
- Download error reports

---

## 🧱 Tech Stack

- Laravel 10+
- SQLite
- Laravel Queues (database driver)
- league/csv
- phpoffice/phpspreadsheet
- Docker

---

## 🐳 Docker Setup

### 1. Clone & Build

```bash
git clone https://github.com/your-username/news-import-api.git
cd news-import-api
docker-compose build
