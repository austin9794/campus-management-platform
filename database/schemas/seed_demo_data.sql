-- ==========================================================
-- Campus Management Platform Demo Seed Data
-- ==========================================================

SET FOREIGN_KEY_CHECKS = 0;

TRUNCATE TABLE audit_logs;
TRUNCATE TABLE schedules;
TRUNCATE TABLE notifications;
TRUNCATE TABLE grades;
TRUNCATE TABLE submissions;
TRUNCATE TABLE assignments;
TRUNCATE TABLE attendance;
TRUNCATE TABLE enrollments;
TRUNCATE TABLE courses;
TRUNCATE TABLE semesters;
TRUNCATE TABLE departments;
TRUNCATE TABLE users;

SET FOREIGN_KEY_CHECKS = 1;

-- ==========================================================
-- USERS
-- ==========================================================

INSERT INTO users
(name,email,password_hash,role,email_verified_at)
VALUES

(
'System Administrator',
'admin@campus.local',
'REPLACE_ADMIN_HASH',
'admin',
NOW()
),

(
'Dr Sarah Wilson',
'faculty@campus.local',
'REPLACE_FACULTY_HASH',
'faculty',
NOW()
),

(
'John Student',
'student@campus.local',
'REPLACE_STUDENT_HASH',
'student',
NOW()
);

-- ==========================================================
-- DEPARTMENTS
-- ==========================================================

INSERT INTO departments
(name,code,head_id)
VALUES
(
'Computer Science',
'CS',
2
);