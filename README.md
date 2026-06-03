# Aplikasi Bantuan Sosial

Aplikasi berbasis Laravel untuk membantu proses pengajuan bantuan sosial.

Aplikasi ini menggunakan AI untuk membantu proses penilaian kelayakan penerima bantuan sosial, yaitu:

- Menggunakan model Computer Vision dari Roboflow untuk mendeteksi kondisi rumah warga (`kondisi_rumah`) melalui foto rumah.
- Menggunakan Machine Learning berbasis Python untuk menentukan kelayakan penerima bantuan berdasarkan beberapa parameter:
  - `penghasilan`
  - `usia`
  - `pekerjaan`
  - `kondisi_rumah`

Hasil klasifikasi digunakan sebagai pendukung keputusan dalam proses seleksi penerima bantuan sosial.

## Fitur

- CRUD Data Warga
- Pengajuan Bantuan
- Upload Foto Rumah
- Sistem Skoring Kelayakan

---

## Teknologi

- **Backend**: PHP, Laravel 11
- **Frontend**: JavaScript, Bootstrap, Tailwind CSS
- **Database**: MySQL
- **Machine Learning**: Python, Scikit-learn
- **Computer Vision**: Roboflow

## Dataset & Model AI

Dataset dan model tersedia di Roboflow Universe:

https://universe.roboflow.com/rizkys-workspace-uddts/klasifikasi-rumah

---

## Cara Menjalankan Project

### 1. Clone Repository

Pastikan Git sudah terinstall pada komputer. Buka Git Bash, kemudian jalankan perintah berikut untuk meng-clone repository:

```bash
git clone https://github.com/Rizzdhr/Aplikasi-Bantuan-Sosial.git
```

Masuk ke folder project:

```bash
cd Aplikasi-Bantuan-Sosial
```

```bash
code .
```

### Buka Terminal (Command Prompt) pada VS Code:

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

Sesuaikan konfigurasi berikut pada file `.env`

```env
ROBOFLOW_URL=https://detect.roboflow.com/klasifikasi-rumah/1?api_key=your_api_key
```
Ganti nilai `your_api_key` dengan API Key Roboflow yang Anda miliki. API Key dapat diperoleh melalui akun Roboflow anda pada proyek yang digunakan.

### 8. Jalankan Migration

```bash
php artisan migrate
```

### 9. Jalankan Seeder

Perintah ini digunakan untuk mengisi data awal (master data) yang dibutuhkan aplikasi.

```bash
php artisan db:seed
```

### 10. Jalankan Project

Menjalankan AI Python

```bash
python app.py
```

Menjalankan Aplikasi

```bash
php artisan serve
```

Buka browser:

http://127.0.0.1:8000

---

## Dataset

Dataset tersimpan di folder `app/dataset/`:

- `ktp_tabular_v2.csv` - Dataset tabular


---

## Kontak

-   **[Instagram](https://www.instagram.com/rizzdhr/)**
