# Authentication API Documentation

## Overview

This document describes the authentication endpoints available in the Retail Sales Management API.

## Endpoints

### 1. Register User

**POST** `/api/auth/register`

Register a new user account.

**Request Body:**

```json
{
    "email": "user@example.com",
    "password": "password123",
    "confirmPassword": "password123",
    "role": "ROLE_USER"
}
```

**Response:**

```json
{
    "id": "d36f7f32-9f20-7e7a-9014-5b79e2bc5671",
    "email": "user@example.com",
    "roles": ["ROLE_USER"]
}
```

### 2. Login

**POST** `/api/auth/login`

Authenticate user and receive JWT token.

**Request Body:**

```json
{
    "email": "user@example.com",
    "password": "password123"
}
```

**Response:**

```json
{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...",
    "user": {
        "id": "d36f7f32-9f20-7e7a-9014-5b79e2bc5671",
        "email": "user@example.com",
        "roles": ["ROLE_USER"]
    }
}
```

### 3. Get Current User

**GET** `/api/auth/me`

Get information about the currently authenticated user.

**Headers:**

```
Authorization: Bearer <jwt_token>
```

**Response:**

```json
{
    "user": {
        "id": "d36f7f32-9f20-7e7a-9014-5b79e2bc5671",
        "email": "user@example.com",
        "roles": ["ROLE_USER"]
    }
}
```

### 4. Refresh Token

**POST** `/api/auth/refresh`

Refresh the current JWT token.

**Request Body:**

```json
{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9..."
}
```

**Response:**

```json
{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...",
    "user": {
        "id": "d36f7f32-9f20-7e7a-9014-5b79e2bc5671",
        "email": "user@example.com",
        "roles": ["ROLE_USER"]
    }
}
```

### 5. Logout

**POST** `/api/auth/logout`

Logout user (client-side token removal).

**Request Body:**

```json
{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9..."
}
```

**Response:**

```json
{
    "message": "Successfully logged out",
    "success": true
}
```

## Usage Examples

### Using cURL

#### Register a new user:

```bash
curl -X POST "http://localhost:8000/api/auth/register" \
     -H "Content-Type: application/json" \
     -d '{
         "email": "user@example.com",
         "password": "password123",
         "confirmPassword": "password123",
         "role": "ROLE_USER"
     }'
```

#### Login:

```bash
curl -X POST "http://localhost:8000/api/auth/login" \
     -H "Content-Type: application/json" \
     -d '{
         "email": "user@example.com",
         "password": "password123"
     }'
```

#### Get current user info:

```bash
curl -X GET "http://localhost:8000/api/auth/me" \
     -H "Authorization: Bearer <your_jwt_token>"
```

### Using JavaScript/Fetch

#### Login example:

```javascript
const loginData = {
    email: "user@example.com",
    password: "password123",
};

fetch("/api/auth/login", {
    method: "POST",
    headers: {
        "Content-Type": "application/json",
    },
    body: JSON.stringify(loginData),
})
    .then((response) => response.json())
    .then((data) => {
        // Store the token
        localStorage.setItem("jwt_token", data.token);
        console.log("Login successful:", data);
    })
    .catch((error) => {
        console.error("Login failed:", error);
    });
```

#### Making authenticated requests:

```javascript
const token = localStorage.getItem("jwt_token");

fetch("/api/auth/me", {
    method: "GET",
    headers: {
        Authorization: `Bearer ${token}`,
        "Content-Type": "application/json",
    },
})
    .then((response) => response.json())
    .then((data) => {
        console.log("Current user:", data);
    })
    .catch((error) => {
        console.error("Request failed:", error);
    });
```

## Error Handling

### Common Error Responses

#### 400 Bad Request

```json
{
    "type": "https://tools.ietf.org/html/rfc2616#section-10",
    "title": "An error occurred",
    "detail": "Passwords do not match"
}
```

#### 401 Unauthorized

```json
{
    "type": "https://tools.ietf.org/html/rfc2616#section-10",
    "title": "An error occurred",
    "detail": "Invalid credentials"
}
```

#### 422 Unprocessable Entity

```json
{
    "type": "https://tools.ietf.org/html/rfc2616#section-10",
    "title": "An error occurred",
    "detail": "User with this email already exists"
}
```

## Security Notes

1. **JWT Tokens**: Tokens are stateless and should be stored securely on the client side.
2. **Password Requirements**: Passwords must be at least 6 characters long.
3. **Email Validation**: Email addresses are validated for proper format.
4. **Role Assignment**: Users can be assigned either `ROLE_USER` or `ROLE_ADMIN`.
5. **Token Expiration**: JWT tokens have an expiration time set in the configuration.

## Configuration

The JWT authentication is configured using the LexikJWTAuthenticationBundle. Key configuration files:

-   `config/packages/lexik_jwt_authentication.yaml` - JWT bundle configuration
-   `config/packages/security.yaml` - Security configuration
-   `config/jwt/` - JWT key files (private and public keys)

Make sure to generate the JWT keys using:

```bash
php bin/console lexik:jwt:generate-keypair
```
