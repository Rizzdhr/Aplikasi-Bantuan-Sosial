# Aplikasi Smart Bantuan Sosial

Aplikasi berbasis Laravel untuk membantu proses pengajuan dan pengelolaan bantuan sosial.

## Fitur

- CRUD Data Warga
- Pengajuan Bantuan
- Upload Foto Rumah
- Verifikasi Lokasi
- Sistem Skoring Kelayakan

---

## Teknologi

- PHP
- Laravel
- MySQL
- Bootstrap
- JavaScript

---

## Cara Menjalankan Project

### 1. Clone Repository

```bash
git clone https://github.com/Rizzdhr/Aplikasi-Bantuan-Sosial.git
```

Masuk ke folder project:

```bash
cd Aplikasi-Bantuan-Sosial
```

### 2. Install Dependency

```bash
composer install
npm install
```

### 3. Copy File Environment

Windows:

```bash
copy .env.example .env
```

Linux / MacOS:
```bash
cp .env.example .env
```

### 4. Generate Key

```bash
php artisan key:generate
```

### 5. Buat Database

Buat database baru di phpMyAdmin, lalu sesuaikan file .env

```bash
DB_DATABASE=db_bansos
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Jalankan Migration

```bash
php artisan migrate
```

### 7. Jalankan Project

Menjalankan AI Python

```bash
pip install -r requirements.txt
python app.py
```

Menjalankan Aplikasi

```bash
php artisan serve
```

Buka browser:

```text
http://127.0.0.1:8000
```

---

## Kontak

-   **[Instagram](https://www.instagram.com/rizzdhr/)**
