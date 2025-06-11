<?php
    class HomeController extends Controller {
        public function index() {
            $this->redirect($this->siteUrl("home/home"));
        }

        public function home() {
            $this->view("structure/header");
            $this->view("home/home");
            $this->view("structure/footer");
        }
    }
?>