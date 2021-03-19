<?php

//ver errores en la aplicacion


//codigo en comun entre archivos
require_once '../vendor/autoload.php';
//inicalizar secion 
session_start();


if(getenv('DEBUG') === 'true'){
    ini_set('display_errors', 1);
    ini_set('display_starup_error', 1);
    error_reporting(E_ALL);
}

use Illuminate\Database\Capsule\Manager as Capsule;
use Aura\Router\RouterContainer;
use Laminas\Diactoros\Response;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use WoohooLabs\Harmony\Harmony;
use WoohooLabs\Harmony\Middleware\DispatcherMiddleware;
use WoohooLabs\Harmony\Middleware\LaminasEmitterMiddleware;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$log = new Logger('app');
$log->pushHandler(new StreamHandler( __DIR__ . '/../logs/app.log', Logger::WARNING));

$container = new DI\Container();
$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'cursophp',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();
// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

$routerContainer = new RouterContainer();
$map = $routerContainer->getMap();
$map->get('index', '/Curso/', [
    'app\controllers\indexController',
    'indexAction'

]);

$map->get('indexJobs', '/Curso/jobs', [
    'app\controllers\jobsController',
    'indexAction'

]);

$map->get('deleteJobs', '/Curso/jobs/delete', [
    'app\controllers\jobsController',
    'deleteAction'

]);


$map->get('addjob', '/Curso/add/job', [
    'app\controllers\jobsController',
    'getAddJobAction'

]);

$map->post('saveJobs', '/Curso/add/job', [
    'app\controllers\jobsController',
    'getAddJobAction'

]);

// Users
$map->get('addUser', '/Curso/add/User', [
    'app\controllers\userController',
    'getAddUser'
]);
$map->post('saveUsers', '/Curso/save/User', [
    'app\controllers\userController',
    'postSaveUser'
]);

$map->get('loginForm', '/Curso/login', [
    'app\controllers\authController',
    'getLogin'
]);

$map->get('logout', '/Curso/logout', [
    'app\controllers\authController',
    'getLogout'
]);

$map->post('auth', '/Curso/auth', [
    'app\controllers\authController',
    'postLogin'
]);

$map->get('admin', '/Curso/admin', [
    'app\controllers\adminController',
    'getIndex'
    //'auth' => true
]);

$map->get('contactForm', '/Curso/contact', [
    'app\controllers\contactController',
    'index'
]);

$map->post('contactSend', '/Curso/contact/send', [
    'app\controllers\contactController',
    'send'
]);


$matcher = $routerContainer->getMatcher();
$route = $matcher->match($request);
//var_dump($matcher->$route);

/*function printElement($job){

    /* if($job->visible == false){
         return;
       }
       
     echo '<li class="work-position">';
     echo '<h5>' . $job->title . '</h5>';
     echo '<p>' . $job->description . '</p>';
     echo '<p>' . $job->getDurationAsString() . '</p>';
     echo '<strong>Achievements:</strong>';
     echo '<ul>';
     echo '<li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>';
     echo '<li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>';
     echo '<li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>';
     echo '</ul>';
     echo '</li>';
   }*/

if(!$route){
    echo 'No hay birote (NO ROUTE)';
}else{
    /*$handlerData = $route->handler;
    $controllersName = $handlerData['controller'];
    $actionName = $handlerData['action'];
    $needsAuth =  $handlerData['auth'] ?? false;


    /*if($controllersName === 'app\controllers\jobsController'){
        $controller = new $controllersName(new \app\services\jobService());
    } else{
        $controller = new $controllersName;
    }*/
    /*$controller = $container->get($controllersName);
    $response = $controller->$actionName($request);

    foreach($response->getHeaders() as $name => $values)
    {
        foreach($values as $value) {
            header(sprintf('%s: %s', $name, $value), false);
        }
    }
    http_response_code($response->getStatusCode());
    echo $response->getBody();*/
    try {
        $harmony = new Harmony($request, new Response());
        $harmony
            ->addMiddleware(new LaminasEmitterMiddleware(new SapiEmitter()));
            if(getenv('DEBUG') === 'true'){
                $harmony->addMiddleware(new \Franzl\Middleware\Whoops\WhoopsMiddleware());
            }
           $harmony->addMiddleware(new \app\Middlewares\authenticationMiddleware())
            ->addMiddleware(new \Middlewares\AuraRouter($routerContainer))
            ->addMiddleware(new DispatcherMiddleware($container, 'request-handler'))
            ->run();
    } catch (Exception $e){
        $log->warning($e->getMessage());
        $emitter = new SapiEmitter();
        $emitter ->emit(new Response\EmptyResponse(400));
    } catch (Error $e){
        $emitter = new SapiEmitter();
        $emitter ->emit(new Response\EmptyResponse(500));
    }
}
//ruta que el usuario esta buscando
/*$route = $_GET['route'] ?? '/';

if ($route == '/'){
    require '../index.php';
} elseif($route == 'addjob'){
    require '../addjob.php';
}*/