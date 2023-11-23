<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

$app = new \Slim\App;

// GET all survivors
$app->get('/api/survivors', function (Request $request, Response $response) {
  // Definición de la ruta: 
  // - Método HTTP: GET
  // - Ruta: /api/survivors

  $sql = "SELECT * FROM survivors";
  // Consulta SQL para seleccionar todos los registros de la tabla 'survivors'

  try {
    $db = new db();
    $db = $db->conectDB();
    // Crear y establecer la conexión a la base de datos utilizando la clase 'db'

    $resultado = $db->query($sql);
    // Ejecutar la consulta SQL

    $survivors = $resultado->fetchAll(PDO::FETCH_OBJ);
    // Obtener todos los resultados de la consulta como objetos y almacenarlos en la variable '$survivors'

    // Devolver respuesta JSON
    $response->getBody()->write(json_encode($survivors));
    // Escribir la respuesta en el cuerpo de la respuesta HTTP en formato JSON

    return $response->withHeader('Content-Type', 'application/json');
    // Devolver la respuesta HTTP con la cabecera 'Content-Type' configurada como 'application/json'
  } catch (PDOException $e) {
    // Capturar excepciones relacionadas con la base de datos (por ejemplo, errores de conexión o consulta)

    // Devolver respuesta de error JSON
    $response->getBody()->write(json_encode(["error" => ["text" => $e->getMessage()]]));
    // Escribir un mensaje de error en el cuerpo de la respuesta HTTP en formato JSON

    return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
    // Devolver la respuesta HTTP con un código de estado 500 (Error interno del servidor) y la cabecera 'Content-Type' configurada como 'application/json'
  }
});


// report of Average amount of each kind of resource by survivor 
$app->get('/api/items/average', function (Request $request, Response $response) {
  // Definición de la ruta:
  // - Método HTTP: GET
  // - Ruta: /api/items/average
  $sql = "SELECT
            i.id_item,
            i.nombre,
            AVG(inv.stock) AS promedio_stock
          FROM
            items i
          JOIN
            inventory inv ON i.id_item = inv.id_item
          GROUP BY
            i.id_item, i.nombre;
  ";
  // Consulta SQL para calcular el promedio de la cantidad de cada tipo de recurso por superviviente
  try {
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->query($sql);
    $survivors = $resultado->fetchAll(PDO::FETCH_OBJ);
    // Devolver respuesta JSON
    $response->getBody()->write(json_encode($survivors));
    return $response->withHeader('Content-Type', 'application/json');
  } catch (PDOException $e) {
    // Devolver respuesta de error JSON
    $response->getBody()->write(json_encode(["error" => ["text" => $e->getMessage()]]));
    return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
  }
});

// report of Points lost because of infected survivors 
$app->get('/api/items/points-lost', function (Request $request, Response $response) {
  $sql = "SELECT
            SUM(i.points * inv.stock) AS percentages
          FROM
            survivors s
          JOIN
            inventory inv ON s.id_survivor = inv.id_survivor
          JOIN
            items i ON inv.id_item = i.id_item
          WHERE
            s.contaminate = 1;
  ";
  // Consulta SQL para calcular los puntos perdidos por infectados
  try {
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->query($sql);
    $survivors = $resultado->fetchAll(PDO::FETCH_OBJ);
    // Devolver respuesta JSON
    $response->getBody()->write(json_encode($survivors));
    return $response->withHeader('Content-Type', 'application/json');
  } catch (PDOException $e) {
    // Devolver respuesta de error JSON
    $response->getBody()->write(json_encode(["error" => ["text" => $e->getMessage()]]));
    return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
  }
});

// GET Percentage survivors 
$app->get('/api/survivors/percentage', function (Request $request, Response $response) {
  $sql = "SELECT 
            (COUNT(*) / (SELECT COUNT(*) FROM survivors)) * 100 AS percentages
          FROM survivors
          WHERE contaminate = 0;";
  // Consulta SQL para calcular el porcentaje de superviviente
  try {
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->query($sql);
    $survivors = $resultado->fetchAll(PDO::FETCH_OBJ);
    // Devolver respuesta JSON
    $response->getBody()->write(json_encode($survivors));
    return $response->withHeader('Content-Type', 'application/json');
  } catch (PDOException $e) {
    // Devolver respuesta de error JSON
    $response->getBody()->write(json_encode(["error" => ["text" => $e->getMessage()]]));
    return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
  }
});

