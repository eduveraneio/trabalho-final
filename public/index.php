<?php
    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;

    require_once '../vendor/autoload.php';

    //Set up Autoloading for Own Classes
    spl_autoload_register(function ($classname) {
        require_once ("../classes/" . $classname . ".php");
    });

    //Add Config Settings
    require_once '../controllers/config.php';

    $app = new \Slim\App(["settings" => $config]);

    //Add Container
    $container = $app->getContainer();
    require_once '../controllers/container.php';

    //Add Views and Templates
    $container['view'] = new \Slim\Views\PhpRenderer("../templates/");

    //Add Rules
    require_once '../controllers/conselho-classe.php';
    require_once '../controllers/questionario.php';
    require_once '../controllers/questao.php';

    $app->get('/', function (Request $request, Response $response) {
        //return $response->withRedirect('/conselho-classe');
        $response = $this->view->render($response, "topo.phtml");
        $response = $this->view->render($response, "index.phtml");
        $response = $this->view->render($response, "rodape.phtml");
        return $response;
    });

    $app->run();