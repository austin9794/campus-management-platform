-- ==========================================================
-- Campus Management Platform Demo Seed Data
-- ==========================================================

-- ==========================================================
-- USERS
-- ==========================================================

INSERT INTO users
(name,email,password_hash,role,email_verified_at)
VALUES

(
'System Administrator',
'admin@campus.local',
'$2a$12$gCt0RE5FPzxqpvTC6tS0tOtdlEfPMMc06CJ9xiZoGsfvYipFfRRm6',
'admin',
NOW()
),

(
'Dr Sarah Wilson',
'faculty@campus.local',
'$2a$12$JQMlemDvJkCFI6roClTzMugGvxEwgg.F4q4plxsMP3NfTcYsxcsGC',
'faculty',
NOW()
),

(
'Dr Rober Egger',
'faculty2@campus.local',
'$2a$12$PZHM/XhIYTtyE.MV/BHOOeaaCRxbvJE3TZHwBSEuE8haqNDUgch0S',
'faculty',
NOW()
),

(
'Dr Steven Smith',
'faculty3@campus.local',
'$2a$12$irJlmFKjph82r4fulI0N8expflQa/GsGqK.4ewRhLxW4QF.L6oOL.',
'faculty',
NOW()
),

(
'Musa Ali',
'student2@campus.local',
'$2a$12$NWmGDdvWPPSpmAMhvLiK2.8sxl2dByI673DNSjeY.ha6DSlQOxOsq',
'student',
NOW()
),

(
'John Doe',
'student@campus.local',
'$2a$12$BJPKOcEThcKm/GArkevhouyHxcolPnxe9V58GkARUzJ4S86hxPB3i',
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
),

(
'Cybersecurity',
'CY',
2
),

(
'Biomedical Engineering',
'BE',
3
),

(
'Accounting and Finance',
'AF',
4
),

(
'Business Administration',
'BA',
4
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
'CS1IP',
'Introduction to Programming',
'Fundamentals of programming using modern software development practices.',
15,
40,
1,
2,
1
),

(
'CS1IAI',
'Introduction to Artificial Intelligence',
'Introduces machine learning, neural networks, and heuristic search techniques for data modeling.',
15,
40,
1,
2,
1
),

(
'CS1NS',
'Network Security',
'Covers securing data transmission using encryption algorithms and defensive network protocols.',
10,
40,
2,
2,
1
),

(
'CS1DF',
'Digital Forensics',
'Focuses on recovering, preserving, and analyzing digital evidence from compromised devices.',
15,
40,
2,
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
4,
1,
'active'
),

(
5,
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

(4,1,'2026-09-05','present',2),
(4,1,'2026-09-12','present',2),
(4,1,'2026-09-19','absent',2),
(4,1,'2026-09-21','present',2),
(4,1,'2026-09-23','present',2),
(5,1,'2026-09-19','absent',3),
(5,1,'2026-09-21','present',3),
(5,1,'2026-09-23','present',3),
(5,1,'2026-09-26','present',3);

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
4,
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
'John Doe has enrolled in CS101.',
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

-- ==========================================================
-- AUDIT LOGS
-- ==========================================================

INSERT INTO audit_logs
(
user_id,
action,
entity,
entity_id,
ip_address
)
VALUES

(
1,
'SYSTEM_SEED',
'users',
1,
'127.0.0.1'
),

(
2,
'CREATE_ASSIGNMENT',
'assignments',
1,
'127.0.0.1'
);