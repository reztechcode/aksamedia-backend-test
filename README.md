# Backend API – Web Developer Intern Test

**PT Aksamedia Mulia Digital**

Backend API ini dibuat untuk memenuhi **Tugas 2 – Back End Web Developer Intern Test**.
Aplikasi dibangun menggunakan **Laravel + Sanctum** dan menyediakan fitur autentikasi serta CRUD data karyawan dengan filter dan pagination.

---

## Tech Stack

* Laravel
* Laravel Sanctum (API Token Authentication)
* MySQL / MariaDB
* Eloquent ORM
* Form Request Validation
* Postman (testing API)

---

## Fitur

* Login & Logout menggunakan token (Sanctum)
* Middleware proteksi endpoint sesuai soal
* Get data divisions (filter + pagination)
* CRUD data employees
* Upload foto karyawan
* Filter employee berdasarkan nama dan divisi
* Pagination menggunakan pagination Laravel
* Response API konsisten (`status`, `message`, `data`, `pagination`)

---

## Aturan Akses Endpoint

| Endpoint                 | Auth                          |
| ------------------------ | ----------------------------- |
| `POST /login`            | ❌ Hanya bisa saat belum login |
| `GET /divisions`         | ✅ Wajib login                 |
| `GET /employees`         | ✅ Wajib login                 |
| `POST /employees`        | ✅ Wajib login                 |
| `PUT /employees/{id}`    | ✅ Wajib login                 |
| `DELETE /employees/{id}` | ✅ Wajib login                 |
| `POST /logout`           | ✅ Wajib login                 |

---

## Akun Login (Seeder)

```json
{
  "username": "admin",
  "password": "pastibisa"
}
```

---

## Autentikasi

API menggunakan **Laravel Sanctum (Bearer Token)**.

Header yang digunakan:

```
Authorization: Bearer {token}
```

---

## Dokumentasi API

### 1. Login

**POST** `/api/login`

Request:

```json
{
  "username": "admin",
  "password": "pastibisa"
}
```

Response sukses:

```json
{
  "status": "success",
  "message": "Login berhasil.",
  "data": {
    "token": "token_string",
    "admin": {
      "id": "uuid",
      "name": "Admin",
      "username": "admin",
      "phone": "08xxxxxxxx",
      "email": "admin@mail.com"
    }
  }
}
```

---

### 2. Get All Divisions

**GET** `/api/divisions`

Query (optional):

```
?name=Front
```

Response:

```json
{
  "status": "success",
  "message": "OK",
  "data": {
    "divisions": [
      {
        "id": "uuid",
        "name": "Frontend"
      }
    ]
  },
  "pagination": {
    "current_page": 1,
    "total": 6
  }
}
```

---

### 3. Get All Employees

**GET** `/api/employees`

Query:

```
?name=Agus&division_id=uuid
```

Response:

```json
{
  "status": "success",
  "message": "OK",
  "data": {
    "employees": [
      {
        "id": "uuid",
        "image": "http://localhost/storage/employees/photo.jpg",
        "name": "Agus",
        "phone": "08xxxx",
        "division": {
          "id": "uuid",
          "name": "Frontend"
        },
        "position": "Frontend Developer"
      }
    ]
  },
  "pagination": {
    "current_page": 1,
    "total": 10
  }
}
```

---

### 4. Create Employee

**POST** `/api/employees`

Request (form-data):

| Key      | Type |
| -------- | ---- |
| image    | file |
| name     | text |
| phone    | text |
| division | uuid |
| position | text |

Response:

```json
{
  "status": "success",
  "message": "Berhasil menambahkan karyawan.",
  "data": {}
}
```

---

### 5. Update Employee

**PUT** `/api/employees/{id}`

Request: sama seperti create.

Response:

```json
{
  "status": "success",
  "message": "Berhasil memperbarui karyawan.",
  "data": {}
}
```

---

### 6. Delete Employee

**DELETE** `/api/employees/{id}`

Response:

```json
{
  "status": "success",
  "message": "Berhasil menghapus karyawan.",
  "data": {}
}
```

---

### 7. Logout

**POST** `/api/logout`

Response:

```json
{
  "status": "success",
  "message": "Logout berhasil.",
  "data": {}
}
```
