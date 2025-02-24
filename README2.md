# 🎮 Video Game Management System API

## 📌 Project Overview

The **Video Game Management System API** is a RESTful API built with Laravel, allowing users to manage video games with
authentication, game creation, updates, deletion, and filtering features. Users can also rate and review their own
games. This API supports **role-based access control**, ensuring only authorized users can modify their game, and only
an admin can delete one.

---

## 🚀 Features

- ✅ **User authentication** using Laravel Sanctum.
- ✅ **CRUD operations** for managing video games.
- ✅ **Role-based permissions** (Admin vs. Regular Users).
- ✅ **Filtering and sorting options** for games.
- ✅ **Users can rate and review** any of their games.
- ✅ **Users can retrieve** their own reviews and ratings.
- ✅ **API documentation** available in Postman Collection.

---

## 🔑 Key Features

- **Authorization using Laravel Policies**: Secure access control, ensuring only the owner or admin can modify game
  data.
- **API Resource Routes**: Uses `apiResource` in routes for better RESTful structure.
- **Laravel Form Requests**: Handles validation to keep controllers clean and ensure request data integrity.
- **Laravel JSON Resources**: Structures API responses for better clarity and consistency.
- **Middleware Protection**: Ensures authenticated users can only access specific routes.
- **Pagination Support**: API responses include paginated data for better performance.
- **Rate Limiting**: All API calls are limited to **20 requests per minute** to prevent abuse.
- **Throttling Login Attempts**: Users are limited to **10 login attempts per minute** for security purposes.
- **Eager Loading**: Prevents N+1 query issues, optimizing database performance.
- **Focused on Laravel Best Practices**: Ensures performance, scalability, and maintainability by following Laravel's
  recommended development standards.

---

## 🛠️ Installation

### 1️⃣ Prerequisites

Ensure you have the following installed:

- PHP 8.1+
- Composer 2.6+
- MySQL
- Laravel 10.2

### 2️⃣ Clone the Repository

```sh
git clone https://github.com/Kyros99/VideoGamesApi.git
cd videogamesapi
```

### 3️⃣ Install Dependencies

```sh
composer install
```

### 4️⃣ Configure Environment

Copy the `.env.example` file and set up your database credentials:

```sh
cp .env.example .env
```

Then update your `.env` file:

```ini
DB_CONNECTION = mysql
DB_HOST = 127.0.0.1
DB_PORT = 3306
DB_DATABASE = videogamesdb
DB_USERNAME = root
DB_PASSWORD = yourpassword
```

### 5️⃣ Generate Application Key

```sh
php artisan key:generate
```

### 6️⃣ Run Migrations and Seed Database

```sh
php artisan migrate --seed
```

### 7️⃣ Serve the Application

```sh
php artisan serve
```

By default, the application runs on `http://127.0.0.1:8000`.

---

## 🔑 Authentication

The API uses **Laravel Sanctum** for authentication.

### Register a User

**POST** `/api/register`

#### Request Body:

```json
{
    "name": "John Doe",
    "email": "johndoe@example.com",
    "password": "password123",
    "is_admin": false
}
```

### Login

**POST** `/api/login`

#### Response:

```json
{
    "access_token": "your_token_here"
}
```

### Use the Token in Requests

Include the token in your requests:

```
Authorization: Bearer your_token_here
```

---

## 🎮 API Endpoints

### 🔹 User Authentication

| Method   | Endpoint        | Description                                    |
|----------|-----------------|------------------------------------------------|
| **POST** | `/api/register` | Register a new user                            |
| **POST** | `/api/login`    | Login and receive an authentication token      |
| **POST** | `/api/logout`   | Logout the authenticated user (Requires Token) |

### 🔹 Game Management

| Method     | Endpoint                    | Description                                                                                         |
|------------|-----------------------------|-----------------------------------------------------------------------------------------------------|
| **POST**   | `/api/games`                | Create a new game (requires authentication)                                                         |
| **PATCH**  | `/api/games/{game}`         | Update a game (only owner)                                                                          |
| **DELETE** | `/api/games/{game}`         | Delete a game (only owner or admin)                                                                 |
| **GET**    | `/api/games`                | Retrieve all games with filtering options (requires authentication). If admin, retrieves all games. |
| **GET**    | `/api/games/{game}`         | Retrieves a game based on id(required authentication)                                               |
| **POST**   | `/api/games/{game}/rate`    | Rate a game (only owner can rate their game)                                                        |
| **GET**    | `/api/games/{game}/ratings` | Get the user's rating for their own game                                                            |
| **POST**   | `/api/games/{game}/review`  | Review a game (only owner can review their game)                                                    |
| **GET**    | `/api/games/{game}/reviews` | Get the user's review and rating for their own game                                                 |

---

## 📜 Filtering & Sorting

Filtering and sorting are optional.

- `?sort=asc|desc` → Sort by release date (asc or desc).
- `?genre=RPG` → Filter by genre (e.g., Action, RPG).

Accepted genres: Action, Adventure, RPG, Sports, FPS, Strategy, Puzzle

#### Example:

```sh
GET /api/games?sort=desc&genre=Action
```

---

## 📄 API Documentation

The **Postman Collection** for testing API requests is available in the repository.

🔹 Auto Import Token After Login

To automatically store and use the authentication token in Postman,
use the following script in the Tests or in the post-response Scripts(Windows App) tab of the login request:

```javascript

try {
    let json = pm.response.json();
    if (json.access_token) {
        pm.environment.set("TOKEN", json.access_token);
        console.log("Token saved successfully:", json.access_token);
    } else {
        console.log("Token not found in response:", json);
    }
} catch (error) {
    console.log("Error parsing JSON response:", error);
}
```

Go to environment variables and create a TOKEN Variable.

This script saves the access_token in the Videogames Environment as TOKEN. In every request that requires
authentication, use the following format for the Bearer Token:

```
Authorization: Bearer your_token_here
```

---

## 🤝 Contributing

1. **Fork the repository**
2. **Create a feature branch**: `git checkout -b feature-name`
3. **Commit changes**: `git commit -m 'Add new feature'`
4. **Push branch**: `git push origin feature-name`
5. **Open a Pull Request**

---

## 📧 Contact

For any issues, please **open a GitHub issue** or contact me at `kyriakospanaretoss@gmail.com`.

---

Happy coding! 🚀
