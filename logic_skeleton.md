# Logic Skeleton: Laravel Application Core Business Logic

## 1. CONTROLLER ANALYSIS

### **AdminCourseController**
- **Methods & Purpose:**
  - `index`: List all courses. Main Operation: `list all courses`. Input: none. Models: `Course`. DB: `paginate`. Output: View.
  - `create`: Show course creation form. Output: View.
  - `store`: Create a new course. Main Operation: `create course`. Input: title, slug, description, teacher_id, status, price, level. Models: `Course`. DB: `insert`. Output: Redirect to index.
  - `edit`: Show course edit form. Output: View.
  - `enrollStudents`: Bulk enroll students into a course. Main Operation: `enroll students`. Input: array of student IDs. Models: `Enrollment`. DB: `firstOrCreate` (prevents duplicates). Output: Redirect back.
  - `update`: Update an existing course. Main Operation: `update course`. Input: course data. Models: `Course`. DB: `update`. Output: Redirect.
  - `destroy`: Delete a course. Main Operation: `delete course`. Input: course id. Models: `Course`. DB: `delete`. Output: Redirect.

### **AdminDashboardController**
- **Methods & Purpose:**
  - `index`: Show admin dashboard statistics. Main Operation: `view dashboard stats`. Input: none. Models: `User`, `Course`, `Lesson`, `Enrollment`. DB: `count`, `latest`, `limit`. Output: View.

### **AdminEnrollmentController**
- **Methods & Purpose:**
  - `index`: List all enrollments. Main Operation: `list enrollments`.
  - `destroy`: Remove a student's enrollment. Main Operation: `remove enrollment`. Input: enrollment id. Models: `Enrollment`. DB: `delete`. Output: Redirect.

### **AdminLessonController**
- **Methods & Purpose:**
  - `index`: List all lessons. Main Operation: `list lessons`.
  - `create`: Show lesson creation form. Output: View.
  - `store`: Create a new lesson. Main Operation: `create lesson`. Input: title, slug, course_id, video_url, content, duration, order, is_free. Models: `Lesson`. DB: `insert`. Output: Redirect.
  - `edit`: Show lesson edit form. Output: View.
  - `update`: Update an existing lesson. Main Operation: `update lesson`. Input: lesson data. Models: `Lesson`. DB: `update`. Output: Redirect.
  - `destroy`: Delete a lesson. Main Operation: `delete lesson`. Input: lesson id. Models: `Lesson`. DB: `delete`. Output: Redirect.

### **AdminReportController**
- **Methods & Purpose:**
  - `index`: View system reports. Main Operation: `generate report`. Input: None. Models: `User`, `Course`, `Enrollment`. DB: Counts and ordering by enrollments_count. Output: View.

### **AdminUserController**
- **Methods & Purpose:**
  - `index`, `create`, `edit`: Standard view delivery.
  - `store`: Create a new user (admin, teacher, student). Main Operation: `create user`. Models: `User`. DB: `insert`. Business Rule: Role validation. Output: Redirect.
  - `update`: Update user details. Main Operation: `update user`. DB: `update`. Output: Redirect.
  - `destroy`: Delete a user. Main Operation: `delete user`. DB: `delete`. Business Rule: Admin cannot delete themselves. Output: Redirect.

### **CourseController**
- **Methods & Purpose:**
  - `index`: List user's courses or all published courses. Main Operation: `list available courses`. Rule: Teachers only see their own published courses; others see all published courses.
  - `show`: View course details. Main Operation: `view course details`. Rule: Teachers restricted to viewing their own courses; Checks if the logged-in user is enrolled.
  - `store`, `update`, `destroy`: Handle standard course CRUD (mostly duplicate of teacher/admin logic depending on route usage).

### **EnrollmentController**
- **Methods & Purpose:**
  - `create`: Show enrollment page. Output: View.
  - `enroll`: Enroll a student into a course. Main Operation: `enroll student`. Input: course_id, user_id (target student). Models: `Enrollment`, `User`, `Course`. DB: `create`. Business Rules: Students cannot enroll themselves directly; Teachers can only enroll students in their own courses; Prevents duplicate enrollments. Output: Redirect back.

### **HomeController**
- **Methods & Purpose:**
  - `index`: Show landing page. Main Operation: `view home page`. Models: `Course`. DB: `take(6)` latest published courses. Output: View.

### **LessonController**
- **Methods & Purpose:**
  - `show`: View lesson content. Main Operation: `view lesson content`. Input: course slug, lesson slug. Models: `Lesson`, `Course`, `LessonProgress`, `Enrollment`. DB: `exists()`, `first()`. Business Rules: If user is student, they must be enrolled in the course to view the lesson.
  - `complete`: Toggle/mark lesson as complete. Main Operation: `mark lesson complete`. Input: lesson id, course id. Models: `LessonProgress`. DB: `updateOrCreate`. Rule: Set `completed_at` to now(). Output: Redirect back.

