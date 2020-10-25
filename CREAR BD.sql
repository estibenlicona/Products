CREATE DATABASE dbproductos;
USE dbproductos;

CREATE TABLE categorias (
	id INT NOT NULL AUTO_INCREMENT,
	nombre VARCHAR(250) NOT NULL,
    PRIMARY KEY (id)
);

INSERT INTO categorias(id, nombre) VALUES (1, 'General');
INSERT INTO categorias(id, nombre) VALUES (2, 'Dama');
INSERT INTO categorias(id, nombre) VALUES (3, 'Caballero');

CREATE TABLE productos (
	id INT NOT NULL AUTO_INCREMENT,
	nombre VARCHAR(250) NOT NULL,
    referencia VARCHAR(250) NOT NULL,
    precio FLOAT NOT NULL,
    peso INT NOT NULL,
    idcategoria INT NOT NULL,
    stock INT NOT NULL,
    fecha_creacion DATE NOT NULL,
    fecha_actualizacion DATETIME NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_cateogrias_productos FOREIGN KEY (idcategoria) REFERENCES categorias (id) ON DELETE RESTRICT ON UPDATE RESTRICT
);
