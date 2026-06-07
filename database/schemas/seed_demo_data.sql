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

-- ==========================================================
-- SEMESTERS
-- ==========================================================

INSERT INTO semesters
(name,start_date,end_date,is_current)
VALUES
(
'Fall 2026',
'2026-09-01',
'2026-12-20',
1
);

-- ==========================================================
-- COURSES
-- ==========================================================

INSERT INTO courses
(
code,
title,
description,
credits,
max_capacity,
department_id,
faculty_id,
semester_id
)
VALUES
(
'CS101',
'Introduction to Programming',
'Fundamentals of programming using modern software development practices.',
3,
40,
1,
2,
1
);

-- ==========================================================
-- ENROLLMENTS
-- ==========================================================

INSERT INTO enrollments
(student_id,course_id,status)
VALUES
(
3,
1,
'active'
);

-- ==========================================================
-- ATTENDANCE
-- ==========================================================

INSERT INTO attendance
(
student_id,
course_id,
date,
status,
marked_by
)
VALUES

(3,1,'2026-09-05','present',2),
(3,1,'2026-09-12','present',2),
(3,1,'2026-09-19','absent',2);

-- ==========================================================
-- ASSIGNMENTS
-- ==========================================================

INSERT INTO assignments
(
course_id,
title,
description,
total_marks,
due_date,
allow_late,
late_penalty_pct,
created_by
)
VALUES
(
1,
'Programming Assignment 1',
'Create a simple student management program.',
100,
'2026-10-15 23:59:59',
1,
10,
2
);

-- ==========================================================
-- SUBMISSIONS
-- ==========================================================

INSERT INTO submissions
(
assignment_id,
student_id,
file_path,
submitted_at,
status
)
VALUES
(
1,
3,
'uploads/submissions/assignment1.pdf',
NOW(),
'graded'
);

-- ==========================================================
-- GRADES
-- ==========================================================

INSERT INTO grades
(
submission_id,
graded_by,
marks_obtained,
feedback
)
VALUES
(
1,
2,
85,
'Good work. Well structured solution with minor improvements required.'
);

-- ==========================================================
-- NOTIFICATIONS
-- ==========================================================

INSERT INTO notifications
(user_id,title,body,type)
VALUES

(
1,
'System Initialized',
'Campus Management Platform demo data loaded.',
'info'
),

(
2,
'Student Enrollment',
'John Student has enrolled in CS101.',
'info'
),

(
3,
'Assignment Graded',
'Programming Assignment 1 has been graded.',
'grade'
);

-- ==========================================================
-- SCHEDULE
-- ==========================================================

INSERT INTO schedules
(
course_id,
day_of_week,
start_time,
end_time,
room
)
VALUES
(
1,
0,
'09:00:00',
'11:00:00',
'Lab A1'
);