// GET Percentage infected 
$app->get('/api/infected/percentage', function (Request $request, Response $response) {
  $sql = "SELECT 
          (COUNT(*) / (SELECT COUNT(*) FROM survivors)) * 100 AS percentages
        FROM survivors
        WHERE contaminate = 1;
";
  // Consulta SQL para calcular el porcentaje de infectados
  try {
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->query($sql);
    $survivors = $resultado->fetchAll(PDO::FETCH_OBJ);
    // Devolver respuesta JSON
    $response->getBody()->write(json_encode($survivors));
    return $response->withHeader('Content-Type', 'application/json');
  } catch (PDOException $e) {
    // Devolver respuesta de error JSON
    $response->getBody()->write(json_encode(["error" => ["text" => $e->getMessage()]]));
    return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
  }
});

// GET Recueperar survivors por ID 
$app->get('/api/survivors/{id}', function (Request $request, Response $response) {
  $id_survivor = $request->getAttribute('id');
  $sql = "SELECT * FROM survivors WHERE id_survivor = $id_survivor";
  try {
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->query($sql);

    if ($resultado->rowCount() > 0) {
      $survivor = $resultado->fetch(PDO::FETCH_OBJ);
      // Devolver respuesta JSON
      $response->getBody()->write(json_encode($survivor));
      return $response->withHeader('Content-Type', 'application/json');
    } else {
      echo json_encode("No existen cliente en la BBDD con este ID.");
    }
    $resultado = null;
    $db = null;
  } catch (PDOException $e) {
    // Devolver respuesta de error JSON
    $response->getBody()->write(json_encode(["error" => ["text" => $e->getMessage()]]));
    return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
  }
});

// POST add survivor 
$app->post('/api/survivors/add', function (Request $request, Response $response) {
  // Definición de la ruta:
  // - Método HTTP: POST
  // - Ruta: /api/survivors/add

  /* body:
  {
    "nameSorvivor": "Marco",
    "age": "28",
    "gender": "M",
    "contaminate": "0",
    "latitud": "7.15",
    "longitud": "8.55",
    "inventory": [
      { "item": 1, "stock": 4 },
      { "item": 2, "stock": 1 },
      { "item": 3, "stock": 20 },
      { "item": 4, "stock": 6 }
    ]
  }
  */

  // Obtener los parámetros de la solicitud
  $nameSorvivor = $request->getParam('nameSorvivor');
  $age = $request->getParam('age');
  $gender = $request->getParam('gender');
  $contaminate = $request->getParam('contaminate');
  $latitud = $request->getParam('latitud');
  $longitud = $request->getParam('longitud');
  $inventory = $request->getParam('inventory');
  // Parámetros necesarios para agregar un sobreviviente y su inventario

  // Consulta SQL para insertar un sobreviviente
  $sql = "INSERT INTO survivors (nameSorvivor, age, gender, contaminate, latitud, longitud) VALUES 
            (:nameSorvivor, :age, :gender, :contaminate, :latitud, :longitud)";

  // Consulta SQL para insertar el inventario del sobreviviente
  $sql2 = "INSERT INTO inventory (id_survivor, id_item, stock) VALUES 
            (:id_survivor, :id_item, :stock)";

  try {
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->prepare($sql);

    $resultado->bindParam(':nameSorvivor', $nameSorvivor);
    $resultado->bindParam(':age', $age);
    $resultado->bindParam(':gender', $gender);
    $resultado->bindParam(':contaminate', $contaminate);
    $resultado->bindParam(':latitud', $latitud);
    $resultado->bindParam(':longitud', $longitud);
    // Vincular los parámetros de la consulta SQL con los valores obtenidos de la solicitud
    $resultado->execute();

    $id_survivor = $db->lastInsertId();
    // Obtener el último id insertado del sobreviviente

    foreach ($inventory as $item) {
      // Bucle para insertar todos los ítems en el inventario del sobreviviente
      $resultado2 = $db->prepare($sql2);
      $resultado2->bindParam(':id_survivor', $id_survivor);
      $resultado2->bindParam(':id_item', $item["item"]);
      $resultado2->bindParam(':stock', $item["stock"]);
      $resultado2->execute();
    }

    // Construir la respuesta sin imprimir nada
    $response->getBody()->write(json_encode(["message" => "Add Survivor."]));
    return $response->withHeader('Content-Type', 'application/json');
  } catch (PDOException $e) {
    // Construir la respuesta de error sin imprimir nada
    $response->getBody()->write(json_encode(["error" => ["text" => $e->getMessage()]]));
    return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
  }
});


