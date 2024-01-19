CREATE DATABASE IF NOT EXISTS tienda;
SET NAMES UTF8MB4;
USE tienda;


DROP TABLE IF EXISTS lineas_pedidos;
DROP TABLE IF EXISTS productos;
DROP TABLE IF EXISTS categorias;
DROP TABLE IF EXISTS pedidos;
DROP TABLE IF EXISTS usuarios;


CREATE TABLE IF NOT EXISTS usuarios(
    id              int(255) auto_increment not null,
    nombre          varchar(100) not null,
    apellidos       varchar(255),
    email           varchar(255) not null,
    password        varchar(255) not null,
    rol             varchar(20),
    CONSTRAINT pk_usuarios PRIMARY KEY(id),
    CONSTRAINT uq_email UNIQUE(email)
    )ENGINE=InnoDb DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `email`, `password`, `rol`) VALUES (NULL, 'Admin', 'Istrador', 'admin@correo.com', '$2y$04$VCc.YAlyIvEtD7j4QpeBau9o0ngi/EtnlxMaCWDCXgXqpeeKTLjA.', 'admin');


CREATE TABLE IF NOT EXISTS categorias(
    id              int(255) auto_increment not null,
    nombre          varchar(100) not null,
    CONSTRAINT pk_categorias PRIMARY KEY(id)
    )ENGINE=InnoDb DEFAULT CHARSET=utf8 COLLATE=utf8_bin;



CREATE TABLE IF NOT EXISTS productos(
    id              int(255) auto_increment not null,
    categoria_id    int(255) not null,
    nombre          varchar(100) not null,
    descripcion     text,
    precio          float(100,2) not null,
    stock           int(255) not null,
    oferta          varchar(2),
    fecha           date not null,
    imagen          varchar(255),
    CONSTRAINT pk_categorias PRIMARY KEY(id),
    CONSTRAINT fk_producto_categoria FOREIGN KEY(categoria_id) REFERENCES categorias(id)
    )ENGINE=InnoDb DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


CREATE TABLE IF NOT EXISTS pedidos(
    id              int(255) auto_increment not null,
    usuario_id      int(255) not null,
    provincia       varchar(100) not null,
    localidad       varchar(100) not null,
    direccion       varchar(255) not null,
    coste           float(200,2) not null,
    estado          varchar(20) not null,
    fecha           date,
    hora            time,
    CONSTRAINT pk_pedidos PRIMARY KEY(id),
    CONSTRAINT fk_pedido_usuario FOREIGN KEY(usuario_id) REFERENCES usuarios(id)
    )ENGINE=InnoDb DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


CREATE TABLE IF NOT EXISTS lineas_pedidos(
    id              int(255) auto_increment not null,
    pedido_id       int(255) not null,
    producto     varchar(100) not null,
    precio     float not null,
    unidades        int(255) not null,
    CONSTRAINT pk_lineas_pedidos PRIMARY KEY(id),
    CONSTRAINT fk_linea_pedido FOREIGN KEY(pedido_id) REFERENCES pedidos(id)
    )ENGINE=InnoDb DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


-- Insertar categorías
INSERT INTO categorias (nombre) VALUES
                                    ('Hombre'),
                                    ('Mujer'),
                                    ('Niños');

-- Insertar productos para la categoría 'Ropa para Hombres'
INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock, oferta, fecha, imagen) VALUES
                                                                                                    (1, 'Camisa Casual', 'Camisa de manga larga para ocasiones informales.', 29.99, 50, NULL, '2024-01-17', 'camisa_casual.jpg'),
                                                                                                    (1, 'Pantalón Vaquero', 'Pantalón vaquero moderno y cómodo.', 39.99, 30, '10%', '2024-01-18', 'pantalon_vaquero.jpg'),
                                                                                                    (1, 'Suéter de Lana', 'Suéter de lana para mantenerse abrigado en invierno.', 49.99, 20, NULL, '2024-01-19', 'sueter_lana.webp'),
                                                                                                    (1, 'Zapatos de Cuero', 'Zapatos elegantes de cuero para ocasiones especiales.', 59.99, 25, NULL, '2024-01-20', 'zapatos_cuero.jpg');

-- Insertar productos para la categoría 'Ropa para Mujeres'
INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock, oferta, fecha, imagen) VALUES
                                                                                                    (2, 'Vestido de Noche', 'Vestido largo y elegante para eventos formales.', 79.99, 40, NULL, '2024-01-21', 'vestido_noche.webp'),
                                                                                                    (2, 'Blusa Floral', 'Blusa con estampado floral para un look fresco.', 34.99, 35, NULL, '2024-01-22', 'blusa_floral.jpg'),
                                                                                                    (2, 'Falda Plisada', 'Falda plisada de moda para cualquier ocasión.', 44.99, 25, '15%', '2024-01-23', 'falda_plisada.avif'),
                                                                                                    (2, 'Botas Altas', 'Botas altas de cuero para un estilo moderno.', 69.99, 30, NULL, '2024-01-24', 'botas_altas.webp');

-- Insertar productos para la categoría 'Ropa para Niños'
INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock, oferta, fecha, imagen) VALUES
                                                                                                    (3, 'Camiseta Estampada', 'Camiseta divertida con estampado para niños.', 14.99, 60, '20%', '2024-01-25', 'camiseta_estampada.avif'),
                                                                                                    (3, 'Pantalón Deportivo', 'Pantalón cómodo para actividades deportivas.', 24.99, 45, NULL, '2024-01-26', 'pantalon_deportivo.jpg'),
                                                                                                    (3, 'Conjunto de Pijama', 'Conjunto de pijama suave y cómodo para la noche.', 19.99, 55, NULL, '2024-01-27', 'conjunto_pijama.jpg'),
                                                                                                    (3, 'Zapatillas Deportivas', 'Zapatillas deportivas para niños activos.', 29.99, 50, '10%', '2024-01-28', 'zapatillas_deportivas.jpg');


