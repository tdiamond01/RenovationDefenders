# API Testing Guide

This document provides examples for testing all API endpoints.

## Base URL

**Local Development:**
```
http://localhost:8000/api
```

**Production:**
```
https://beta.renovationdefenders.com/api
```

---

## Authentication Endpoints

### 1. Register

**Endpoint:** `POST /api/register`

**Request:**
```bash
curl -X POST https://beta.renovationdefenders.com/api/register \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'
```

**Response:**
```json
{
  "message": "Registration successful",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "role": "user"
  },
  "token": "1|abc123..."
}
```

### 2. Login

**Endpoint:** `POST /api/login`

**Request:**
```bash
curl -X POST https://beta.renovationdefenders.com/api/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "email": "john@example.com",
    "password": "password123"
  }'
```

**Response:**
```json
{
  "message": "Login successful",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "role": "user"
  },
  "token": "2|def456..."
}
```

### 3. Get Current User

**Endpoint:** `GET /api/user`

**Request:**
```bash
curl -X GET https://beta.renovationdefenders.com/api/user \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

**Response:**
```json
{
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "role": "user",
    "email_verified_at": "2025-11-17T00:00:00.000000Z"
  }
}
```

### 4. Logout

**Endpoint:** `POST /api/logout`

**Request:**
```bash
curl -X POST https://beta.renovationdefenders.com/api/logout \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

**Response:**
```json
{
  "message": "Logout successful"
}
```

---

## Course Endpoints

### 5. Get All Assigned Courses

**Endpoint:** `GET /api/courses`

**Request:**
```bash
curl -X GET https://beta.renovationdefenders.com/api/courses \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

**Response:**
```json
{
  "courses": [
    {
      "id": 1,
      "title": "Introduction to Renovation",
      "description": "Learn the basics...",
      "order": 1,
      "is_active": true,
      "assigned_at": "2025-11-17T00:00:00.000000Z",
      "completed_at": null,
      "progress_percentage": 45.5
    }
  ]
}
```

### 6. Get Specific Course with Videos

**Endpoint:** `GET /api/courses/{id}`

**Request:**
```bash
curl -X GET https://beta.renovationdefenders.com/api/courses/1 \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

**Response:**
```json
{
  "course": {
    "id": 1,
    "title": "Introduction to Renovation",
    "description": "Learn the basics...",
    "order": 1,
    "is_active": true,
    "assigned_at": "2025-11-17T00:00:00.000000Z",
    "completed_at": null,
    "progress_percentage": 45.5
  },
  "videos": [
    {
      "id": 1,
      "title": "Welcome Video",
      "description": "Introduction to the course",
      "duration": 300,
      "module": "Module 1",
      "order": 1,
      "required": true,
      "video_url": "https://renovation-defenders-videos.s3.us-west-2.amazonaws.com/videos/...",
      "thumbnail_url": null,
      "progress": {
        "watched_duration": 150,
        "total_duration": 300,
        "completed": false,
        "last_watched_at": "2025-11-17T00:00:00.000000Z"
      }
    }
  ]
}
```

---

## Video Endpoints

### 7. Get Videos for a Course

**Endpoint:** `GET /api/courses/{courseId}/videos`

**Request:**
```bash
curl -X GET https://beta.renovationdefenders.com/api/courses/1/videos \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

**Response:**
```json
{
  "videos": [
    {
      "id": 1,
      "title": "Welcome Video",
      "description": "Introduction to the course",
      "duration": 300,
      "module": "Module 1",
      "order": 1,
      "required": true,
      "video_url": "https://renovation-defenders-videos.s3.us-west-2.amazonaws.com/videos/...",
      "thumbnail_url": null,
      "progress": null
    }
  ]
}
```

### 8. Get Specific Video

**Endpoint:** `GET /api/videos/{id}`

**Request:**
```bash
curl -X GET https://beta.renovationdefenders.com/api/videos/1 \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

**Response:**
```json
{
  "video": {
    "id": 1,
    "course_id": 1,
    "title": "Welcome Video",
    "description": "Introduction to the course",
    "duration": 300,
    "module": "Module 1",
    "order": 1,
    "required": true,
    "video_url": "https://renovation-defenders-videos.s3.us-west-2.amazonaws.com/videos/...",
    "thumbnail_url": null,
    "progress": null
  }
}
```

---

## Progress Endpoints

### 9. Update Video Progress

**Endpoint:** `POST /api/videos/{id}/progress`

**Request:**
```bash
curl -X POST https://beta.renovationdefenders.com/api/videos/1/progress \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "watched_duration": 150,
    "total_duration": 300,
    "completed": false
  }'
```

**Response:**
```json
{
  "message": "Progress updated successfully",
  "progress": {
    "watched_duration": 150,
    "total_duration": 300,
    "completed": false,
    "last_watched_at": "2025-11-17T00:00:00.000000Z"
  }
}
```

### 10. Get All Progress

**Endpoint:** `GET /api/progress`

**Request:**
```bash
curl -X GET https://beta.renovationdefenders.com/api/progress \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

**Response:**
```json
{
  "progress": [
    {
      "video_id": 1,
      "video_title": "Welcome Video",
      "course_id": 1,
      "watched_duration": 150,
      "total_duration": 300,
      "completed": false,
      "last_watched_at": "2025-11-17T00:00:00.000000Z"
    }
  ]
}
```

### 11. Get Course Progress

**Endpoint:** `GET /api/courses/{id}/progress`

**Request:**
```bash
curl -X GET https://beta.renovationdefenders.com/api/courses/1/progress \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

**Response:**
```json
{
  "course_id": 1,
  "progress_percentage": 45.5,
  "completed_at": null,
  "videos": [
    {
      "video_id": 1,
      "video_title": "Welcome Video",
      "module": "Module 1",
      "order": 1,
      "watched_duration": 150,
      "total_duration": 300,
      "completed": false,
      "last_watched_at": "2025-11-17T00:00:00.000000Z"
    }
  ]
}
```

---

## Testing with Postman

1. Create a new Postman Collection called "Renovation Defenders API"
2. Add the base URL as an environment variable
3. Create a variable called `token` to store the authentication token
4. After logging in, save the token to the `token` variable
5. Use `{{token}}` in the Authorization header for protected routes

**Authorization Header:**
```
Authorization: Bearer {{token}}
```

---

## Testing Checklist

- [ ] Register a new user
- [ ] Login with registered user
- [ ] Get current user info
- [ ] Get assigned courses (empty initially)
- [ ] Have admin assign a course via web interface
- [ ] Get assigned courses (should show assigned course)
- [ ] Get specific course with videos
- [ ] Get videos for a course
- [ ] Get specific video details
- [ ] Update video progress
- [ ] Mark video as completed
- [ ] Get all progress
- [ ] Get course progress
- [ ] Verify course progress percentage updates
- [ ] Logout
- [ ] Verify token is invalid after logout

---

## Error Responses

### 401 Unauthorized
```json
{
  "message": "Unauthenticated."
}
```

### 403 Forbidden
```json
{
  "message": "You do not have access to this video"
}
```

### 404 Not Found
```json
{
  "message": "Course not found or not assigned to you"
}
```

### 422 Validation Error
```json
{
  "message": "The email has already been taken.",
  "errors": {
    "email": [
      "The email has already been taken."
    ]
  }
}
```
