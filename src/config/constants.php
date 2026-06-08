<?php
// User Roles
define('ROLE_ADMIN',   'admin');
define('ROLE_FACULTY', 'faculty');
define('ROLE_STUDENT', 'student');

// Enrollment Statuses
define('ENROLLMENT_ACTIVE',    'active');
define('ENROLLMENT_DROPPED',   'dropped');
define('ENROLLMENT_COMPLETED', 'completed');

// Attendance Statuses
define('ATTENDANCE_PRESENT', 'present');
define('ATTENDANCE_ABSENT',  'absent');
define('ATTENDANCE_LATE',    'late');
define('ATTENDANCE_EXCUSED', 'excused');

// Submission Statuses
define('SUBMISSION_PENDING',  'pending');
define('SUBMISSION_GRADED',   'graded');
define('SUBMISSION_LATE',     'late');
define('SUBMISSION_RETURNED', 'returned');

// Grade Letter Boundaries
define('GRADE_A_MIN', 90);
define('GRADE_B_MIN', 80);
define('GRADE_C_MIN', 70);
define('GRADE_D_MIN', 60);

// Pagination
define('DEFAULT_PAGE_SIZE', 20);

// Token Expiry (seconds)
define('PASSWORD_RESET_EXPIRY', 3600);    // 1 hour
define('EMAIL_VERIFY_EXPIRY',   86400);   // 24 hours
