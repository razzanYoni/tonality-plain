<?php

namespace cores;

require_once ROOT_DIR . 'src/cores/Request.php';
require_once ROOT_DIR . 'src/cores/Response.php';
require_once ROOT_DIR . 'src/cores/Router.php';
require_once ROOT_DIR . 'src/db/PDOInstance.php';
require_once ROOT_DIR . 'src/cores/Session.php';
require_once ROOT_DIR . 'src/cores/View.php';

use PDO,
    models\UserModel,
    db\PDOInstance;

class Application {
    const EVENT_BEFORE_REQUEST = 'beforeRequest';
    const EVENT_AFTER_REQUEST = 'afterRequest';

    protected array $eventListeners = [];

    public static Application $app;
    public static string $ROOT_DIR;
    public string $userClass;
    public string $layout = 'main';
    public Router $router;
    public Request $request;
    public Response $response;
    public ?Controller $controller = null;
    public PDO $db;
    public Session $session;
    public View $view;
    public ?UserModel $loggedUser;

    private function __construct($rootDir)
    {
        $this->loggedUser = null;
        $this->userClass = UserModel::class;
        self::$ROOT_DIR = $rootDir;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->db = PDOInstance::getInstance()->getDbh();
        $this->session = new Session();
        $this->view = new View();

        $userId = Application::$app->session->get('user');
        if ($userId) {
            $key = $this->userClass::primaryKey();
            $this->loggedUser = $this->userClass::findOne([$key => $userId]);
        }
    }

    public static function getInstance()
    {
        if (!isset(self::$app)) {
            self::$app = new static(ROOT_DIR);
        }
        return self::$app;
    }

    public static function isGuest()
    {
        return !self::$app->loggedUser;
    }

    public static function isAdmin() {
        return self::$app->loggedUser->get('_isAdmin');
    }

    public function login(UserModel $user)
    {
        $this->loggedUser = $user;
        $value = $user->get('userId');
        Application::$app->session->set('userId', $value);

        return true;
    }

    public function logout()
    {
        $this->loggedUser = null;
        self::$app->session->remove('user');
    }

    public function run()
    {
        $this->triggerEvent(self::EVENT_BEFORE_REQUEST);
        try {
            echo $this->router->resolve();
        } catch (\Exception $e) {
            echo $this->router->renderView('_error', [
                'exception' => $e,
            ]);
        }
    }

    public function triggerEvent($eventName)
    {
        $callbacks = $this->eventListeners[$eventName] ?? [];
        foreach ($callbacks as $callback) {
            call_user_func($callback);
        }
    }

    public function on($eventName, $callback)
    {
        $this->eventListeners[$eventName][] = $callback;
    }
}