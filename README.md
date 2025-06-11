# WroomWroomMe

A web application for managing car shows, built with Vue 3 (frontend) and Laravel (backend). The platform allows users to register, log in, and manage car show events, with roles for regular users and organizers.

---

## Technologies Used

- **Frontend:** Vue 3, TypeScript, Vite, Vue Router, Vue Toastification
- **Backend:** Laravel (PHP), Laravel Sanctum (for API authentication)
- **Database:** MySQL or SQLite (configurable via Laravel)
- **API:** RESTful endpoints

---

## Main Features

- User registration and authentication (with roles: user, organizer)
- Organizer registration requires organization name
- Login/logout functionality
- Car show CRUD (Create, Read, Update, Delete) for organizers/admins
- Responsive and modern UI

---

## API Overview

### Registration

- **POST** `/api/register`
  - **Body:**  
    ```
    {
      "name": "John Doe",
      "email": "john@example.com",
      "password": "password123",
      "password_confirmation": "password123",
      "role": "user" | "organizer",
      "organization": "Org Name" // required if role is organizer
    }
    ```
  - **Response:**  
    - `201 Created` on success
    - Validation errors with details on failure

### Login

- **POST** `/api/login`
  - **Body:**  
    ```
    {
      "email": "john@example.com",
      "password": "password123"
    }
    ```
  - **Response:**  
    - `200 OK` with user info and token
    - `401 Unauthorized` on failure

### Car Shows

- **GET** `/api/car-shows` — List all car shows
- **POST** `/api/car-shows` — Create new car show (organizer/admin)
- **PUT** `/api/car-shows/{id}` — Update car show (organizer/admin)
- **DELETE** `/api/car-shows/{id}` — Delete car show (organizer/admin)

---

## Test Cases

| #  | Test Description                                      | Input                                                                                                   | Expected Output                                    | Notes                                  |
|----|-------------------------------------------------------|--------------------------------------------------------------------------------------------------------|----------------------------------------------------|----------------------------------------|
| 1  | Register as regular user                              | Valid name, email, password, role: user                                                                | 201 Created, user info, token                      |                                        |
| 2  | Register as organizer                                 | Valid name, email, password, role: organizer, organization                                             | 201 Created, user info, token                      | Organization required                  |
| 3  | Register with missing fields                          | Missing email or password                                                                              | 422 Unprocessable Entity, validation errors         |                                        |
| 4  | Register with mismatched passwords                    | Password and password_confirmation do not match                                                         | 422 Unprocessable Entity, validation errors         |                                        |
| 5  | Register with duplicate email                         | Email already exists                                                                                   | 422 Unprocessable Entity, email must be unique      |                                        |
| 6  | Login with correct credentials                        | Valid email and password                                                                               | 200 OK, user info, token                           |                                        |
| 7  | Login with incorrect credentials                      | Invalid email or password                                                                              | 401 Unauthorized                                   |                                        |
| 8  | Organizer creates a car show                          | Authenticated as organizer, valid car show data                                                        | 201 Created, car show info                         |                                        |
| 9  | Organizer edits/deletes their car show                | Authenticated as organizer, valid update/delete request                                                | 200 OK (update), 204 No Content (delete)            |                                        |
| 10 | Organizer tries to create car show without auth token | No or invalid authentication token                                                                     | 401 Unauthorized                                   |                                        |

---

## Future Updates

- User profile management
- Password reset functionality
- Search and filter car shows
- Event registration and ticketing
- Image uploads for car shows
- Public event calendar
- Improved test coverage (unit and integration tests)
- Internationalization (i18n) support

---

## Getting Started

1. **Backend**
   - Install dependencies: `composer install`
   - Configure `.env` and database
   - Run migrations: `php artisan migrate`
   - Start server: 
   - Windows: cd `...\backend_folder ` && `php artisan serve`
   - macOS/Linux: cd `...\backend_folder` && `php artisan serve`

2. **Frontend**
   - Install dependencies: `npm install`
   - Start dev server: 
   - Windows: cd `...\frontend` && `npm run dev`
   - macOS/Linux: cd `...\frontend` && `npm run dev`

---