// PUT update location sorvivor 
$app->put('/api/survivors/update/{id_survivor}/location', function (Request $request, Response $response) {
  $id_survivor = $request->getAttribute('id_survivor');
  $latitud = $request->getParam('latitud');
  $longitud = $request->getParam('longitud');

  /* body:
    {
      "latitud": 2.35,
      "longitud": 3.55
    }
  */

  $sur = "SELECT * FROM survivors WHERE id_survivor = $id_survivor AND contaminate = 0";

  $sql = "UPDATE survivors SET
          latitud = :latitud, 
          longitud = :longitud
        WHERE id_survivor = $id_survivor";

  $location_log = "INSERT INTO location_log (id_survivor, latitud, longitud) VALUES 
                          (:id_survivor, :latitud, :longitud)";

  try {
    $db = new db();
    $db = $db->conectDB();

    // Obtener información del sobreviviente
    $resultado = $db->query($sur);
    $survivor = $resultado->fetch(PDO::FETCH_ASSOC);

    echo json_decode($survivor);

    if ($survivor) {
      // Insertar en el historial de ubicaciones antes de la actualización
      $location = $db->prepare($location_log);
      $location->bindParam(':id_survivor', $survivor["id_survivor"]);
      $location->bindParam(':latitud', $survivor["latitud"]);
      $location->bindParam(':longitud', $survivor["longitud"]);
      $location->execute();

      // Actualizar la ubicación del sobreviviente
      $resultado = $db->prepare($sql);
      $resultado->bindParam(':latitud', $latitud);
      $resultado->bindParam(':longitud', $longitud);
      $resultado->execute();

      // Devolver respuesta JSON
      $response->getBody()->write(json_encode("Update location."));
      return $response->withHeader('Content-Type', 'application/json');
    } else {
      // El sobreviviente no existe
      $response->getBody()->write(json_encode(["error" => ["text" => "Survivor not found."]]));
      return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
    }
  } catch (PDOException $e) {
    // Devolver respuesta de error JSON
    $response->getBody()->write(json_encode(["error" => ["text" => $e->getMessage()]]));
    return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
  }
});

// PUT update location sorvivor 
$app->put('/api/survivors/update/{id_survivor}/contaminate', function (Request $request, Response $response) {
  $id_survivor = $request->getAttribute('id_survivor');

  $contaminate = "UPDATE survivors SET contaminate = 1 WHERE id_survivor = :id_survivor";

  $sur = "SELECT * FROM survivors WHERE id_survivor = $id_survivor";

  $sqlSelect = "SELECT
                id_survivor,        -- Identificador único del sobreviviente
                contaminate,        -- Estado de contaminación del sobreviviente (0 o 1)
                latitud,            -- Latitud de la ubicación del sobreviviente
                longitud,           -- Longitud de la ubicación del sobreviviente
                (6371 * acos(
                    cos(radians(:nuevaLatitud)) * cos(radians(latitud)) *
                    cos(radians(longitud) - radians(:nuevaLongitud)) +
                    sin(radians(:nuevaLatitud)) * sin(radians(latitud))
                )) AS DISTANCE       -- Distancia en kilómetros desde las coordenadas dadas
              FROM
                survivors s         -- Alias 's' para la tabla 'survivors'
              WHERE
                contaminate = 0    -- Filtra los sobrevivientes no contaminados
                AND (
                    SELECT COUNT(*)
                    FROM survivors
                    WHERE contaminate = 1
                        AND (6371 * acos(
                            cos(radians(:nuevaLatitud)) * cos(radians(s.latitud)) *
                            cos(radians(s.longitud) - radians(:nuevaLongitud)) +
                            sin(radians(:nuevaLatitud)) * sin(radians(s.latitud))
                        )) < 2      -- Cuenta el número de sobrevivientes contaminados dentro de 2 km
                ) >= 3               -- Filtra aquellos con al menos 3 sobrevivientes contaminados cercanos
              ORDER BY
                DISTANCE;           -- Ordena los resultados por distancia
    ";

  try {
    $db = new db();
    $db = $db->conectDB();
    // Update contaminate
    $resultado = $db->prepare($contaminate);
    $resultado->bindParam(':id_survivor', $id_survivor);
    $resultado->execute();

    // Update contaminate
    $resultado = $db->prepare($sur);
    $resultado->execute();
    $survivor = $resultado->fetch(PDO::FETCH_OBJ);

    // Preparar la declaración
    $stmtSelect = $db->prepare($sqlSelect);

    // Vincular los nuevos valores de latitud y longitud
    $stmtSelect->bindParam(':nuevaLatitud', $survivor->latitud, PDO::PARAM_STR);
    $stmtSelect->bindParam(':nuevaLongitud', $survivor->longitud, PDO::PARAM_STR);

    // Ejecutar la consulta SELECT
    $stmtSelect->execute();

    // Obtener los resultados
    $results = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);

    //cambiar los que esten cercas 
    foreach ($results as $cercas) {
      $resultado = $db->prepare($contaminate);
      $resultado->bindParam(':id_survivor', $cercas['id_survivor'], PDO::PARAM_INT);
      $resultado->execute();
    }

    // Devolver respuesta JSON
    $response->getBody()->write(json_encode($results));
    return $response->withHeader('Content-Type', 'application/json');
  } catch (PDOException $e) {
    // Devolver respuesta de error JSON
    $response->getBody()->write(json_encode(["error" => ["text" => $e->getMessage()]]));
    return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
  }
});


