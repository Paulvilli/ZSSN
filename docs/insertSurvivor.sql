-- Insertar 10 sobrevivientes con sus inventarios
INSERT INTO survivors (nameSorvivor, age, gender, contaminate, latitud, longitud)
VALUES
    ('Juan Pérez', 25, 'M', 0, 1.23, 4.56),
    ('María García', 30, 'F', 0, 2.34, 5.67),
    ('Luis Rodríguez', 22, 'M', 1, 3.45, 6.78),
    ('Ana Martínez', 28, 'F', 0, 4.56, 7.89),
    ('Carlos López', 35, 'M', 1, 5.67, 8.90),
    ('Sofía Ramírez', 40, 'F', 0, 6.78, 9.01),
    ('Pedro Gómez', 32, 'M', 1, 7.89, 1.12),
    ('Laura Torres', 27, 'F', 0, 8.90, 2.23),
    ('Miguel Sánchez', 38, 'M', 1, 9.01, 3.34),
    ('Carmen Flores', 29, 'F', 0, 1.12, 4.45);

-- Inventarios para los sobrevivientes
-- Nota: Asumo que la tabla inventory tiene las columnas id_survivor, id_item, y stock
INSERT INTO inventory (id_survivor, id_item, stock)
VALUES
    (1, 1, 10),  -- Juan Pérez tiene 10 botellas de agua
    (1, 2, 5),   -- Juan Pérez tiene 5 unidades de comida
    (1, 3, 3),   -- Juan Pérez tiene 3 medicamentos
    (1, 4, 20),  -- Juan Pérez tiene 20 municiones

    (2, 1, 8),   -- María García tiene 8 botellas de agua
    (2, 2, 6),   -- María García tiene 6 unidades de comida
    (2, 3, 2),   -- María García tiene 2 medicamentos
    (2, 4, 15),  -- María García tiene 15 municiones
    

    (3, 1, 12), -- Carmen Flores tiene 12 botellas de agua
    (3, 2, 4),  -- Carmen Flores tiene 4 unidades de comida
    (3, 3, 6),  -- Carmen Flores tiene 6 medicamentos
    (3, 4, 18), -- Carmen Flores tiene 18 municiones
    
    (4, 1, 12), -- Carmen Flores tiene 12 botellas de agua
    (4, 2, 4),  -- Carmen Flores tiene 4 unidades de comida
    (4, 3, 6),  -- Carmen Flores tiene 6 medicamentos
    (4, 4, 18), -- Carmen Flores tiene 18 municiones
    
    (5, 1, 12), -- Carmen Flores tiene 12 botellas de agua
    (5, 2, 4),  -- Carmen Flores tiene 4 unidades de comida
    (5, 3, 6),  -- Carmen Flores tiene 6 medicamentos
    (5, 4, 18), -- Carmen Flores tiene 18 municiones
    
    (6, 1, 12), -- Carmen Flores tiene 12 botellas de agua
    (6, 2, 4),  -- Carmen Flores tiene 4 unidades de comida
    (6, 3, 6),  -- Carmen Flores tiene 6 medicamentos
    (6, 4, 18), -- Carmen Flores tiene 18 municiones
    
    (7, 1, 12), -- Carmen Flores tiene 12 botellas de agua
    (7, 2, 4),  -- Carmen Flores tiene 4 unidades de comida
    (7, 3, 6),  -- Carmen Flores tiene 6 medicamentos
    (7, 4, 18), -- Carmen Flores tiene 18 municiones
    
    (8, 1, 12), -- Carmen Flores tiene 12 botellas de agua
    (8, 2, 4),  -- Carmen Flores tiene 4 unidades de comida
    (8, 3, 6),  -- Carmen Flores tiene 6 medicamentos
    (8, 4, 18), -- Carmen Flores tiene 18 municiones

    (9, 1, 12), -- Carmen Flores tiene 12 botellas de agua
    (9, 2, 4),  -- Carmen Flores tiene 4 unidades de comida
    (9, 3, 6),  -- Carmen Flores tiene 6 medicamentos
    (9, 4, 18), -- Carmen Flores tiene 18 municiones

    (10, 1, 12), -- Carmen Flores tiene 12 botellas de agua
    (10, 2, 4),  -- Carmen Flores tiene 4 unidades de comida
    (10, 3, 6),  -- Carmen Flores tiene 6 medicamentos
    (10, 4, 18); -- Carmen Flores tiene 18 municiones
