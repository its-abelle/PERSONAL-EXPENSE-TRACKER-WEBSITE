# Personal Expense Tracker

Short description
A simple PHP-based personal expense tracker that lets users add income, expenses and savings, and view records.

## Features
- Add income, expense and savings entries
- View records
- Basic user session authentication

## Prerequisites
- PHP 7.4+ (or compatible)
- MySQL / MariaDB (or adjust config)
- Composer (if you add dependencies)
- Web server (Apache / Nginx) or built-in PHP server for local testing

## Installation (local)
1. Clone the repo:
   ```
   git clone https://github.com/YourGitHubUsername/PERSONAL-EXPENSE=TRACKER.git
   cd PERSONAL-EXPENSE-TRACKER
   ```
2. Copy config example and update DB credentials:
   ```
   copy config.php config.php.example
   ```
   Edit `config.php` locally (do NOT commit it).

3. Install dependencies (if any):
   ```
   composer install
   ```

4. Start local server (optional):
   ```
   php -S localhost:8000 -t .
   ```
   Then open http://localhost:8000/php/dashboard.php

## Configuration
- Create a `config.php` in `php/` (or project root per your setup) containing database credentials and session start code.
- Keep `config.php` out of version control. Use `config.php.example` to show required variables.

## Usage
- Register/login, then use the dashboard to add income/expense/savings.
- View records via the "View Records" page.

## Contributing
- Open an issue or submit a PR.
- Keep sensitive information out of commits.



