# 📰 News Import API

This Laravel application provides a RESTful API to upload and process CSV files containing news articles asynchronously.

Sample CSV file is located here: data/sample_news.csv

Postman Collection accessible here: https://api.postman.com/collections/15423844-1e0d0095-3052-4c51-a772-70b6a65501df?access_key=PMAT-01K17AKR45J1WKTZGFH9EBHBXZ

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
git clone https://github.com/kamransoftware/news-import-api.git
cd news-import-api
docker compose build
docker compose up