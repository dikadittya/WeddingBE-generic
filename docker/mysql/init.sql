-- Initialize database for wedding application
CREATE DATABASE IF NOT EXISTS wedding_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Create user if not exists
CREATE USER IF NOT EXISTS 'wedding_user'@'%' IDENTIFIED BY 'wedding_password';
GRANT ALL PRIVILEGES ON wedding_db.* TO 'wedding_user'@'%';
FLUSH PRIVILEGES;