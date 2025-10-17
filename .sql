-- =======================================
--  DATABASE STRUCTURE FOR BARANGAY SYSTEM
--  Converted from SQLite to MySQL
-- =======================================

-- DROP DATABASE TO RESET
DROP DATABASE IF EXISTS barangay_system;

-- CREATE DATABASE
CREATE DATABASE IF NOT EXISTS barangay_system CHARACTER
SET
    utf8mb4 COLLATE utf8mb4_general_ci;

USE barangay_system;

-- =======================================
-- 1. RESIDENTS TABLE
-- =======================================
CREATE TABLE IF NOT EXISTS residents (
    id VARCHAR(64) PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    middle_name VARCHAR(100),
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    birth_date DATE NOT NULL,
    contact_number VARCHAR(20) NOT NULL,
    gender ENUM ('Male', 'Female', 'Other') NOT NULL,
    civil_status ENUM (
        'Single',
        'Married',
        'Widowed',
        'Separated',
        'Divorced'
    ) NOT NULL,
    address TEXT NOT NULL,
    residency_start_date DATE NOT NULL,
    token VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- =======================================
-- 2. STAFFS TABLE
-- =======================================
CREATE TABLE IF NOT EXISTS staffs (
    id VARCHAR(64) PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    role ENUM ('Staff', 'Administrator') NOT NULL,
    token VARCHAR(255) DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- =======================================
-- 3. ANNOUNCEMENTS TABLE
-- =======================================
CREATE TABLE IF NOT EXISTS announcements (
    id VARCHAR(64) PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    date DATE NOT NULL,
    time TIME DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- =======================================
-- 4. REQUESTS TABLE
-- =======================================
CREATE TABLE IF NOT EXISTS requests (
    id VARCHAR(64) PRIMARY KEY,
    request_for ENUM (
        'Self',
        'Child',
        'Husband/Wife'
    ) NOT NULL,
    resident_id VARCHAR(64) NOT NULL,
    document_type VARCHAR(100) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    middle_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    birth_date DATE NOT NULL,
    gender ENUM ('Male', 'Female', 'Other') NOT NULL,
    civil_status ENUM (
        'Single',
        'Married',
        'Widowed',
        'Separated',
        'Divorced'
    ) NOT NULL,
    address TEXT NOT NULL,
    contact_number VARCHAR(20) NOT NULL,
    residency_start_date DATE DEFAULT NULL,
    purpose TEXT NOT NULL,
    status ENUM (
        'Pending',
        'Approved',
        'Rejected',
        'Cancelled'
    ) DEFAULT 'Pending',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (resident_id) REFERENCES residents (id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- =======================================
-- 5. REPORTS TABLE
-- =======================================
CREATE TABLE IF NOT EXISTS reports (
    id VARCHAR(64) PRIMARY KEY,
    request_id VARCHAR(64) NOT NULL,
    status ENUM ('Pending', 'Paid') DEFAULT 'Pending',
    process_by VARCHAR(64) DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (request_id) REFERENCES requests (id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- =======================================
-- 6. DEFAULT ADMIN ACCOUNT
-- =======================================
INSERT INTO
    staffs (
        id,
        first_name,
        last_name,
        email,
        password,
        phone_number,
        role
    )
VALUES (
        'staff_admin',
        'FirstName',
        'LastName',
        'admin@gmail.com',
        '$2y$10$2hPenp1HG2l4QmqmqGlsyOn6Vc0qw82AwFkVbXGCiw/DiVBMh9Wzm',
        '09123456789',
        'Administrator'
    ) ON DUPLICATE KEY
UPDATE id = id;

-- =======================================
-- ✅ DATABASE INITIALIZATION COMPLETE
-- =======================================