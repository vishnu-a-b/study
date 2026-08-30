-- Studwise International — schema
-- Import with: mysql -u root studwise_dev < database/schema.sql

SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS services (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    slug          VARCHAR(100) NOT NULL UNIQUE,
    title         VARCHAR(150) NOT NULL,
    summary       VARCHAR(500) NOT NULL,
    body          TEXT NOT NULL,
    detail_body   MEDIUMTEXT NULL,
    detail_image  VARCHAR(255) NULL,
    icon_key      VARCHAR(50)  NOT NULL DEFAULT 'default',
    show_on_home  TINYINT(1)   NOT NULL DEFAULT 0,
    sort_order    INT          NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS branches (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    name           VARCHAR(100) NOT NULL,
    is_head_office TINYINT(1)   NOT NULL DEFAULT 0,
    address        VARCHAR(255) NULL,
    phone          VARCHAR(50)  NOT NULL,
    email          VARCHAR(150) NOT NULL,
    sort_order     INT          NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS testimonials (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    student_name  VARCHAR(100) NOT NULL,
    university    VARCHAR(150) NOT NULL,
    course        VARCHAR(150) NOT NULL,
    quote         TEXT NULL,
    photo_path    VARCHAR(255) NULL,
    sort_order    INT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS team_members (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    role        VARCHAR(150) NOT NULL,
    branch_id   INT NULL,
    photo_path  VARCHAR(255) NULL,
    category    ENUM('founder','branch_head','counselor','coordinator','staff') NOT NULL DEFAULT 'staff',
    sort_order  INT NOT NULL DEFAULT 0,
    CONSTRAINT fk_team_branch FOREIGN KEY (branch_id) REFERENCES branches(id) ON DELETE SET NULL,
    INDEX idx_team_branch (branch_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS stats (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    group_key     VARCHAR(30)  NOT NULL,
    label         VARCHAR(100) NOT NULL,
    value_number  INT          NOT NULL,
    value_prefix  VARCHAR(10)  NOT NULL DEFAULT '',
    value_suffix  VARCHAR(10)  NOT NULL DEFAULT '',
    sort_order    INT          NOT NULL DEFAULT 0,
    INDEX idx_stats_group (group_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS faqs (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    question    VARCHAR(255) NOT NULL,
    answer      TEXT NOT NULL,
    sort_order  INT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS partner_logos (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(150) NULL,
    logo_path   VARCHAR(255) NOT NULL,
    sort_order  INT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS contact_messages (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    first_name   VARCHAR(100) NOT NULL,
    last_name    VARCHAR(100) NOT NULL,
    email        VARCHAR(150) NOT NULL,
    phone        VARCHAR(50)  NOT NULL,
    message      TEXT NOT NULL,
    source_page  VARCHAR(100) NULL,
    ip_address   VARCHAR(45)  NULL,
    user_agent   VARCHAR(255) NULL,
    is_spam      TINYINT(1)   NOT NULL DEFAULT 0,
    created_at   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_contact_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