### **ProfileController**
- **Methods & Purpose:**
  - `edit`, `update`, `destroy`: Manage user profile and account deletion. Main Operations: `update profile`, `delete account`. Models: User. DB: save, delete. Output: Redirect.

### **StudentDashboardController**
- **Methods & Purpose:**
  - `index`: View student dashboard. Main Operation: `view student enrollments`. Input: none. Models: `User`, `Enrollment`, `Course`, `Lesson`. DB: Eager load course and lessons for user's enrollments. Output: View.

### **TeacherCourseController**
- **Methods & Purpose:**
  - `index`: List teacher's courses. Main Operation: `list teacher courses`. Models: `Course`. Rule: Filters by `Auth::id()`.
  - `store`, `update`, `destroy`: Manage teacher's courses. Rules: Always sets `teacher_id` to `Auth::id()`. Cannot edit/delete courses not owned by the teacher.
  - `enrollStudents`: Bulk student enrollment, restricted to course ownership.

### **TeacherDashboardController**
- **Methods & Purpose:**
  - `index`: Dashboard for teacher. Main Operation: `view teacher dashboard`. Models: `Course`. DB: Counts student enrollments.

### **AuthenticatedSessionController** (Auth)
- **Methods & Purpose:**
  - `store`: Log in user. Main Operation: `login user`. Input: credentials. Models: Auth facade. Rule: Redirects to `/admin/dashboard`, `/teacher/dashboard`, or `/dashboard` based on role.
  - `destroy`: Log out user. Main Operation: `logout user`.

### **RegisteredUserController** (Auth)
- **Methods & Purpose:**
  - `store`: Register a new user. Main Operation: `register user`. Input: name, email, password. Models: `User`. DB: `create`. Output: Redirect to dashboard.


## 2. MODEL ANALYSIS

### **Course**
- **Purpose**: Represents a course in the LMS.
- **Table**: `courses` (implied by convention). Uses SoftDeletes.
- **Fillable**: `title`, `slug`, `description`, `thumbnail`, `teacher_id`, `price`, `level`, `status`.
- **Relationships**:
  - `teacher()`: `belongsTo(User::class, 'teacher_id')`
  - `lessons()`: `hasMany(Lesson::class)->orderBy('order')`
  - `students()`: `belongsToMany(User::class, 'enrollments')`
  - `enrollments()`: `hasMany(Enrollment::class)`
- **Reusable Logic/Business Rules**:
  - `progressForUser($userId)`: Reusable logic calculating course completion percentage. Finds total lessons, and completed lessons for a specific user to calculate: `round((completedLessons / totalLessons) * 100)`.
  - Implicit URL routing via `getRouteKeyName()` returning returning `slug`.

### **Enrollment**
- **Purpose**: Tracks user enrollment in courses.
- **Table**: `enrollments`.
- **Fillable**: `user_id`, `course_id`, `status`.
- **Relationships**:
  - `user()`: `belongsTo(User::class)`
  - `course()`: `belongsTo(Course::class)`

### **Lesson**
- **Purpose**: Represents a specific lesson module within a course.
- **Table**: `lessons`.
- **Fillable**: `course_id`, `title`, `slug`, `content`, `video_url`, `duration`, `position`, `order`, `is_free`.
- **Relationships**:
  - `course()`: `belongsTo(Course::class)`
  - `progress()`: `hasMany(LessonProgress::class)`
- **Reusable Logic/Business Rules**:
  - Routing via `getRouteKeyName()` returning `slug`.

### **LessonProgress**
- **Purpose**: Tracks the completion state of lessons by users.
- **Table**: `lesson_progress`.
- **Fillable**: `user_id`, `lesson_id`, `completed`, `completed_at`.
- **Relationships**:
  - `user()`: `belongsTo(User::class)`
  - `lesson()`: `belongsTo(Lesson::class)`

### **User**
- **Purpose**: The main authentication and authorization boundary (Admin, Teacher, Student).
- **Table**: `users`. Uses SoftDeletes.
- **Fillable**: `name`, `email`, `password`, `role`.
- **Relationships**:
  - `courses()`: `hasMany(Course::class, 'teacher_id')` (For teachers).
  - `enrollments()`: `hasMany(Enrollment::class)`
  - `enrolledCourses()`: `belongsToMany(Course::class, 'enrollments')`
  - `lessonProgress()`: `hasMany(LessonProgress::class)`


## 3. CORE BUSINESS OPERATIONS

Based on the controller logic, the unified core operations are:

