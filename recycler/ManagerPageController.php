<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '\shopping\smarty\smarty_init.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '\shopping\model\all.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '\shopping\controller\controller.php');

    $url_list = explode('/',$_SERVER['REQUEST_URI']);
    $action = (isset($url_list[4])) ? $url_list[4] : '';
    $id = (isset($url_list[5])) ? $url_list[5] : '';
    
    new ManagerPageController($action, $id);
    
    class ManagerPageController
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

        /*
         * 管理者登入頁面
         */
        public function login()
        {
            
            $smarty->display('../views/manager_login.html');
        }
        
        /*
         * 會員管理頁面
         */
        public function member()
        {
            $is_login = (checkToken()) ? false : true;
            $user_item = getToken();
            $user = new User;
            $user_list = $user->getAllUser();
            $smarty = new Smarty;
            $smarty->assign('user_list', $user_list);
            $smarty->assign('permission', $user_item['permission']);
            $smarty->assign('is_login', $is_login);
            $smarty->display('../views/maneger_member.html');
        }
        
        
        

        /*
         * 新增產品頁面
         */
        public function addProduct()
        {
            $is_login = (checkToken()) ? false : true;
            $user_item = getToken();
            $smarty = new Smarty;
            $smarty->assign('permission', $user_item['permission']);
            $smarty->assign('is_login', $is_login);
            $smarty->display('../views/manager_add_product.html');
        }
    }
    
