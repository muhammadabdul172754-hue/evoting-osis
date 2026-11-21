CREATE DATABASE evoting_osis;
USE evoting_osis;

CREATE TABLE admin (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE,
  password VARCHAR(255)
);

-- password default: admin123 (sudah di-hash)
INSERT INTO admin (username, password) VALUES
('admin', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHe1HlCS4bZJ18JuywdB2vWq5o1Yq7Xk2S');

CREATE TABLE calon (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100),
  visi_misi TEXT,
  foto VARCHAR(255)
);

CREATE TABLE siswa (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100),
  kelas VARCHAR(50),
  sudah_voting TINYINT(1) DEFAULT 0
);

CREATE TABLE votes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  siswa_id INT,
  calon_id INT,
  waktu TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY unik_siswa (siswa_id),
  FOREIGN KEY (siswa_id) REFERENCES siswa(id) ON DELETE CASCADE,
  FOREIGN KEY (calon_id) REFERENCES calon(id) ON DELETE CASCADE
);