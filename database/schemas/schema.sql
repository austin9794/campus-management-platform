-- ============================================================
-- Campus Management Platform — Full Database Schema
-- Run migrations in order: 001 → 012
-- ============================================================

-- 001: users (base table for all roles)
CREATE TABLE users (
    id                  INT UNSIGNED    AUTO_INCREMENT PRIMARY KEY,
    name                VARCHAR(120)    NOT NULL,
    email               VARCHAR(180)    NOT NULL UNIQUE,
    password_hash       VARCHAR(255)    NOT NULL,
    role                ENUM('admin','faculty','student') NOT NULL,
    avatar              VARCHAR(255)    NULL,
    is_active           TINYINT(1)      NOT NULL DEFAULT 1,
    reset_token         VARCHAR(64)     NULL,
    reset_token_expires DATETIME        NULL,
    email_verified_at   DATETIME        NULL,
    created_at          DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at          DATETIME        NULL ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_role (role),
    INDEX idx_email (email)
);

-- 002: departments
CREATE TABLE departments (
    id          INT UNSIGNED    AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(120)    NOT NULL,
    code        VARCHAR(20)     NOT NULL UNIQUE,
    head_id     INT UNSIGNED    NULL,
    created_at  DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (head_id) REFERENCES users(id) ON DELETE SET NULL
);

-- 003: semesters
CREATE TABLE semesters (
    id          INT UNSIGNED    AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(60)     NOT NULL,        -- e.g. "Fall 2024"
    start_date  DATE            NOT NULL,
    end_date    DATE            NOT NULL,
    is_current  TINYINT(1)      NOT NULL DEFAULT 0,
    created_at  DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- 004: courses
CREATE TABLE courses (
    id              INT UNSIGNED    AUTO_INCREMENT PRIMARY KEY,
    code            VARCHAR(20)     NOT NULL UNIQUE,   -- e.g. CS101
    title           VARCHAR(180)    NOT NULL,
    description     TEXT            NULL,
    credits         TINYINT         NOT NULL DEFAULT 3,
    max_capacity    SMALLINT        NOT NULL DEFAULT 40,
    department_id   INT UNSIGNED    NOT NULL,
    faculty_id      INT UNSIGNED    NULL,
    semester_id     INT UNSIGNED    NOT NULL,
    is_active       TINYINT(1)      NOT NULL DEFAULT 1,
    created_at      DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (department_id) REFERENCES departments(id),
    FOREIGN KEY (faculty_id)    REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (semester_id)   REFERENCES semesters(id),
    INDEX idx_semester (semester_id),
    INDEX idx_department (department_id)
);

-- 005: enrollments (student ↔ course many-to-many)
CREATE TABLE enrollments (
    id          INT UNSIGNED    AUTO_INCREMENT PRIMARY KEY,
    student_id  INT UNSIGNED    NOT NULL,
    course_id   INT UNSIGNED    NOT NULL,
    status      ENUM('active','dropped','completed') NOT NULL DEFAULT 'active',
    enrolled_at DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    dropped_at  DATETIME        NULL,
    UNIQUE KEY uq_enrollment (student_id, course_id),
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id)  REFERENCES courses(id) ON DELETE CASCADE,
    INDEX idx_course  (course_id),
    INDEX idx_student (student_id)
);

-- 006: attendance
CREATE TABLE attendance (
    id          INT UNSIGNED    AUTO_INCREMENT PRIMARY KEY,
    student_id  INT UNSIGNED    NOT NULL,
    course_id   INT UNSIGNED    NOT NULL,
    date        DATE            NOT NULL,
    status      ENUM('present','absent','late','excused') NOT NULL,
    note        VARCHAR(255)    NULL,
    marked_by   INT UNSIGNED    NOT NULL,   -- faculty user id
    created_at  DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_attendance (student_id, course_id, date),
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id)  REFERENCES courses(id) ON DELETE CASCADE,
    FOREIGN KEY (marked_by)  REFERENCES users(id),
    INDEX idx_course_date (course_id, date)
);

-- 007: assignments
CREATE TABLE assignments (
    id              INT UNSIGNED    AUTO_INCREMENT PRIMARY KEY,
    course_id       INT UNSIGNED    NOT NULL,
    title           VARCHAR(180)    NOT NULL,
    description     TEXT            NULL,
    total_marks     DECIMAL(6,2)    NOT NULL DEFAULT 100.00,
    due_date        DATETIME        NOT NULL,
    allow_late      TINYINT(1)      NOT NULL DEFAULT 0,
    late_penalty_pct DECIMAL(5,2)   NOT NULL DEFAULT 0.00,
    created_by      INT UNSIGNED    NOT NULL,
    created_at      DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id)  REFERENCES courses(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id),
    INDEX idx_course_due (course_id, due_date)
);

