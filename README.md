## Penyiapan Environment

Untuk menjalankan aplikasi ini dengan Docker, ikuti langkah-langkah berikut:

1. Salin file `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   ```

2. Edit file `.env` dan sesuaikan nilai-nilai variabel dengan kebutuhan Anda:
   ```bash
   nano .env
   ```

3. Jalankan Docker Compose:
   ```bash
   docker-compose up -d
   ```

## Catatan Keamanan

- File `.env` berisi informasi sensitif dan TIDAK boleh dicommit ke repositori Git
- Pastikan `.env` sudah ditambahkan ke `.gitignore`
- Selalu gunakan password yang kuat untuk kredensial database
