<?php

namespace cores;

require_once ROOT_DIR . 'src/cores/Request.php';
require_once ROOT_DIR . 'src/cores/Response.php';
require_once ROOT_DIR . 'src/cores/Router.php';
require_once ROOT_DIR . 'src/db/PDOInstance.php';
require_once ROOT_DIR . 'src/cores/Session.php';
require_once ROOT_DIR . 'src/cores/View.php';
require_once ROOT_DIR . 'src/bases/BaseController.php';
require_once ROOT_DIR . 'src/cores/UserAuth.php';

use PDO,
    db\PDOInstance,
    repositories\UserRepository,
    bases\BaseController;

class Application {
    const EVENT_BEFORE_REQUEST = 'beforeRequest';
    const EVENT_AFTER_REQUEST = 'afterRequest';

    protected array $eventListeners = [];

    public static Application $app;
    public static string $ROOT_DIR;
    public string $userClass;
    public string $layout = 'blank';
    public Router $router;
    public Request $request;
    public Response $response;
    public ?BaseController $controller = null;
    public PDO $db;
    public Session $session;
    public View $view;
    public ?UserAuth $loggedUser;

    private function __construct($rootDir)
    {
        $this->loggedUser = null;
        $this->userClass = UserAuth::class;
        self::$ROOT_DIR = $rootDir;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->db = PDOInstance::getInstance()->getDbh();
        $this->session = new Session();
        $this->view = new View();

        $userId = Application::$app->session->get('user_id');
        if ($userId) {
            $userModel = new UserAuth();
            $userModel->constructFromArray(UserRepository::getInstance()->getUserById($userId));
            $this->loggedUser = $userModel;
        }
    }

    public static function getInstance()
    {
        if (!isset(self::$app)) {
            self::$app = new static(ROOT_DIR);
        }
        return self::$app;
    }

    public static function isNotUser()
    {
        // asumsi admin gabisa masuk ke halaman user
        return !self::$app->loggedUser || self::$app->loggedUser->isAdmin();
    }

    public static function isNotAdmin() {

        return !self::$app->loggedUser || !self::$app->loggedUser->isAdmin();
    }

    public function login(UserAuth $user)
    {
        $this->loggedUser = $user;
        $user_id = $user->getUserId();
        $is_admin = $user->isAdmin();
        Application::$app->session->set('user_id', $user_id);
        Application::$app->session->set('is_admin', $is_admin);

        return [true, $is_admin];
    }

    public function logout()
    {
        $this->loggedUser = null;
        self::$app->session->remove('user_id');
        self::$app->session->remove('is_admin');
    }

    public function run()
    {
        $this->triggerEvent(self::EVENT_BEFORE_REQUEST);
        try {
            echo $this->router->resolve();
        } catch (\Exception $e) {
            echo $this->router->renderView('error/_error', [
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