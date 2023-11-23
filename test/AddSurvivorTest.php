<?php

// use PHPUnit\Framework\TestCase;
// use Slim\App;
// use Slim\Http\Environment;
// use Slim\Http\Request;
// use Slim\Http\Response;
// use Slim\Container;

// class AddSurvivorTest extends TestCase
// {
//     protected $app;

//     protected function setUp(): void
//     {
//         // Crear un contenedor para gestionar las dependencias
//         $container = new Container();

//         // Configurar la aplicación con el contenedor y cualquier dependencia necesaria
//         $this->app = new App($container);

//         // Incluir la ruta que deseas probar
//         require_once 'C:\proyects\ZSSN\src\rutas\survivors.php';
//     }


//     public function testAddSurvivor(): void
//     {
//         // Crear un entorno de solicitud de prueba
//         $environment = Environment::mock([
//             'REQUEST_METHOD' => 'POST',
//             'REQUEST_URI' => 'http://localhost:3002/api/survivors/add',
//             'CONTENT_TYPE' => 'application/json',
//         ]);

//         // Crear una solicitud con datos de ejemplo
//         $request = Request::createFromEnvironment($environment);
//         $request = $request->withParsedBody([
//             'nameSorvivor' => 'Juan',
//             'age' => 28,
//             'gender' => 'M',
//             'contaminate' => 0,
//             'latitud' => 2.15,
//             'longitud' => 3.55,
//             'inventory' => [
//                 ['item' => 1, 'stock' => 4],
//                 ['item' => 2, 'stock' => 1],
//                 ['item' => 4, 'stock' => 6],
//             ],
//         ]);

//         // Crear una respuesta de prueba
//         $response = new Response();

//         // Ejecutar la aplicación con la solicitud y respuesta de prueba
//         $response = $this->app->process($request, $response);

//         // Verificar que la respuesta tenga el código de estado esperado (200 en este caso)
//         $this->assertSame(200, $response->getStatusCode());

//         // Verificar que la respuesta tenga el contenido esperado
//         $this->assertJsonStringEqualsJsonString('{"message": "Add Survivor."}', $response->getBody()->__toString());
//     }
// }
