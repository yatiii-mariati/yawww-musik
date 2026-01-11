
🟦 Yawww-Musik API & Web App
Yawww-Musik adalah sebuah aplikasi streaming musik berbasis Laravel yang menyediakan REST API (JWT Authentication) dan Web Interface.
Aplikasi ini memungkinkan pengguna untuk login, mengakses daftar lagu, streaming, serta menambahkan lagu ke playlist favorit.
.
________________________________________
🎧 FITUR UTAMA
🔐 Authentication
•	Login & Register User
•	JWT Authentication (tymon/jwt-auth)
•	Role-based Access (Admin & User)
•	Token Expiration & Refresh Token
•	Middleware Authorization
🎼 Music
•	List Lagu & Artis
•	Streaming Lagu
•	Detail Lagu & Album
❤️ Playlist
•	Tambah/Hapus Lagu ke Playlist
•	Simpan Playlist berdasarkan User
•	Playlist otomatis tersimpan di DB
🔒 Security
•	Protected Endpoints (JWT Required)
•	Tokens disimpan aman di Header
•	Role-based Authorization (Admin/User)
🧾 Activity Log
•	Mencatat aksi user seperti login dan playlist toggle
•	Disimpan di database
•	
________________________________________
🛠️ TEKNOLOGI YANG DIGUNAKAN
Backend	Tools
Laravel 12.x	Postman
PHP 8.2	JWT Auth
MySQL	Composer
Nginx/Apache	Git & GitHub


📁 STRUKTUR PROJECT
YAWWW/
└── yawww-musik/
    └── backend/
        └── laravel/
            ├── app/
            │   ├── Helpers/ 
            │   ├── Http/ 
            │   │   ├── Controllers/ 
            │   │   │   ├── admin/           
            │   │   │   ├── Api/             
            │   │   │   ├── Web/
            │   │   │   ├── Controller.php
            │   │   │   └── HomeController.php
            │   │   ├── Middleware/ [cite: 40]
            │   │   │   └── AdminMiddleware.php [cite: 41]
            │   │   └── Kernel.php
            │   └── Models/ [cite: 42]
            │       ├── Artist.php [cite: 44]
            │       ├── Song.php [cite: 45]
            │       ├── Playlist.php [cite: 46]
            │       └── User.php [cite: 43]
            ├── bootstrap/
            │   └── cache/
            ├── config/
            ├── database/
            │   ├── factories/
            │   ├── migrations/      
            │   └── seeders/
            ├── public/              
            │   ├── artists/         
            │   ├── css/             
            │   ├── img/             
            │   ├── js/
            │   ├── songs/           
            │   ├── storage/         
            │   ├── .htaccess
            │   ├── favicon.ico
            │   └── index.php
            ├── resources/
            │   ├── css/
            │   ├── js/
            │   └── views/           
            ├── routes/ [cite: 47]
            │   ├── api.php          
            │   └── web.php          
            ├── storage/             
            │   ├── app/
            │   │   ├── private/
            │   │   └── public/      
            │   ├── framework/
            │   └── logs/
            │       └── laravel.log  
            ├── tests/
            ├── vendor/              <-- (Library / Dependency Composer)
            ├── .env                 <-- (Konfigurasi Database & JWT) 
            ├── artisan
            ├── composer.json
            ├── package.json
            ├── README.
            └── vite.config.js

🔐 AUTHENTICATION (JWT)
Backend menggunakan JWT (JSON Web Token) dengan library:
tymon/jwt-auth
Setiap request ke endpoint API (selain login/register) wajib mengirim token:
Authorization: Bearer <token>
Token di-generate saat login, memiliki masa berlaku (expiry), refresh.

🧪 API TESTING (POSTMAN)
Login
POST http://127.0.0.1:8000/api/v1/login

Body:
{
    "email":"rawr@gmail.com",
    "password":"rawr123"
}

 
Get User
GET http://127.0.0.1:8000/api/v1/me

Get Songs
GET http://127.0.0.1:8000/api/v1/songs

Playlist
POST http://127.0.0.1:8000/api/v1/playlists
Body:
{
  "name": "Santai",
  "description": "Lagu enak sore hari"
}