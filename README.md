# Internship API

 API for tracking groups, mentors and interns

---

## Table of Contents
* [Project setup](#project setup)
* [Instructions](#instructions)
* [Routes](#routes)
   * [Mentor](#mentor)

---

## Project setup

1. Clone repository locally

        `git clone https://github.com/Vlahy/internship_final.git`

2. Install dependencies via composer

        composer install
        or
        composer update
        
3. Change .env.example name to .env

        cd internship_final
        mv .env.example .env

4. Change database credentials in .env file to your database credentials


5. Create database schema (internship_final)

        mysql
        CREATE SCHEMA internship_final;

6. Run migrations and seeders

        php artisan migrate --seed

7. Run artisan serve to start development server

        php artisan serve

8. You can use Postman to test API routes and endpoints

---

## Instructions

Seeder will create two default users (admin and recruiter) with multiple mentors.

You need to log in if You want to use API.
```
(POST method): http://localhost:8000/api/auth/login
```
Parameters for login are sent in JSON format:
```
{
   "email": "admin@admin.com",
   "password": "12345678"
}
```
or
```
{
    "email": "recruiter@recruiter.com",
    "password": "12345678"
}
```

When You log in, Postman will return data with Bearer token, which You need to access routes.

Insert token in Authorization tab of Postman. For type select Bearer, and in token section insert given token.

If You want to log in as different user, first You need to log out, and then log in with different credentials. After logging out, token is destroyed, but on log in You get new one.

```
(POST METHOD): http://localhost:8000/api/auth/logout
```

Admin can change roles to other users.

Available roles are: admin, recruiter, mentor.
```
(POST method): http://localhost:8000/api/auth/changeRole/{id}
```

---

## Routes

### Mentor

#### Get
```
Show all mentors (GET method):  http://localhost:8000/api/mentors
Show single mentor (GET method): http://localhost:8000/api/mentors/{id}
```

#### Post/update

Parameters for creating or updating mentors are sent in JSON format:

Only logged-in user or admin can update their information.

```
{
   "name": "John Doe",
   "email": "john@doe.com",
   "password": "12345678",
   "password_confirmation": "12345678",
   "city": "Belgrade",
   "skype": "skype",
   "group_id": "1"
}
```

```
Create mentor (POST method): http://localhost:8000/api/mentors
Update mentor (PUT method): http://localhost:8000/api/mentors/{id}
```

#### Delete

```
Delete mentor (DELETE method): http://localhost:8000/api/mentors/{id}
```

---

### Review

#### Get
```
Show all intern reviews (GET method):  http://localhost:8000/api/interns/{internId}/assignments
Show single intern review (GET method): http://localhost:8000/api/interns/{internId}/assignments/{assignmentId}
```

#### Post/update

Parameters for creating or updating reviews are sent in JSON format:

Only logged in mentor can create review for interns in the same group.

Mark column can accept: bad, good, excellent
```
{
   "pros": "pros",
   "cons": "cons",
   "mark": "good",
   "assignment_id": "2",
   "intern_id": "1",
}
```

```
Create review (POST method): http://localhost:8000/api/reviews
Update review (PUT method): http://localhost:8000/api/reviews/{id}
```

#### Delete

```
Delete review (DELETE method): http://localhost:8000/api/review/{id}
```


---
### Intern

#### Get
```
Show all interns (GET method):  http://localhost:8000/api/interns
Show single intern (GET method): http://localhost:8000/api/interns/{id}
```

#### Post/update

Parameters for creating or updating interns are sent in JSON format:


```
{
   "name": "John Doe",
   "city": "Belgrade",
   "address": "Some address",
   "email": "john@doe.com",
   "phone": "phone",
   "phone": "+123 456 789 0",
   "cv": "cv",
   "github": "github",
   "group_id": "1"
}
```

```
Create intern (POST method): http://localhost:8000/api/interns
Update intern (PUT method): http://localhost:8000/api/interns/{id}
```

#### Delete

```
Delete intern (DELETE method): http://localhost:8000/api/interns/{id}
```

---

### Group

#### Get
```
Show all groups (GET method):  http://localhost:8000/api/groups
Show single group (GET method): http://localhost:8000/api/groups/{id}
```

#### Post/update

Parameters for creating or updating groups are sent in JSON format:


```
{
   "name": "FE Group 1",
}
```

```
Create group (POST method): http://localhost:8000/api/groups
Update group (PUT method): http://localhost:8000/api/groups/{id}
```

#### Delete

```
Delete group (DELETE method): http://localhost:8000/api/groups/{id}
```

---

### Assignments

#### Get
```
Show all assignments (GET method):  http://localhost:8000/api/assignments
Show single assignment (GET method): http://localhost:8000/api/assignments/{id}
```

#### Post/update

Parameters for creating or updating assignments are sent in JSON format:


```
{
   "name": "Assignment 1",
   "description": "Do this..."
}
```

```
Create assignment (POST method): http://localhost:8000/api/assignments
Update assignment (PUT method): http://localhost:8000/api/assignments/{id}
```

#### Delete

```
Delete assignment (DELETE method): http://localhost:8000/api/assignments/{id}
```

#### Add assignment to group

```
(POST method): http://localhost:8000/api/groups/{groupId}/assignments/{assignmentId}/add
```

#### Activate assignment

To activate You need to send start date and end date in JSON format

```
{
   "start_date": "yy-mm-dd",
   "end_date": "yy-mm-dd"
}
```
```
(PUT method): http://localhost:8000/api/groups/{groupId}/assignments/{assignmentId}/activate
```

#### Deactivate assignment

```
(PUT method): http://localhost:8000/api/groups/{groupId}/assignments/{assignmentId}/deactivate
```
