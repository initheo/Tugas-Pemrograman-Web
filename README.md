Nama Kelompok:

-   3012310010 Faiz Nurullah
-   3012310023 Muhammad Muqoffin Nuha
-   3012310005 Ari Setia Hinanda

# Instalasi Project Laravel + Vite

## Persyaratan

-   PHP >= 8.2
-   Composer
-   Node.js & npm

## Langkah Instalasi

1. **Clone repository** (jika belum):

    ```bash
    git clone <url-repo>
    cd <nama-folder>
    ```

2. **Install dependency PHP**

    ```bash
    composer install
    ```

3. **Install dependency JavaScript**

    ```bash
    npm install
    ```

4. **Copy file environment**

    ```bash
    cp .env.example .env
    ```

5. **Generate application key**

    ```bash
    php artisan key:generate
    ```

6. **Migrasi database**

    ```bash
    php artisan migrate
    ```

7. **Jalankan server Laravel**

    ```bash
    php artisan serve
    ```

8. **Jalankan Vite (untuk asset frontend)**
    ```bash
    npm run dev
    ```

# Daftar Route

| Method | URI        | Controller         | Keterangan      |
| ------ | ---------- | ------------------ | --------------- |
| GET    | /          | -                  | Halaman Welcome |
| CRUD   | /kontaks   | KontakController   | Resource        |
| CRUD   | /users     | UserController     | Resource        |
| CRUD   | /events    | EventController    | Resource        |
| CRUD   | /employees | EmployeeController | Resource        |
| CRUD   | /tokos     | TokoController     | Resource        |
| CRUD   | /produks   | ProdukController   | Resource        |
| CRUD   | /films     | FilmController     | Resource (AJAX) |
| CRUD   | /notes     | NoteController     | Resource (AJAX) |
| CRUD   | /books     | BookController     | Resource (AJAX) |
| CRUD   | /songs     | SongController     | Resource (AJAX) |
| CRUD   | /hobis     | HobiController     | Resource        |

> Keterangan: Route resource otomatis menyediakan endpoint CRUD (index, create, store, show, edit, update, destroy)

---

Silakan sesuaikan konfigurasi database di file `.env` sebelum menjalankan migrasi.
