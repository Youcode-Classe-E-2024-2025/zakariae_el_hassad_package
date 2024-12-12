CREATE TABLE auteur (
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    date DATE
);

CREATE TABLE package (
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    description TEXT,
    categorie VARCHAR(100)
);

CREATE TABLE auteur_package (
    auteur_id INTEGER,
    package_id INTEGER,
    PRIMARY KEY (auteur_id, package_id),
    FOREIGN KEY (auteur_id) REFERENCES auteur(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (package_id) REFERENCES package(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE version (
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    numero_version VARCHAR(50),
    date_publication DATE,
    package_id INTEGER,
    FOREIGN KEY (package_id) REFERENCES package(id)
);
SELECT package.nom as nomp,package.description,package.categorie ,auteur.nom ,version.numero_version FROM auteur_package

INNER JOIN package on auteur_package.package_id =package.id 
INNER JOIN auteur on auteur_package.auteur_id = auteur.id
INNER JOIN version on version.package_id =package.id;