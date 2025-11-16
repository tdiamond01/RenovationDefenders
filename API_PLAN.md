# Renovation Defenders API Plan

## Overview
RESTful API for Flutter mobile app using Laravel Sanctum for token-based authentication.

## Authentication Strategy
- **Laravel Sanctum** for API token authentication
- Tokens issued on login, stored securely in Flutter app
- Token sent in `Authorization: Bearer {token}` header

---

## API Endpoints

### 1. Authentication Endpoints

#### POST `/api/register`
Register a new user account.

**Request Body:**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Response (201):**
```json
{
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "is_admin": false
  },
  "token": "1|aBcDeFgHiJkLmNoPqRsTuVwXyZ"
}
```

---

#### POST `/api/login`
Authenticate user and get access token.

**Request Body:**
```json
{
  "email": "john@example.com",
  "password": "password123"
}
```

**Response (200):**
```json
{
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "is_admin": false
  },
  "token": "1|aBcDeFgHiJkLmNoPqRsTuVwXyZ"
}
```

**Error Response (401):**
```json
{
  "message": "Invalid credentials"
}
```

---

#### POST `/api/logout`
Revoke current access token.

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
  "message": "Logged out successfully"
}
```

---

#### GET `/api/user`
Get authenticated user's profile.

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
  "id": 1,
  "name": "John Doe",
  "email": "john@example.com",
  "is_admin": false,
  "created_at": "2025-11-12T10:30:00.000000Z"
}
```

---

### 2. Course Endpoints

#### GET `/api/courses`
Get all courses assigned to the authenticated user.

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
  "data": [
    {
      "id": 1,
      "title": "Renovation Safety Basics",
      "description": "Learn the fundamentals of renovation safety",
      "is_active": true,
      "assignment": {
        "assigned_at": "2025-11-12T10:30:00.000000Z",
        "progress_percentage": 45,
        "completed_at": null
      },
      "videos_count": 10,
      "completed_videos_count": 4
    }
  ]
}
```

---

#### GET `/api/courses/{id}`
Get detailed information about a specific course.

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
  "id": 1,
  "title": "Renovation Safety Basics",
  "description": "Learn the fundamentals of renovation safety",
  "is_active": true,
  "assignment": {
    "assigned_at": "2025-11-12T10:30:00.000000Z",
    "progress_percentage": 45,
    "completed_at": null
  },
  "videos": [
    {
      "id": 1,
      "title": "Introduction to Safety",
      "description": "Overview of safety practices",
      "video_url": "https://example.com/videos/intro.mp4",
      "thumbnail_url": "https://example.com/thumbnails/intro.jpg",
      "duration": 600,
      "order": 1,
      "is_required": true,
      "is_active": true,
      "progress": {
        "completed": false,
        "watch_time": 120,
        "completed_at": null
      }
    }
  ]
}
```

**Error Response (403):**
```json
{
  "message": "You are not assigned to this course"
}
```

---

### 3. Video Endpoints

#### GET `/api/videos/{id}`
Get detailed information about a specific video.

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
  "id": 1,
  "title": "Introduction to Safety",
  "description": "Overview of safety practices",
  "video_url": "https://example.com/videos/intro.mp4",
  "thumbnail_url": "https://example.com/thumbnails/intro.jpg",
  "duration": 600,
  "is_required": true,
  "is_active": true,
  "course": {
    "id": 1,
    "title": "Renovation Safety Basics"
  },
  "progress": {
    "completed": false,
    "watch_time": 120,
    "completed_at": null
  }
}
```

---

#### POST `/api/videos/{id}/progress`
Update video watch progress.

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
  "watch_time": 300,
  "completed": false
}
```

**Response (200):**
```json
{
  "message": "Progress updated successfully",
  "progress": {
    "video_id": 1,
    "watch_time": 300,
    "completed": false,
    "completed_at": null
  },
  "course_progress": {
    "progress_percentage": 50,
    "completed_videos": 5,
    "total_videos": 10
  }
}
```

---

