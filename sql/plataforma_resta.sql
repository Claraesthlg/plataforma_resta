CREATE DATABASE IF NOT EXISTS plataforma_resta;
USE plataforma_resta;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE exercises (
  id INT AUTO_INCREMENT PRIMARY KEY,
  numero_mayor INT NOT NULL,
  numero_menor INT NOT NULL,
  result INT NOT NULL,
  completed TINYINT(1) DEFAULT 0,
  user_id INT NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

-- CREATE TABLE user_exercises (
--   id INT AUTO_INCREMENT PRIMARY KEY,
--   user_id INT NOT NULL,
--   ejercicio_id INT NOT NULL,
--   correcto BOOLEAN DEFAULT FALSE,
--   created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
--   FOREIGN KEY (user_id) REFERENCES users(id),
--   FOREIGN KEY (ejercicio_id) REFERENCES exercises(id)
-- );