// PUT update location sorvivor 
$app->put('/api/survivors/trade/{id_survivor1}/by/{id_survivor2}', function (Request $request, Response $response) {
  // Definición de la ruta:
  // - Método HTTP: PUT
  // - Ruta: /api/survivors/trade/{id_survivor1}/by/{id_survivor2}
  //   (por ejemplo, /api/survivors/trade/1/by/2)
  $id_survivor1 = $request->getAttribute('id_survivor1');
  $id_survivor2 = $request->getAttribute('id_survivor2');
  $trade1 = $request->getParam('trade1');
  $trade2 = $request->getParam('trade2');

  /* Body 
    {
    "trade1": [
        {"item": 1, "lot": 1,"points": 4},
        {"item": 4, "lot": 2,"points": 1}
    ],
    "trade2": [
        {"item": 2, "lot": 1,"points": 3},
        {"item": 4, "lot": 3,"points": 1}
    ]
    }
  */

  // Consulta SQL para verificar si ambos sobrevivientes existen y no están contaminados
  $sur = "SELECT * FROM survivors WHERE (id_survivor = $id_survivor1 OR id_survivor = $id_survivor2) AND contaminate = 0";

  // Consultas SQL para actualizar el inventario de los sobrevivientes durante el intercambio
  $plus = "UPDATE inventory 
              SET stock = stock + :lot
              WHERE id_survivor = :id_survivor 
              AND id_item = :id_item";

  $minus = "UPDATE inventory 
          SET stock = stock - :lot
          WHERE id_survivor = :id_survivor_trade 
          AND id_item = :id_item";

  // Consulta SQL para registrar el intercambio en el historial
  $sql = "INSERT INTO trade_log (id_survivor, id_survivor_trade, id_item, lot) VALUES 
            (:id_survivor, :id_survivor_trade, :id_item, :lot)";


  try {
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->prepare($sur);
    $resultado->execute();
    $survivor = $resultado->fetchAll(PDO::FETCH_OBJ);

    // Verificar si ambos sobrevivientes existen y no están contaminados
    if (count($survivor) > 1) {
      // Calcular el total de puntos para el intercambio 1
      $totalPointsTrade1 = 0;
      foreach ($trade1 as $key => $trade) {
        $totalPointsTrade1 += $trade["lot"] * $trade["points"];
        $trade1[$key]["id_survivor"] = $id_survivor1;
        $trade1[$key]["id_survivor_trade"] = $id_survivor2;
      }

      // Calcular el total de puntos para el intercambio 2
      $totalPointsTrade2 = 0;
      foreach ($trade2 as $key => $trade) {
        $totalPointsTrade2 += $trade["lot"] * $trade["points"];
        $trade2[$key]["id_survivor"] = $id_survivor2;
        $trade2[$key]["id_survivor_trade"] = $id_survivor1;
      }

      if ($totalPointsTrade1 != $totalPointsTrade2) {
        // Los puntos de los ítems no son equivalentes
        $response->getBody()->write(json_encode("the points of the items are not equivalent"));
        return $response->withHeader('Content-Type', 'application/json');
      }
      // Combinar los intercambios en un array
      $allTrade = array_merge($trade1, $trade2);

      foreach ($allTrade as $trade) {
        // Agregar ítems al inventario del receptor
        $addItem = $db->prepare($plus);
        $addItem->bindParam(':id_survivor', $trade['id_survivor']);
        $addItem->bindParam(':id_item', $trade['item']);
        $addItem->bindParam(':lot', $trade['lot']);
        $addItem->execute();

        // Quitar ítems del inventario del donante
        $lessItem = $db->prepare($minus);
        $lessItem->bindParam(':id_survivor_trade', $trade['id_survivor_trade']);
        $lessItem->bindParam(':id_item', $trade['item']);
        $lessItem->bindParam(':lot', $trade['lot']);
        $lessItem->execute();

        // Registrar el intercambio en el historial
        $log = $db->prepare($sql);
        $log->bindParam(':id_survivor', $trade['id_survivor']);
        $log->bindParam(':id_survivor_trade', $trade['id_survivor_trade']);
        $log->bindParam(':id_item', $trade['item']);
        $log->bindParam(':lot', $trade['lot']);
        $log->execute();
      }

      // Devolver respuesta JSON
      $response->getBody()->write("trade is succefull");
      return $response->withHeader('Content-Type', 'application/json');
    } else {
      // Devolver respuesta JSON
      $response->getBody()->write(json_encode("One survivor is infect"));
      return $response->withHeader('Content-Type', 'application/json');
    }
  } catch (PDOException $e) {
    // Devolver respuesta de error JSON
    $response->getBody()->write(json_encode(["error" => ["text" => $e->getMessage()]]));
    return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
  }
});
