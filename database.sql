CREATE DATABASE IF NOT EXISTS proyecto-laravel;
USE proyecto-laravel;

CREATE TABLE IF NOT EXISTS users(
    id             int(11) auto_increment not null,
    role           varchar(20),
    name           varchar(100),
    surname        varchar(200),
    nick           varchar(255),
    email          varchar(255),
    password       varchar(255), 
    image          varchar(255),
    created_at     datetime,
    updated_at     datetime,
    remember_token varchar(255),
    CONSTRAINT pk_users PRIMARY KEY(id)
)ENGINE=InnoDB;

INSERT INTO users VALUES(NULL, 'user', 'Jesús Iván', 'Domínguez Torres', 'jidominguez', 'domingueztorres.ji@gmail.com', '123456', NULL, CURTIME(), CURTIME(), NULL);
INSERT INTO users VALUES(NULL, 'user', 'Anaclara María del Mar', 'Jonguitud Infante', 'anaclara', 'anaclara_jomguitud@hotmail.com', '123456', NULL, CURTIME(), CURTIME(), NULL);
INSERT INTO users VALUES(NULL, 'user', 'Zaira Lucía', 'Álvarez Suárez', 'zaira', 'zairalu@gmail.com', '123456', NULL, CURTIME(), CURTIME(), NULL);

CREATE TABLE IF NOT EXISTS images(
    id          int(11) auto_increment not null,
    user_id     int(11),
    image_path  varchar(100),
    description varchar(200),
    created_at  datetime,
    updated_at  datetime,
    CONSTRAINT pk_images PRIMARY KEY(id),
    CONSTRAINT fk_images_users FOREIGN KEY(user_id) REFERENCES users(id)
)ENGINE=InnoDB;

INSERT INTO images VALUES(NULL, 1, 'test.jpg', 'Cogiendo con Anaclara', CURTIME(), CURTIME());
INSERT INTO images VALUES(NULL, 1, 'playa.jpg', 'Cogiendo con Zaira', CURTIME(), CURTIME());
INSERT INTO images VALUES(NULL, 1, 'lago.jpg', 'Cogiendo con Zaira y Anaclara', CURTIME(), CURTIME());
INSERT INTO images VALUES(NULL, 2, 'conivan.jpg', 'Cogiendo con Iván', CURTIME(), CURTIME());
INSERT INTO images VALUES(NULL, 2, 'conzaira.jpg', 'Cogiendo con Zaira', CURTIME(), CURTIME());
INSERT INTO images VALUES(NULL, 2, 'trioconivanyzaira.jpg', 'Cogiendo con Iván y Zaira', CURTIME(), CURTIME());
INSERT INTO images VALUES(NULL, 3, 'follandoconivan.jpg', 'Cogiendo con Iván', CURTIME(), CURTIME());
INSERT INTO images VALUES(NULL, 3, 'conanaclara.jpg', 'Cogiendo con Anaclara', CURTIME(), CURTIME());
INSERT INTO images VALUES(NULL, 3, 'trioconivanyanaclara.jpg', 'Cogiendo con Iván y Anaclara', CURTIME(), CURTIME());

CREATE TABLE IF NOT EXISTS comments(
    id          int(11) auto_increment not null,
    user_id     int(11),
    image_id    int(11),
    content     text,
    created_at  datetime,
    updated_at  datetime,
    CONSTRAINT pk_comments PRIMARY KEY(id),
    CONSTRAINT fk_comments_users FOREIGN KEY(user_id) REFERENCES users(id),
    CONSTRAINT fk_comments_images FOREIGN KEY(image_id) REFERENCES images(id)
)ENGINE=InnoDB;

INSERT INTO comments VALUES(NULL, 1, 3, 'Que ricas se ven chupandome la verga, Zaira y Anaclara!', CURTIME(), CURTIME());
INSERT INTO comments VALUES(NULL, 2, 6, 'Que rico nos la metes Iván!', CURTIME(), CURTIME());
INSERT INTO comments VALUES(NULL, 3, 9, 'Nos comimos tu leche deliciosa! y que ricas tetas tienes Anaclara!', CURTIME(), CURTIME());

CREATE TABLE IF NOT EXISTS likes(
    id          int(11) auto_increment not null,
    user_id     int(11),
    image_id    int(11),
    created_at  datetime,
    updated_at  datetime,
    CONSTRAINT pk_likes PRIMARY KEY(id),
    CONSTRAINT fk_likes_users FOREIGN KEY(user_id) REFERENCES users(id),
    CONSTRAINT fk_likes_images FOREIGN KEY(image_id) REFERENCES images(id)
)ENGINE=InnoDB;

INSERT INTO likes VALUES(NULL, 1, 2, CURTIME(), CURTIME());
INSERT INTO likes VALUES(NULL, 2, 7, CURTIME(), CURTIME());
INSERT INTO likes VALUES(NULL, 3, 8, CURTIME(), CURTIME());
INSERT INTO likes VALUES(NULL, 1, 4, CURTIME(), CURTIME());
INSERT INTO likes VALUES(NULL, 2, 1, CURTIME(), CURTIME());
INSERT INTO likes VALUES(NULL, 3, 9, CURTIME(), CURTIME());