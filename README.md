# 🚗 Vehicle Telemetry Platform

This is a real-time vehicle monitoring platform built with a Laravel + MySQL backend and a Raspberry Pi-based client that collects OBD-II car data via Bluetooth and sends it via GSM to a custom API endpoint.

---

## 📦 Tech Stack

### 🔧 Backend
- **Laravel 10** (PHP 8.1+)
- **MySQL**
- **Custom Permissions System** (Roles: `fleet`, `family`)
- **Sanctum** for API authentication
- **ChartJS** for visualizing data
- **PHP CS Fixer** for code formatting

### 🚙 Raspberry Pi Client
- **Raspberry Pi** with Bluetooth
- **Python Scripts** for:
  - Connecting to OBD-II reader via Bluetooth
  - Connecting to USB modem
  - Parsing and formatting car data
  - Sending data through USB GSM modem (HTTP POST)
- Scripts are located in the `scripts/` folder

---

## 🛠 How It Works

1. **Raspberry Pi** connects to a car's OBD-II device over Bluetooth.
2. It uses **Python scripts** to collect telemetry data (speed, RPM, etc.).
3. The data is sent in real-time via GSM to your **Laravel backend API**.
4. Laravel receives the data, stores it in MySQL, and displays it in:
   - Tables
   - Charts
   - Reports

---

## 🚀 Installation Instructions

### 🧱 Backend (Laravel)

```bash
git clone <your-repo-url>
cd diagnostics
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
