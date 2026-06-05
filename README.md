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

## Alur Aplikasi
Sistem ini menggunakan Laravel sebagai backend utama yang menerima usia, pekerjaan, penghasilan dan foto rumah dari pengguna. Foto dikirim ke Roboflow API untuk diklasifikasikan menjadi rumah_buruk, rumah_sedang, atau rumah_baik. 

Karena Laravel sudah memiliki fitur HTTP Client yang dapat berkomunikasi langsung dengan API Roboflow, maka penggunaan Python untuk menghubungkan ke API Roboflow tidak diperlukan. Hal ini membuat arsitektur sistem lebih sederhana dan efisien.

Selanjutnya, Laravel mengirim 4 fitur — penghasilan, usia, pekerjaan, dan kondisi rumah — ke Flask API yang memuat model Decision Tree (model.pkl) untuk memprediksi kelayakan bansos.

```bash
User
  ↓
Laravel (input otomatis usia, pekerjaan, penghasilan + foto rumah)
  ↓
Roboflow API (klasifikasi rumah → rumah_buruk/sedang/baik)
  ↓
Flask API (prediksi kelayakan menggunakan algoritma Decision Tree)
  ↓
Laravel (tampilkan hasil)
```

Keputusan model bukan:

Rumah buruk = otomatis diterima

Gaji tinggi = otomatis ditolak

Tapi:

Rumah buruk menambah peluang, tapi gaji dan pekerjaan tetap menentukan

Gaji tinggi mengurangi peluang, tapi kalau lansia + rumah buruk tetap bisa diterima

## Fitur

- CRUD Data Warga
- Scan QR Warga
- Pengajuan Bantuan
- Klasifikasi Kondisi Rumah Berdasarkan Foto Rumah
- Sistem Skoring Kelayakan

---

## Teknologi

- **Backend**: PHP, Laravel 11
- **Frontend**: Tailwind CSS
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
