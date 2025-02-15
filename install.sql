-- Création de la base de données
CREATE DATABASE IF NOT EXISTS compta_db;
USE compta_db;

-- Table des utilisateurs
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user'
);

-- Insertion d'un utilisateur admin par défaut (mot de passe: admin123)
INSERT INTO users (username, password, role) VALUES ('admin', MD5('admin123'), 'admin');

-- Table des journaux comptables
CREATE TABLE IF NOT EXISTS journals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);
-- Insertion de quelques journaux par défaut
INSERT INTO journals (name) VALUES ('Achats'), ('Ventes'), ('Banque'), ('OD');

-- Table du plan comptable (comptes)
CREATE TABLE IF NOT EXISTS accounts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(20) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    type ENUM('Actif', 'Passif', 'Charge', 'Produit') NOT NULL
);
-- Exemples de comptes
INSERT INTO accounts (code, name, type) VALUES 
('101', 'Caisse', 'Actif'),
('102', 'Banque', 'Actif'),
('201', 'Fournisseurs', 'Passif'),
('301', 'Ventes', 'Produit'),
('401', 'Achats', 'Charge');

-- Table des écritures comptables
CREATE TABLE IF NOT EXISTS entries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date DATE NOT NULL,
    journal_id INT NOT NULL,
    account_id INT NOT NULL,
    piece VARCHAR(50),
    label VARCHAR(255),
    debit DECIMAL(10,2) DEFAULT 0,
    credit DECIMAL(10,2) DEFAULT 0,
    FOREIGN KEY (journal_id) REFERENCES journals(id),
    FOREIGN KEY (account_id) REFERENCES accounts(id)
);
-- Table pour la gestion de la TVA
CREATE TABLE IF NOT EXISTS vat_rates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    rate DECIMAL(5,2) NOT NULL,   -- Exemple : 20.00 pour 20 %
    is_active TINYINT(1) DEFAULT 1
);

-- Table pour la facturation
CREATE TABLE IF NOT EXISTS invoices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invoice_number VARCHAR(50) UNIQUE NOT NULL,
    date DATE NOT NULL,
    client_name VARCHAR(255) NOT NULL,
    total_amount DECIMAL(10,2) DEFAULT 0,
    vat_amount DECIMAL(10,2) DEFAULT 0,
    status ENUM('pending','paid','overdue') DEFAULT 'pending'
);

CREATE TABLE IF NOT EXISTS invoice_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invoice_id INT NOT NULL,
    description VARCHAR(255) NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    unit_price DECIMAL(10,2) NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (invoice_id) REFERENCES invoices(id) ON DELETE CASCADE
);
-- Table pour les apports des associés
CREATE TABLE IF NOT EXISTS apports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    associe VARCHAR(255) NOT NULL,
    type_apport ENUM('natures','numeraire') NOT NULL,
    valeur DECIMAL(10,2) NOT NULL,
    date_apport DATE NOT NULL
);

-- Table pour les frais de constitution
CREATE TABLE IF NOT EXISTS frais_constitution (
    id INT AUTO_INCREMENT PRIMARY KEY,
    associe VARCHAR(255) NOT NULL,
    montant DECIMAL(10,2) NOT NULL,
    date_frais DATE NOT NULL
);
-- -- Table pour les apports des associés
-- CREATE TABLE apports (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     associe VARCHAR(255) NOT NULL,
--     type_apport ENUM('natures','numeraire') NOT NULL,
--     valeur DECIMAL(10,2) NOT NULL,
--     date_apport DATE NOT NULL
-- );

-- -- Table pour les frais de constitution
-- CREATE TABLE IF NOT EXISTS frais_constitution (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     associe VARCHAR(255) NOT NULL,
--     montant DECIMAL(10,2) NOT NULL,
--     date_frais DATE NOT NULL
-- );
-- CREATE TABLE accounts (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     code VARCHAR(10) UNIQUE NOT NULL,
--     name VARCHAR(255) NOT NULL,
--     parent_code VARCHAR(10), -- Référence au code du compte parent
--     type ENUM('Actif', 'Passif', 'Charge', 'Produit') NOT NULL
-- );
ALTER TABLE accounts ADD COLUMN parent_code VARCHAR(50) NULL;
INSERT INTO apports (associe, type_apport, valeur, date_apport) VALUES ('Vincent', 'numeraire', 1326, NOW());


