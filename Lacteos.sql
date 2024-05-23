CREATE DATABASE Lacteos;

USE Lacteos

CREATE TABLE administrador(
id_admin INT PRIMARY KEY NOT NULL,
usuario_admin VARCHAR(50),
correo_admin VARCHAR(250),
contra_admin VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE Clientes(
id_cliente INT PRIMARY KEY NOT NULL,
id_admin INT,
id_pedido INT,
nombre_cliente VARCHAR(50),
edad_cliente DATE,
direccion VARCHAR(60),
correo_Cliente VARCHAR(250),
telefono_cliente NUMERIC(5,2) UNIQUE,
relacion_cliente VARCHAR(60),
fecha_registro DATE DEFAULT NOW(),
CONSTRAINT fk_adm FOREIGN KEY(id_admin) REFERENCES administrador(id_admin)
);



CREATE TABLE Usuarios(
id_usuario INT PRIMARY KEY NOT NULL,
id_admin INT,
nombre_usuario VARCHAR(50),
edad_usuario DATE,
tipo_usuario VARCHAR(60),
correo_usuario VARCHAR(250),
telefono_usuario NUMERIC(5,2) ,
cuenta_usuario VARCHAR(60),
fecha_registro DATE DEFAULT NOW(),
CONSTRAINT fk_ad FOREIGN KEY(id_admin) REFERENCES administrador(id_admin)	
);


CREATE TABLE CatalogoProducto(
id_catalogo INT PRIMARY KEY NOT NULL,
id_admin INT, 
nombre_catalogo VARCHAR(50),
cantidad NUMERIC(5,2),
precio VARCHAR(60),
correo_proveedor VARCHAR(250),
telefono_proveedor NUMERIC(5,2),
lugar VARCHAR(60),
fecha_ingreso DATE DEFAULT NOW(),
CONSTRAINT fk_admin FOREIGN KEY(id_admin) REFERENCES administrador(id_admin)	
);


CREATE TABLE Proveedores(
id_prove INT PRIMARY KEY NOT NULL,
nombre_pro VARCHAR(60),
apellido_pro VARCHAR(60),
empresa VARCHAR(60),
correo_pro VARCHAR(250),
numero_pro NUMERIC(8,2),
fecha_registro DATE DEFAULT NOW(),
id_catalogo INT,
CONSTRAINT fk_cli FOREIGN KEY(id_catalogo) REFERENCES CatalogoProducto(id_catalogo)
);


CREATE TABLE Pedidos(
id_pedido INT PRIMARY KEY NOT NULL,
id_cliente INT,
estado_pedido VARCHAR(50),
fecha_registro DATE,
CONSTRAINT fk_cl FOREIGN KEY(id_cliente) REFERENCES Clientes(id_cliente)
);

DROP TABLE Pedidos


CREATE TABLE DetallePedido(
id_detale INT PRIMARY KEY NOT NULL,
id_pedido INT,
id_catalogo INT,
nombre_detalle VARCHAR(60),
cantidad_catpro INT,
fecha_registro DATE DEFAULT NOW(),
precio_catpro NUMERIC(5,2),
CONSTRAINT fk_pedid FOREIGN KEY (id_pedido) REFERENCES Pedidos(id_pedido)
);

CREATE TABLE Comentarios(
id_valoracion INT PRIMARY KEY NOT NULL,
id_detale INT,
nombre_cliente VARCHAR(50),
calificaciom_pro VARCHAR(250),
comentario_pro VARCHAR(250),
descripcion_pro VARCHAR(60),
estado_comentario BOOLEAN NOT NULL,
fecha_comentario DATE NOT NULL,
CONSTRAINT fk_deta FOREIGN KEY (id_detale) REFERENCES DetallePedido(id_detale)
);













 

