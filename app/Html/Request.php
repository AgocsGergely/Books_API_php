<?php

namespace App\Html;


use App\Repositories\BaseRepository;
/*use App\Repositories\CountyRepository;
use App\Repositories\CityRepository;

*/

use App\Repositories\BookRepository;
use App\Repositories\AuthorRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\PublisherRepository;
use App\Repositories\SeriesRepository;

/**
 * @api {get} /counties Get list of counties
 * @apiName index
 * @apiGroup Counties
 * @apiVersion 1.0.0
 * 
 * @apiSuccess {Object[]} counties List of counties.
 * @apiSuccess {Number} counties.id County unique ID.
 * @apiSuccess {String} counties.name Name of the County.
 * 
 * @apisuccessExample {json} Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "data": [
 *         {"id":2,"name":"B\u00e1cs-Kiskun"},
 *         {"id":3,"name":"Baranya"},
 *        ... ]
 *     }
 * @apiErrorExample {json} Error-Response:
 *    HTTP/1.1 400 Bad Request
 *   { "error": "Route not allowed" }
 */

/**
 * @api {get} /cities Get a cities' data
 * @apiName index
 * @apiGroup Cities
 * @apiVersion 1.0.0
 * 
 * @apiSuccess {Object[]} cities List of cities.
 * @apiSuccess {Number} cities.id City unique ID.
 * @apiSuccess {String} cities.name Name of the City.
 * @apiSuccess {Number} cities.id_county ID of the County.
 * 
 * @apisuccessExample {json} Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "data": [
 *         "code": 200,
 *          "0": {
 *          "id": "1",
 *          "zip_code": "8128",
 *          "name": "Aba",
 *          "id_county": "7"
 *      },
 *          "1": {
 *          "id": "2",
 *          "zip_code": "8127",
 *          "name": "Aba",
 *          "id_county": "7"
 *      },
 *        ... ]
 *     }
 * @apiErrorExample {json} Error-Response:
 *    HTTP/1.1 400 Bad Request
 *   { "error": "Route not allowed" }
 */

class Request
{
   static array $acceptedRoutes = [
    'GET' => [
        '/books',
        '/books/{id}',
        '/authors',
        '/authors/{id}',
        '/authors/{id}/books',
        '/categories',
        '/publishers',
        '/series',
        '/categories/{id}/books',
        '/categories/{id}'
    ],
    'POST' => [
        '/books',
        '/authors',
        '/categories',
        '/publishers',
        '/series',
    ],
    'PUT' => [
        '/books/{id}',
        '/authors/{id}',
        '/categories/{id}',
        '/publishers/{id}',
        '/series/{id}',
    ],
    'DELETE' => [
        '/books/{id}',
        '/authors/{id}',
        '/categories/{id}',
        '/publishers/{id}',
        '/series/{id}',
    ],
];


    static function handle()
    {
        // Lekérjük a HTTP metódust és az URI-t
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        // Ellenőrizzük, hogy a kérés engedélyezett route-ra mutat-e
        if (!self::isRouteAllowed($requestMethod, $requestUri, self::$acceptedRoutes)) {
            return Response::error('Route not allowed');
        }

        // Feldolgozzuk az URI-t és az adatokat
        $requestData = self::getRequestData();
        $arrUri = self::requestUriToArray($_SERVER['REQUEST_URI']);
        $resourceName = self::getResourceName($arrUri);
        $resourceId = self::getResourceId($arrUri);
        $childResourceName = self::getChildResourceName($arrUri);

        // A metódus alapján meghívjuk a megfelelő függvényt
        switch ($requestMethod){
            case "POST":
                self::postRequest($resourceName, $requestData);
                break;
            case "PUT":
                self::putRequest($resourceName, $resourceId, $requestData);
                break;
            case "GET":
                self::getRequest($resourceName, $resourceId, $childResourceName);
                break;
            case "DELETE":
                self::deleteRequest($resourceName, $resourceId);
                break;
            default:
                echo 'Unknown request type';
                break;
        }
    }

