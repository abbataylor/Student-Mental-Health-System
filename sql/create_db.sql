-- Create database and tables for Student Mental Health System
CREATE DATABASE IF NOT EXISTS mental_health_db;
USE mental_health_db;

CREATE TABLE IF NOT EXISTS students (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS assessments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  student_id INT NOT NULL,
  sleep_hours INT,
  study_pressure INT,
  stress_frequency VARCHAR(50),
  result VARCHAR(50),
  advice TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  student_id INT,
  sender VARCHAR(50),
  message TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default admin (password: adminpass)
INSERT INTO admins (username, password) VALUES ('admin', '$2y$10$CwTycUXWue0Thq9StjUM0uJ8vQ/3G7zQjmQXQGz8ZQ0a6qJ2XyK2W');
-- The above hash corresponds to 'adminpass' using password_hash()
