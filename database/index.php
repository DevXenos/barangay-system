<?php
$dbPath = __DIR__ . "/database.sqlite";
$conn = new SQLite3($dbPath);

if(file_exists($dbPath)) {
    unlink($dbPath);
    echo "Old Database Is Removed";
    echo "<br>";
}

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
    token TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
");

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
    purpose TEXT NOT NULL,
    status TEXT CHECK(status IN ('Pending','Approved','Rejected','Cancelled')) DEFAULT 'Pending',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (resident_id) REFERENCES residents(id) ON DELETE CASCADE ON UPDATE CASCADE
);
");

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
)
ON CONFLICT(id) DO NOTHING;
");

echo "✅ SQLite database initialized successfully!";
