# Aplikasi Bantuan Sosial

Aplikasi berbasis Laravel untuk membantu proses pengajuan bantuan sosial.

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

## Dataset & Model AI

Dataset dan model tersedia di Roboflow Universe:

https://universe.roboflow.com/rizkys-workspace-uddts/klasifikasi-rumah

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

### 2. Install Dependency Laravel

```bash
composer install
npm install
```

### 3. Install Dependency Python

```bash
pip install -r requirements.txt
```

### 4. Copy File Environment

Windows:

```bash
copy .env.example .env
```

Linux / MacOS:
```bash
cp .env.example .env
```

### 5. Generate Key

```bash
php artisan key:generate
```

### 6. Buat Database

Buat database baru di phpMyAdmin, lalu sesuaikan file `.env`

```env
DB_DATABASE=db_bansos
DB_USERNAME=root
DB_PASSWORD=
```

### 7. Konfigurasi Roboflow

Tambahkan konfigurasi berikut pada file `.env`

```env
ROBOFLOW_URL=https://detect.roboflow.com/klasifikasi-rumah/1?api_key=your_api_key
```

### 8. Jalankan Migration

```bash
php artisan migrate
```

### 9. Jalankan Project

Menjalankan AI Python

```bash
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
