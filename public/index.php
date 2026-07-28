<?php

require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app = AppFactory::create();

$app->setBasePath('/filipino-cookbook-api/public');

$app->addBodyParsingMiddleware();
$app->addErrorMiddleware(true,true,true);

try{

    $pdo = new PDO(
        "mysql:host=localhost;dbname=filipino_cookbook_api",
        "root",
        ""
    );

    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

}catch(PDOException $e){

    die(
        "Database Error: "
        . $e->getMessage()
    );
}



$tokenMiddleware = function (
    Request $request,
    $handler
){

    $authHeader =
        $request->getHeaderLine(
            'Authorization'
        );

    $validToken =
        'Bearer dmmmsu-cookbook-token-2026';

    if($authHeader !== $validToken){

        $response =
            new Slim\Psr7\Response();

        $response->getBody()->write(
            json_encode([
                "status"=>"error",
                "message"=>"Unauthorized access"
            ])
        );

        return $response
            ->withStatus(401)
            ->withHeader(
                'Content-Type',
                'application/json'
            );
    }

    return $handler->handle($request);
};

// WELCOME MESSAGE
$app->get('/',
function(
    Request $request,
    Response $response
){

    $response->getBody()->write(
        json_encode([
            "message" =>
            "Welcome to the Secured Filipino Cookbook API",

            "note" =>
            "Use a valid Bearer token to access /api endpoints."
        ])
    );

    return $response
        ->withHeader(
            'Content-Type',
            'application/json'
        );
});


//GET ALL FOODS

$app->get('/api/foods',
function(
    Request $request,
    Response $response
) use ($pdo){

    $stmt = $pdo->query("
        SELECT *
        FROM foods
    ");

    $foods =
        $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach($foods as &$food){

        $stmtIngredients =
            $pdo->prepare("
                SELECT i.ingredient_name
                FROM ingredients i
                INNER JOIN food_ingredients fi
                ON i.ingredient_id = fi.ingredient_id
                WHERE fi.food_id = ?
            ");

        $stmtIngredients->execute([
            $food['food_id']
        ]);

        $food['ingredients'] =
            $stmtIngredients->fetchAll(
                PDO::FETCH_COLUMN
            );
    }

    $response->getBody()->write(
        json_encode($foods)
    );

    return $response
        ->withHeader(
            'Content-Type',
            'application/json'
        );

})->add($tokenMiddleware);

// GET FOOD BY ID

$app->get('/api/foods/{id}',
function(
    Request $request,
    Response $response,
    $args
) use ($pdo){

    $foodId = $args['id'];

    $stmt = $pdo->prepare("
        SELECT *
        FROM foods
        WHERE food_id = ?
    ");

    $stmt->execute([$foodId]);

    $food = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$food){

        $response->getBody()->write(
            json_encode([
                "message" => "Food not found"
            ])
        );

        return $response->withStatus(404);
    }

    $stmt = $pdo->prepare("
        SELECT i.ingredient_name
        FROM ingredients i
        INNER JOIN food_ingredients fi
        ON i.ingredient_id = fi.ingredient_id
        WHERE fi.food_id = ?
    ");

    $stmt->execute([$foodId]);

    $food['ingredients'] =
        $stmt->fetchAll(PDO::FETCH_COLUMN);

    $response->getBody()->write(
        json_encode($food)
    );

    return $response
        ->withHeader(
            'Content-Type',
            'application/json'
        );

})->add($tokenMiddleware);

// GET FOOD BY NAME

$app->get('/api/foods/search/{name}',
function(
    Request $request,
    Response $response,
    $args
) use ($pdo){

    $stmt =
    $pdo->prepare(
        "SELECT *
         FROM foods
         WHERE food_name
         LIKE ?"
    );

    $stmt->execute([
        "%" . $args['name'] . "%"
    ]);

    $foods =
    $stmt->fetchAll(
        PDO::FETCH_ASSOC
    );

    $response->getBody()->write(
        json_encode($foods)
    );

    return $response
        ->withHeader(
            'Content-Type',
            'application/json'
        );

})->add($tokenMiddleware);

// GET FOOD CATEGORIES

$app->get('/api/categories',
function(
    Request $request,
    Response $response
) use ($pdo){

    $stmt =
    $pdo->query(
        "SELECT * FROM categories"
    );

    $response->getBody()->write(
        json_encode(
            $stmt->fetchAll(
                PDO::FETCH_ASSOC
            )
        )
    );

    return $response
        ->withHeader(
            'Content-Type',
            'application/json'
        );

})->add($tokenMiddleware);

// GET FOOD INGREDIENTS

$app->get('/api/ingredients',
function(
    Request $request,
    Response $response
) use ($pdo){

    $stmt =
    $pdo->query(
        "SELECT * FROM ingredients"
    );

    $response->getBody()->write(
        json_encode(
            $stmt->fetchAll(
                PDO::FETCH_ASSOC
            )
        )
    );

    return $response
        ->withHeader(
            'Content-Type',
            'application/json'
        );

})->add($tokenMiddleware);

// ADD FOODS

$app->post('/api/foods',
function(
    Request $request,
    Response $response
) use ($pdo){

    $data =
        $request->getParsedBody();

    try{

        $pdo->beginTransaction();

//Insert Food

        $stmt =
        $pdo->prepare("
            INSERT INTO foods
            (
                food_name,
                category_id,
                origin_id,
                instructions
            )
            VALUES
            (?,?,?,?)
        ");

        $stmt->execute([
            $data['food_name'],
            $data['category_id'],
            $data['origin_id'],
            $data['instructions']
        ]);

        $foodId =
            $pdo->lastInsertId();

        foreach(
            $data['ingredients']
            as $ingredientName
        ){

            $stmt =
            $pdo->prepare("
                SELECT ingredient_id
                FROM ingredients
                WHERE ingredient_name = ?
            ");

            $stmt->execute([
                $ingredientName
            ]);

            $ingredient =
            $stmt->fetch(
                PDO::FETCH_ASSOC
            );

// If ingredient does not exist create it

            if(!$ingredient){

                $stmt =
                $pdo->prepare("
                    INSERT INTO ingredients
                    (ingredient_name)
                    VALUES (?)
                ");

                $stmt->execute([
                    $ingredientName
                ]);

                $ingredientId =
                $pdo->lastInsertId();

            }else{

                $ingredientId =
                $ingredient['ingredient_id'];

            }

//Connect food and ingredient

            $stmt =
            $pdo->prepare("
                INSERT INTO
                food_ingredients
                (
                    food_id,
                    ingredient_id
                )
                VALUES (?,?)
            ");

            $stmt->execute([
                $foodId,
                $ingredientId
            ]);
        }

        $pdo->commit();

        $response->getBody()->write(
            json_encode([
                "status" => "success",
                "message" =>
                "Food added successfully",
                "food_id" =>
                $foodId
            ])
        );

        return $response
            ->withHeader(
                'Content-Type',
                'application/json'
            )
            ->withStatus(201);

    }catch(Exception $e){

        $pdo->rollBack();

        $response->getBody()->write(
            json_encode([
                "status" => "error",
                "message" =>
                $e->getMessage()
            ])
        );

        return $response
            ->withStatus(500);
    }

})->add($tokenMiddleware);


$app->run();