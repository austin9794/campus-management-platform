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

