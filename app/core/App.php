<?php
class App {
    protected $controller = "HomeController";
    protected $method     = "home";
    protected $params     = [];

    public $currentController;

    public $controllerName;

    public function __construct(){
        session_start();

        $url = $this->parseUrl();

        if (isset($url[0])) {
            if (file_exists("../app/controllers/" . $url[0] . "Controller.php")) {
                $this->currentController = $url[0];
                $this->controller = $url[0] . "Controller";
                $this->controllerName = ucfirst($url[0]) . "Controller";
                unset($url[0]);
            }
        }

        require_once "../app/controllers/{$this->controller}.php";

        $this->controller = new $this->controller;

        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        $this->params = $url ? array_values($url) : [];

        $_SESSION["currentController"] = $this->currentController;

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl() {
        if (isset($_GET['url'])) {
            return explode("/", filter_var(rtrim($_GET['url'], "/"), FILTER_SANITIZE_URL));
        }
    }
}
?>