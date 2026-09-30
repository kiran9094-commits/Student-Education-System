-- ==========================================================
-- Student Education System Database Schema
-- Compatible with MySQL 5.7+ / 8.0+ and SQLite 3
-- ==========================================================

CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(120) NOT NULL UNIQUE,
    icon VARCHAR(60) DEFAULT 'fas fa-graduation-cap',
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS institutions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    type VARCHAR(50) DEFAULT 'College', -- 'University', 'College', 'School'
    category_id INT,
    accreditation VARCHAR(100) DEFAULT 'UGC / AICTE Approved',
    affiliation VARCHAR(200) DEFAULT NULL,
    city VARCHAR(100) NOT NULL,
    state VARCHAR(100) NOT NULL,
    address TEXT,
    established_year INT,
    ranking_nirf VARCHAR(50) DEFAULT NULL,
    rating DECIMAL(2,1) DEFAULT 4.5,
    reviews_count INT DEFAULT 0,
    tuition_range VARCHAR(100) DEFAULT '₹50,000 - ₹2,50,000 / yr',
    student_count INT DEFAULT 5000,
    description TEXT,
    banner_image VARCHAR(255) DEFAULT 'assets/images/college_banner_default.svg',
    logo_image VARCHAR(255) DEFAULT 'assets/images/college_logo_default.svg',
    website VARCHAR(255),
    email VARCHAR(150),
    phone VARCHAR(50),
    facilities TEXT, -- Comma-separated or JSON list of amenities (e.g. Hostel, WiFi, Lab, Sports, Library)
    is_featured TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    institution_id INT NOT NULL,
    category_id INT NOT NULL,
    name VARCHAR(200) NOT NULL,
    slug VARCHAR(220) NOT NULL,
    degree_level VARCHAR(50) NOT NULL, -- 'Undergraduate', 'Postgraduate', 'Diploma', 'Doctorate'
    duration VARCHAR(50) NOT NULL, -- e.g. '4 Years', '2 Years'
    tuition_fee DECIMAL(10,2) DEFAULT 0.00,
    eligibility TEXT,
    seats INT DEFAULT 60,
    syllabus_summary TEXT,
    career_prospects TEXT,
    avg_package VARCHAR(50) DEFAULT '₹4.5 - ₹12.0 LPA',
    is_popular TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS resources (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    category_id INT,
    course_id INT DEFAULT NULL,
    resource_type VARCHAR(60) NOT NULL, -- 'Syllabus', 'Lecture Notes', 'Sample Papers', 'Study Guide', 'E-Book'
    format VARCHAR(20) DEFAULT 'PDF',
    file_size VARCHAR(20) DEFAULT '2.4 MB',
    description TEXT,
    download_url VARCHAR(255) DEFAULT '#',
    downloads_count INT DEFAULT 0,
    is_featured TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS inquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    city VARCHAR(100),
    institution_id INT,
    course_id INT,
    qualification VARCHAR(100),
    message TEXT,
    status VARCHAR(30) DEFAULT 'Pending', -- 'Pending', 'Contacted', 'Under Review', 'Enrolled'
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    institution_id INT NOT NULL,
    student_name VARCHAR(100) NOT NULL,
    course_name VARCHAR(150),
    rating INT DEFAULT 5,
    review_title VARCHAR(200),
    review_content TEXT,
    batch_year VARCHAR(20),
    is_verified TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(60) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    role VARCHAR(30) DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
