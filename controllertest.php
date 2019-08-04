<?php
    require_once('smarty/smarty_init.php');
    // require_once('model/all.php');
    $url_list = explode('/',$_SERVER['REQUEST_URI']);
            if(isset($url_list[3])){
                $action = $url_list[3];
            }
            $id = (isset($url_list[4])) ? $url_list[4] : '';

    
    new testController($action, $id);
    
    class testController
    {
        private $id;
        public function __construct($action, $id)
        {
            $this->id = $id;
            if (method_exists($this, $action)) {
                $this->$action();
            } else {
                $action = 'index';
                $this->$action();
            }
            // parent::__construct();
        }

        public function index()
        {
            
            echo "action";
            // echo $_SERVER['REQUEST_URI'];
        }

        public function test()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                echo 'GET';
            }
            elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
                echo 'POST';
            }
            elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {
                parse_str(file_get_contents('php://input'), $_PUT);
                echo json_encode($_PUT);
            }
            elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
                echo 'DELETE';
            }
            else {
                echo 'ssss';
            }
            
        }
    }