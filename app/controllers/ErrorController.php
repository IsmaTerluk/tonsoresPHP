<?php 

    class ErrorController extends Controller {

        function __construct() {
            parent::__construct();
        }

        public function error404(){
            $page = 'templates/error404';
            $this->view->renderHTML($page);
        }
    }