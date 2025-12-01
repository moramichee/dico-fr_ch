
USE dictionnaire_fr_ch1;

CREATE TABLE IF NOT EXISTS utilisateurs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(100) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  mot_de_passe VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS mots_fr (
  id INT AUTO_INCREMENT PRIMARY KEY,
  mot VARCHAR(255) NOT NULL,
  traduction_ch VARCHAR(255) NOT NULL,
  pinyin VARCHAR(255) DEFAULT NULL,
  exemple_ch TEXT,
  exemple_fr TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS mots_ch (
  id INT AUTO_INCREMENT PRIMARY KEY,
  caractere VARCHAR(255) NOT NULL,
  pinyin VARCHAR(255) DEFAULT NULL,
  traduction_fr VARCHAR(255) NOT NULL,
  exemple_fr TEXT,
  exemple_ch TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS notes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_mot INT NOT NULL,
  type ENUM('fr','ch') NOT NULL DEFAULT 'fr',
  note TINYINT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX (id_mot)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
 
 /* Admin insertion
 Email : admin@admin.com
 Mot de passe : admin123
 
  */
INSERT INTO utilisateurs (nom, email, mot_de_passe)
VALUES (
    'Administrateur',
    'admin@admin.com',
    '$2y$10$B.kDZzO9WcIgxBfrqhMBkuOm1xJE3TrwPq8fV3ag7SgBr79BbEOWm'
);
