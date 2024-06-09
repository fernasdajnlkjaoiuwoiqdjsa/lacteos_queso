DROP DATABASE if EXISTS lacteos2;

CREATE DATABASE lacteos2;

USE lacteos2;

CREATE TABLE administrador(
id_admin INT PRIMARY KEY NOT NULL,
usuario_admin VARCHAR(50),
correo_admin VARCHAR(250),
contra_admin VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE Clientes(
id_cliente INT PRIMARY KEY NOT NULL,
id_admin INT,
nombre_cliente VARCHAR(50),
edad_cliente DATE,
direccion VARCHAR(60),
cuenta_cliente VARCHAR(250),
telefono_cliente NUMERIC(5,2) UNIQUE,
relacion_cliente VARCHAR(60),
fecha_registro DATE DEFAULT NOW(),
CONSTRAINT fk_adm FOREIGN KEY(id_admin) REFERENCES administrador(id_admin)
);

CREATE TABLE Proveedores(
id_proveedor INT PRIMARY KEY NOT NULL,
nombre_pro VARCHAR(60),
apellido_pro VARCHAR(60),
empresa VARCHAR(60),
correo_pro VARCHAR(250),
numero_pro VARCHAR(25),
fecha_registro DATE DEFAULT NOW()
);

CREATE TABLE CatalogoProducto(
id_catalogo INT PRIMARY KEY NOT NULL,
id_admin INT, 
nombre_catalogo VARCHAR(50),
cantidad INT,
precio_producto DECIMAL(6,2),
correo_proveedor VARCHAR(250),
telefono_proveedor VARCHAR(25),
lugar VARCHAR(60),
fecha_ingreso DATE DEFAULT NOW(),
id_proveedor INT,
CONSTRAINT fk_admin FOREIGN KEY(id_admin) REFERENCES administrador(id_admin),
CONSTRAINT fk_proveedor_catalogo FOREIGN KEY(id_proveedor) REFERENCES Proveedores(id_proveedor)	
);


CREATE TABLE Pedidos(
id_pedido INT PRIMARY KEY NOT NULL,
id_cliente INT,
estado_pedido VARCHAR(50),
fecha_registro DATE,
CONSTRAINT fk_cl FOREIGN KEY(id_cliente) REFERENCES Clientes(id_cliente)
);

-- DROP TABLE Pedidos


CREATE TABLE DetallePedido(
id_detalle INT PRIMARY KEY NOT NULL,
id_pedido INT,
id_catalogo INT,
nombre_detalle VARCHAR(60),
cantidad_catpro INT,
fecha_registro DATE DEFAULT NOW(),
total NUMERIC(5,2),
CONSTRAINT fk_pedid FOREIGN KEY (id_pedido) REFERENCES Pedidos(id_pedido),
CONSTRAINT fk_catalogito FOREIGN KEY (id_catalogo) REFERENCES CatalogoProducto (id_catalogo)
);


-- DELETE TABLE DetallePedido


CREATE TABLE comentarios (
  `id_comentario` int(11) NOT NULL PRIMARY KEY,
  `id_detalle` int(11) DEFAULT NULL,
  `comentarios` varchar(100) NOT NULL,
  `calificacion` INT,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
);














 