**Authentication & User Management**
- `registerUser`
- `loginUser`
- `logoutUser`
- `updateProfile`
- `deleteAccount`
- `createUser` (Admin level)
- `updateRole/Permissions` (Admin level)
- `listUsers`
- `deleteUser`

**Course Management**
- `createCourse`
- `updateCourse`
- `deleteCourse`
- `listCourses` (All published courses vs Owned courses if Teacher)
- `viewCourse` (Restricted if teacher not owner)

**Lesson Management**
- `createLesson`
- `updateLesson`
- `deleteLesson`
- `listCourseLessons`
- `viewLesson` (Enforces enrollment check for students)

**Enrollment Operations**
- `enrollStudent` (Involves permission checks: Admin or Teacher on owned course, no student self-enrollment by default)
- `removeEnrollment`
- `listEnrollments` (Admin/Teacher view of enrolled students)
- `listStudentEnrollments` (Student viewing own enrolled courses)

**Progression Operations**
- `markLessonComplete`
- `calculateCourseProgress` (`Course::progressForUser`)

**Analytics / Dashboarding**
- `getAdminStatistics` (Total user/course count, recent activity)
- `getTeacherStatistics` (Own courses, enrollment tracking)


## 4. DATA FLOW ANALYSIS

**Example: View a Lesson (Student perspective)**
1. **Route Request**: User visits `/courses/{course-slug}/lessons/{lesson-slug}`
2. **Controller Logic**: `LessonController@show` receives the request.
3. **Business Rule Evaluation**: Controller checks if the user's role is `student`. If so, uses Eloquent (`Enrollment::where...`) to verify if an enrollment record links the user to the course. If not enrolled, abort 403.
4. **Model Interaction**: Loads the specific `Lesson` model. Queries `LessonProgress` to see if the user has already marked it complete.
5. **View Rendering**: Returns the lesson details, video URL, content, and the current progress state back to the Blade template.

**Example: Enroll Student (Teacher perspective)**
1. **Route Request**: POST `/courses/{course-slug}/enroll` submitted via form.
2. **Controller Logic**: `EnrollmentController@enroll` evaluated.
3. **Business Rule Evaluation**: Checks if the user is a teacher and owns the course. Checks if target user is actually a student. Checks if enrollment already exists (No duplicates).
4. **Model Interaction & Database Process**: Calls `Enrollment::create()` inserting user_id, course_id, and active status.
5. **Output**: Redirects back with a success flash message.

**Example: Complete Lesson**
1. **Route Request**: POST `/courses/{course}/lessons/{lesson}/complete`
2. **Controller Logic**: `LessonController@complete` evaluated.
3. **Database Write**: `LessonProgress::updateOrCreate` executes to insert/update the completion status for the auth ID / lesson ID tuple, inserting the current timestamp into `completed_at`.
4. **Output**: Redirect back.


## 5. FUTURE API STRUCTURE PREVIEW

To transition to a React frontend, the following RESTful/JSON API endpoints would elegantly map to the discovered core logic.

**Auth API**
- `POST /api/auth/register`
- `POST /api/auth/login`
- `POST /api/auth/logout`
- `GET /api/user` (Get current user and profile data)

**Users API (Admin)**
- `GET /api/users`
- `POST /api/users`
- `PUT /api/users/{id}`
- `DELETE /api/users/{id}`

**Courses API**
- `GET /api/courses` (Returns published courses, or contextual courses based on token role)
- `GET /api/courses/{slug}` (View details - includes basic lesson listing and enrollment-check middleware)
- `POST /api/courses` (Teacher/Admin only)
- `PUT /api/courses/{slug}` (Owner/Admin only)
- `DELETE /api/courses/{slug}` (Owner/Admin only)

**Lessons API**
- `GET /api/courses/{course_slug}/lessons` (List lessons)
- `GET /api/courses/{course_slug}/lessons/{lesson_slug}` (Requires enrollment for students)
- `POST /api/courses/{course_slug}/lessons` (Teacher/Admin only)
- `PUT /api/lessons/{id}` (Teacher/Admin only)
- `DELETE /api/lessons/{id}` (Teacher/Admin only)
- `POST /api/lessons/{id}/complete` (Toggle/mark lesson progress)

**Enrollment API**
- `GET /api/enrollments` (Admin get all, Student gets own enrollments)
- `POST /api/courses/{course_id}/enroll` (Payload must specify `user_id` unless self-enrollment is added later. Validated by Teacher ownership rules)
- `DELETE /api/enrollments/{enrollment_id}`

**Dashboards / Analytics API**
- `GET /api/dashboard/admin` (High-level stats)
- `GET /api/dashboard/teacher` (Teacher's own course stats)
- `GET /api/dashboard/student` (Student's enrolled courses and progress metrics based on `progressForUser`)
