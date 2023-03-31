<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write("Welcome to the ToDo API. Please use provided endpoints in docs");
    return $response;
});

$app->add(new Tuupola\Middleware\HttpBasicAuthentication([
    'path' => ['/todo', '/todos'],
    'secure' => false,
    "users" => [
        $_ENV['API_USER'] => $_ENV['API_PASS']
    ],
    'error' => function ($response, $arguments) {
        $data = [];
        $data['message'] = $arguments['message'];
        $response->getBody()->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        return $response->withStatus(403)->withHeader('Content-Type', 'application/json');
    }
]));


/* 
* GET all the ToDo Items 
*/
$app->get('/todos', function (Request $request, Response $response) {

    $sql = "SELECT * FROM todo";

    try {
        $db = new DB();
        $conn = $db->connect();

        $stmt = $conn->query($sql);
        $todos = $stmt->fetchAll(PDO::FETCH_OBJ);

        $db = null;
        $response->getBody()->write(json_encode($todos));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    } catch (PDOException $e) {
            $error = array(
                "message" => $e->getMessage()
            );

            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(500);
    }
});

/* 
* GET a single ToDo item
*/

$app->get('/todo/{id}', function (Request $request, Response $response, array $args) {

    $id = $args['id'];
    $sql = "SELECT * FROM todo WHERE id = $id";

    try {
        $db = new DB();
        $conn = $db->connect();

        $stmt = $conn->query($sql);
        $todo = $stmt->fetch(PDO::FETCH_OBJ);

        $db = null;

        //Return a vaild 200 result if returned value
        if ($todo) {
            $response->getBody()->write(json_encode($todo));
            return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
        }
        else {
            $error = array(
                "message" => "Resource not found"
            );
            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(404);
        }
    } catch (PDOException $e) {
            $error = array(
                "message" => $e->getMessage()
            );
            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(500);
    }
});

/* 
* POST a new TODO Item
*/

$app->post('/todo', function (Request $request, Response $response, array $args) {

    $name = $request->getParam('name');
    $comment = $request->getParam('comment');
    $status = $request->getParam('status');

    //Check required fields (name)
    if (empty($name)) {
        $error = array("message" => "Missing Required Fields: name");
        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(400);
    }

    //Check if status is within possible terms [ todo, inprogress, complete ]. If not, force to "todo"
    $possible_status = array("todo", "inprogress", "complete");
    if (!in_array($status, $possible_status)) {
        $status = "todo";
    }

    $sql = "INSERT INTO todo (name, comment, status) VALUE (:name, :comment, :status)";

    try {
        $db = new DB();
        $conn = $db->connect();

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':comment', $comment);
        $stmt->bindParam(':status', $status);

        $result = $stmt->execute();

        $stmt = $conn->query("SELECT * FROM todo WHERE id = ".$conn->lastInsertId());
        $todo = $stmt->fetch(PDO::FETCH_OBJ);

        $db = null;

        $response->getBody()->write(json_encode($todo));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(201);

    } catch (PDOException $e) {
            $error = array(
                "message" => $e->getMessage()
            );

            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(500);
    }
});


/* 
* Update a new TODO Item
*/

$app->put('/todo/{id}', function (Request $request, Response $response, array $args) {

    $id = $args['id'];
    $name = $request->getParam('name');
    $comment = $request->getParam('comment');
    $status = $request->getParam('status');

    //Check if status is within possible terms [ todo, inprogress, complete ]. If not, force to "todo"
    $possible_status = array("todo", "inprogress", "complete");
    if (!in_array($status, $possible_status)) {
        $status = "todo";
    }

    $sql = "UPDATE todo SET name=:name, comment=:comment, status=:status WHERE id=:id";

    try {
        $db = new DB();
        $conn = $db->connect();

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':comment', $comment);
        $stmt->bindParam(':status', $status);

        $result = $stmt->execute();

        $stmt = $conn->query("SELECT * FROM todo WHERE id = ".$id);
        $todo = $stmt->fetch(PDO::FETCH_OBJ);

        $db = null;

        $response->getBody()->write(json_encode($todo));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(201);

    } catch (PDOException $e) {
            $error = array(
                "message" => $e->getMessage()
            );

            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(500);
    }
});


$app->delete('/todo/{id}', function (Request $request, Response $response, array $args) {

    $id= $args['id'];

    $sql = "DELETE FROM todo WHERE id = $id";

    try {
        $db = new DB();
        $conn = $db->connect();

        $stmt = $conn->prepare($sql);
        $result = $stmt->execute();

        $db = null;

        //Return a vaild 200 result if returned value
        if ($stmt->rowCount() > 0) {
            $message = array("message" => "This TODO item has been deleted");
            $response->getBody()->write(json_encode($message));
            return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
        }
        else {
            $error = array(
                "message" => "Could not locate Todo Item"
            );
            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(400);
        }

    } catch (PDOException $e) {
            $error = array(
                "message" => $e->getMessage()
            );

            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(500);
    }
});
