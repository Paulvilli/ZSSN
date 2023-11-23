DROP DATABASE IF EXISTS ZSSN;
CREATE DATABASE ZSSN;
USE ZSSN;
DROP TABLE IF EXISTS `survivors`;
DROP TABLE IF EXISTS `items`;
DROP TABLE IF EXISTS `location_log`;
DROP TABLE IF EXISTS `inventory`;
DROP TABLE IF EXISTS `trade_log`;


CREATE TABLE survivors (
    id_survivor               INT                      NOT NULL      AUTO_INCREMENT,
    nameSorvivor              VARCHAR(255)             NOT NULL,
    age                       TINYINT                  NOT NULL,
    gender                    CHAR(1)                  NOT NULL,   -- M: Masculino F: Femenino
    contaminate               TINYINT                  NOT NULL      DEFAULT(0),
    latitud                   FLOAT                    NOT NULL,
    longitud                  FLOAT                    NOT NULL,
    create_time               TIMESTAMP                NOT NULL      DEFAULT CURRENT_TIMESTAMP, 
    update_time               TIMESTAMP                NOT NULL      DEFAULT CURRENT_TIMESTAMP   ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY              (id_survivor)
);

CREATE TABLE items (
    id_item                   INT                      NOT NULL      AUTO_INCREMENT,
    nombre                    VARCHAR(50)              NOT NULL,
    points                    INT                      NOT NULL,
    create_time               TIMESTAMP                NOT NULL      DEFAULT CURRENT_TIMESTAMP, 
    update_time               TIMESTAMP                NOT NULL      DEFAULT CURRENT_TIMESTAMP   ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY               (id_item)
);

INSERT INTO items (id_item, nombre, points) VALUES
    (1, 'Water', 4),
    (2, 'Food', 3),
    (3, 'Medication', 2),
    (4, 'Ammunition', 1);

CREATE TABLE location_log (
    id_location_log           INT                      NOT NULL      AUTO_INCREMENT,
    id_survivor               INT                      NOT NULL,
    latitud                   FLOAT                    NOT NULL,
    longitud                  FLOAT                    NOT NULL,
    create_time               TIMESTAMP                NOT NULL      DEFAULT CURRENT_TIMESTAMP, 
    update_time               TIMESTAMP                NOT NULL      DEFAULT CURRENT_TIMESTAMP   ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY               (id_location_log),
    FOREIGN KEY               (id_survivor)         REFERENCES       survivors(id_survivor)
);

CREATE TABLE inventory (
    id_survivor               INT                      NOT NULL,
    id_item                   INT                      NOT NULL,
    stock                     INT                      NOT NULL,
    create_time               TIMESTAMP                NOT NULL      DEFAULT CURRENT_TIMESTAMP, 
    update_time               TIMESTAMP                NOT NULL      DEFAULT CURRENT_TIMESTAMP   ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY               (id_survivor, id_item),
    FOREIGN KEY               (id_survivor)         REFERENCES       survivors(id_survivor),
    FOREIGN KEY               (id_item)             REFERENCES       items(id_item)
);

CREATE TABLE trade_log (
    id_survivor               INT                      NOT NULL,
    id_survivor_trade         INT                      NOT NULL,
    id_item                   INT                      NOT NULL,
    lot                       INT                      NOT NULL,
    create_time               TIMESTAMP                NOT NULL      DEFAULT CURRENT_TIMESTAMP, 
    update_time               TIMESTAMP                NOT NULL      DEFAULT CURRENT_TIMESTAMP   ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY               (id_survivor)         REFERENCES       survivors(id_survivor),
    FOREIGN KEY               (id_survivor_trade)         REFERENCES       survivors(id_survivor),
    FOREIGN KEY               (id_item)             REFERENCES       items(id_item)
);
