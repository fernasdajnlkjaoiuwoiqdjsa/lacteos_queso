CREATE DATABASE lacteos;

USE lacteos

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



CREATE TABLE CatalogoProducto(
id_catalogo INT PRIMARY KEY NOT NULL,
id_admin INT, 
nombre_catalogo VARCHAR(50),
cantidad NUMERIC(5,2),
precio_producto VARCHAR(60),
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
id_detale INT,
estado_pedido VARCHAR(50),
fecha_registro DATE,
CONSTRAINT fk_cl FOREIGN KEY(id_cliente) REFERENCES Clientes(id_cliente)
);

DROP TABLE Pedidos


CREATE TABLE DetallePedido(
id_detale INT PRIMARY KEY NOT NULL,
id_pedido INT,
nombre_detalle VARCHAR(60),
cantidad_catpro INT,
fecha_registro DATE DEFAULT NOW(),
precio_catpro NUMERIC(5,2),
CONSTRAINT fk_pedid FOREIGN KEY (id_pedido) REFERENCES Pedidos(id_pedido)
);



CREATE TABLE `tbl_comentarios` (
  `co_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `comentarios` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `comentario_nombre` varchar(40) CHARACTER SET utf8 NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;














 