#### POST `/api/videos/{id}/complete`
Mark a video as completed.

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
  "message": "Video marked as completed",
  "progress": {
    "video_id": 1,
    "completed": true,
    "completed_at": "2025-11-16T14:30:00.000000Z"
  },
  "course_progress": {
    "progress_percentage": 60,
    "completed_videos": 6,
    "total_videos": 10
  }
}
```

---

### 4. Admin Endpoints (Optional)

#### GET `/api/admin/users`
Get all users (admin only).

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
  "data": [
    {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "is_admin": false,
      "created_at": "2025-11-12T10:30:00.000000Z",
      "courses_assigned": 3,
      "total_progress": 45
    }
  ],
  "meta": {
    "current_page": 1,
    "total": 50,
    "per_page": 15
  }
}
```

---

#### POST `/api/admin/users/{id}/courses`
Assign a course to a user (admin only).

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
  "course_id": 1
}
```

**Response (201):**
```json
{
  "message": "Course assigned successfully",
  "assignment": {
    "user_id": 1,
    "course_id": 1,
    "assigned_at": "2025-11-16T14:30:00.000000Z"
  }
}
```

---

#### GET `/api/admin/courses`
Get all courses (admin only).

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
  "data": [
    {
      "id": 1,
      "title": "Renovation Safety Basics",
      "description": "Learn the fundamentals",
      "is_active": true,
      "videos_count": 10,
      "users_assigned": 25,
      "average_progress": 62
    }
  ]
}
```

---

## Implementation Checklist

### Phase 1: Setup & Authentication
- [ ] Install Laravel Sanctum
- [ ] Configure Sanctum middleware
- [ ] Create API authentication controllers
- [ ] Create API routes file (`routes/api.php`)
- [ ] Implement register endpoint
- [ ] Implement login endpoint
- [ ] Implement logout endpoint
- [ ] Implement user profile endpoint
- [ ] Test authentication flow with Postman/Insomnia

### Phase 2: Course & Video APIs
- [ ] Create API Resource classes for formatting JSON responses
  - [ ] UserResource
  - [ ] CourseResource
  - [ ] VideoResource
  - [ ] VideoProgressResource
- [ ] Create API Controllers
  - [ ] CourseApiController
  - [ ] VideoApiController
  - [ ] ProgressApiController
- [ ] Implement course listing endpoint
- [ ] Implement course detail endpoint
- [ ] Implement video detail endpoint
- [ ] Implement progress update endpoint
- [ ] Implement video completion endpoint
- [ ] Add authorization checks (users can only access their assigned courses)
- [ ] Test all endpoints

### Phase 3: Admin APIs (Optional)
- [ ] Create admin middleware for API
- [ ] Implement admin user listing
- [ ] Implement admin course assignment
- [ ] Implement admin course listing
- [ ] Test admin endpoints

### Phase 4: Testing & Documentation
- [ ] Write API tests
- [ ] Create Postman collection
- [ ] Document all endpoints
- [ ] Set up API versioning (`/api/v1/...`)
- [ ] Add rate limiting
- [ ] Add proper error handling

---

## Security Considerations

1. **Rate Limiting**: Limit API requests to prevent abuse
2. **Input Validation**: Validate all input data
3. **Authorization**: Ensure users can only access their own data
4. **HTTPS Only**: Enforce HTTPS in production
5. **Token Expiration**: Consider implementing token expiration
6. **CORS Configuration**: Configure CORS for Flutter app

---

## Response Format Standards

### Success Response
```json
{
  "data": { ... },
  "message": "Optional success message"
}
```

### Error Response
```json
{
  "message": "Error message",
  "errors": {
    "field_name": ["Validation error message"]
  }
}
```

### Pagination
```json
{
  "data": [ ... ],
  "meta": {
    "current_page": 1,
    "total": 100,
    "per_page": 15,
    "last_page": 7
  },
  "links": {
    "first": "...",
    "last": "...",
    "prev": null,
    "next": "..."
  }
}
```

---

## Next Steps

1. Review this plan and confirm the endpoints meet your requirements
2. Create a new branch for API development
3. Start with Phase 1 (Setup & Authentication)
4. Test each phase before moving to the next
5. Once API is complete, begin Flutter app development