    private static function getResourceName($arrUri) {
        return $arrUri['resourceName'];
    }
    private static function getResourceId($arrUri) {
        return $arrUri['resourceId'];
    }
    private static function getChildResourceName($arrUri) {
        return $arrUri['childResourceName'];
    }

    private static function getRequestData(): ?array
    {
        return json_decode(file_get_contents("php://input"), true);
    }

    private static function requestUriToArray($uri): array
    {
        $arrUri = explode("/", trim($uri, "/"));
        return [
            'resourceName' => $arrUri[0] ?? null,
            'resourceId' => !empty($arrUri[1]) ? (int)$arrUri[1] :  null,
            'childResourceName' => $arrUri[2] ?? null,
            'childResourceId' => !empty($arrUri[3]) ? (int)$arrUri[3] : null,
        ];
    }

    private static function isRouteMatch($route, $uri): bool
    {
        $routeParts = explode('/', trim($route, '/'));
        $uriParts = explode('/', trim($uri, '/'));

        if (count($routeParts) !== count($uriParts)) {
            return false;
        }

        foreach ($routeParts as $index => $routePart) {
            if (preg_match('/^{.*}$/', $routePart)) {
                continue; // Paraméter placeholder, bármilyen értéket elfogad
            }
            if ($routePart !== $uriParts[$index]) {
                return false;
            }
        }

        return true;
    }

    private static function isRouteAllowed($method, $uri, $routes): bool
    {
        if (!isset($routes[$method])) {
            return false;
        }

        foreach ($routes[$method] as $route) {
            if (self::isRouteMatch($route, $uri)) {
                return true;
            }
        }

        return false;
    }

    private static function getRepository($resourceName): ?BaseRepository
{
    switch ($resourceName) {
        case 'books':
            return new BookRepository();
        case 'authors':
            return new AuthorRepository();
        case 'categories':
            return new CategoryRepository();
        case 'publishers':
            return new PublisherRepository();
        case 'series':
            return new SeriesRepository();
        default:
            return null;
    }
}


    private static function postRequest($resourceName, $requestData)
    {
        $repository = self::getRepository($resourceName);
        if (!$repository) {
            return Response::error("Hiba 400-as");
        }

        $newId = $repository->create($requestData);
        $code = 400; // Bad Request alapértelmezés
        if ($newId) {
            $code = 201; // Created
        }

        Response::created(['id' => $newId]);
    }

    private static function deleteRequest($resourceName, $resourceId)
    {
        $repository = self::getRepository($resourceName);
        $result = $repository->delete($resourceId);
        if ($result) {
            $code = 204;
        }
        Response::deleted();
    }

    private static function getRequest($resourceName, $resourceId = null, $childResourceName = null)
    {
        if ($childResourceName) {
            $repository = self::getRepository($childResourceName);
            if ($resourceId) {
                // Példa: /counties/{id}/cities
                if ($childResourceName === 'books' && $resourceName === 'authors') {
                    $entities = $repository->getByAuthor($resourceId);
                    Response::ok($entities);
                    return;
                }
                if ($childResourceName === 'books' && $resourceName === 'categories') {
                    $entities = $repository->getByCategory($resourceId);
                    Response::ok($entities);
                    return;
                }
            }
        }
        $repository = self::getRepository($resourceName);
        if ($resourceId) {
            $entity = $repository->find($resourceId);
            if (!$entity) {
                Response::error("error 404", 404);
                return;
            }
            Response::ok($entity);
            return;
        }
        $entities = $repository->getAll();
        Response::ok($entities);
    }

    private static function putRequest($resourceName, $resourceId, $requestData)
    {
        $repository = self::getRepository($resourceName);
        $code = 404;
        $entity = $repository->find($resourceId);
        if ($entity) {
            $data = [];
            foreach ($requestData as $key => $value) {
                $data[$key] = $value;
            }
            $result = $repository->update($resourceId, $data);
            if ($result) {
                $code = 202;
            }
        }
        Response::updated("updated", $code);
    }
}