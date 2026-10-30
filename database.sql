-- ============================================================
-- Mini-Projet : Gestion des Convocations des Témoins
-- Base de données : justice_db
-- ============================================================

CREATE DATABASE IF NOT EXISTS justice_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE justice_db;

-- Table 1 : Affaires (القضايا)
CREATE TABLE IF NOT EXISTS Affaires (
    num_dossier     VARCHAR(20)   NOT NULL PRIMARY KEY,
    date_affaire    DATE          NOT NULL,
    type_affaire    VARCHAR(100)  NOT NULL,
    code_affaire    VARCHAR(50)   NOT NULL
) ENGINE=InnoDB;

-- Table 2 : Temoins (الشهود)
CREATE TABLE IF NOT EXISTS Temoins (
    num_temoin      INT AUTO_INCREMENT PRIMARY KEY,
    nom_complet     VARCHAR(150)  NOT NULL,
    adresse         VARCHAR(255)  NOT NULL,
    num_dossier     VARCHAR(20)   NOT NULL,
    CONSTRAINT fk_temoin_affaire
        FOREIGN KEY (num_dossier)
        REFERENCES Affaires(num_dossier)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;

-- بيانات تجريبية (اختياري)
INSERT INTO Affaires (num_dossier, date_affaire, type_affaire, code_affaire) VALUES
('2026/1500', CURDATE(), 'قضية مدنية', 'C-2026-1500'),
('2026/1501', CURDATE(), 'قضية جنائية', 'P-2026-1501');

INSERT INTO Temoins (nom_complet, adresse, num_dossier) VALUES
('محمد العلوي', 'حي السلام، سوق الأربعاء الغرب', '2026/1500'),
('فاطمة الزهراء بنعلي', 'شارع الحسن الثاني، سوق الأربعاء الغرب', '2026/1501');
