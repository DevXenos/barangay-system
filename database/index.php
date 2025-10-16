<?php
$dbPath = __DIR__ . "/database.sqlite";
$conn = new SQLite3($dbPath);

// === CREATE TABLES ===

// Residents table
$conn->exec("
CREATE TABLE IF NOT EXISTS residents (
    id TEXT PRIMARY KEY,
    first_name TEXT NOT NULL,
    middle_name TEXT,
    last_name TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    birth_date TEXT NOT NULL,
    contact_number TEXT NOT NULL,
    gender TEXT CHECK(gender IN ('Male', 'Female', 'Other')) NOT NULL,
    civil_status TEXT CHECK(civil_status IN ('Single','Married','Widowed','Separated','Divorced')) NOT NULL,
    address TEXT NOT NULL,
    residency_start_date TEXT NOT NULL,
    token TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
");

echo "Residents Table Created<br>";

// Staffs table
$conn->exec("
CREATE TABLE IF NOT EXISTS staffs (
    id TEXT PRIMARY KEY,
    first_name TEXT NOT NULL,
    last_name TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    phone_number TEXT NOT NULL,
    role TEXT CHECK(role IN ('Staff','Administrator')) NOT NULL,
    token TEXT DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
");

echo "Staffs Table created<br>";

// Announcements table
$conn->exec("
CREATE TABLE IF NOT EXISTS announcements (
    id TEXT PRIMARY KEY,
    title TEXT NOT NULL,
    description TEXT NOT NULL,
    date TEXT NOT NULL,
    time TEXT DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
");

echo "Announcements table is created<br>";

// Requests table
$conn->exec("
CREATE TABLE IF NOT EXISTS requests (
    id TEXT PRIMARY KEY,
    request_for TEXT CHECK(request_for IN ('Self','Child','Husband/Wife')) NOT NULL,
    resident_id TEXT NOT NULL,
    document_type TEXT NOT NULL,
    first_name TEXT NOT NULL,
    middle_name TEXT NOT NULL,
    last_name TEXT NOT NULL,
    birth_date TEXT NOT NULL,
    gender TEXT CHECK(gender IN ('Male','Female','Other')) NOT NULL,
    civil_status TEXT CHECK(civil_status IN ('Single','Married','Widowed','Separated','Divorced')) NOT NULL,
    address TEXT NOT NULL,
    contact_number TEXT NOT NULL,
    residency_start_date TEXT DEFAULT NULL,
    purpose TEXT NOT NULL,
    status TEXT CHECK(status IN ('Pending','Approved','Rejected','Cancelled')) DEFAULT 'Pending',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (resident_id) REFERENCES residents(id) ON DELETE CASCADE ON UPDATE CASCADE
);
");

echo "Request Table Is Created<br>";

// Reports Table
$conn->exec("
CREATE TABLE IF NOT EXISTS reports (
    id TEXT PRIMARY KEY,
    request_id TEXT NOT NULL,
    status TEXT CHECK(status IN ('Pending', 'Paid')) DEFAULT 'Pending',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (request_id) REFERENCES requests(id) ON DELETE CASCADE ON UPDATE CASCADE
);
");

echo "Reports Table Created<br>";


// === DEFAULT ADMIN ACCOUNT ===
$conn->exec("
INSERT INTO staffs (id, first_name, last_name, email, password, phone_number, role)
VALUES (
    'staff_admin',
    'FirstName',
    'LastName',
    'admin@gmail.com',
    '\$2y\$10\$2hPenp1HG2l4QmqmqGlsyOn6Vc0qw82AwFkVbXGCiw/DiVBMh9Wzm',
    '09123456789',
    'Administrator'
) ON CONFLICT(id) DO NOTHING;
");

echo "Admin Default Account Inserted<br>";
echo "✅ SQLite database initialized successfully!<br>";

// Add New Column for reports
$conn->exec("
ALTER TABLE reports ADD COLUMN process_by TEXT
");