<?php
    // require_once($_SERVER['DOCUMENT_ROOT'] . '\shopping\smarty\smarty_init.php');
    // require_once($_SERVER['DOCUMENT_ROOT'] . '\shopping\model\all.php');
    // require_once($_SERVER['DOCUMENT_ROOT'] . '\shopping\controller\controller.php');
    
    // $url_list = explode('/',$_SERVER['REQUEST_URI']);
    // $action = (isset($url_list[4])) ? $url_list[4] : '';
    // $id = (isset($url_list[5])) ? $url_list[5] : '';
    
    // $test='PageController';
    // new $test($action, $id);
    
    // class PageController
    // {
    //     private $id;
    //     public function __construct($action, $id)
    //     {
    //         $this->id = $id;
    //         if (method_exists($this, $action)) {
    //             $this->$action();
    //         } else {
    //             $action = 'index';
    //             $this->$action();
    //         }
    //         // parent::__construct();
    //     }

    //     /*
    //      * 首頁
    //      */
    //     public function index()
    //     {
    //         $is_login = (checkToken()) ? false : true;
    //         $user_item = getToken();
    //         $product = new Product;
    //         $product_list = $product->getAllProductOnSale();
    //         $smarty = new Smarty;
    //         $smarty->assign('product_list', $product_list);
    //         $smarty->assign('permission', $user_item['permission']);
    //         $smarty->assign('is_login', $is_login);
    //         $smarty->display('../views/index.html');
    //     }

    //     /*
    //      * 註冊頁面
    //      */
    //     public function signup()
    //     {
    //         $smarty = new Smarty;
    //         $smarty->display('../views/signup.html');
    //     }

    //     /*
    //      * 登入頁面
    //      */
    //     public function login()
    //     {
    //         $smarty = new Smarty;
    //         $smarty->display('../views/login.html');
    //     }
        
    //     /*
    //      * 購物車頁面
    //      */
    //     public function shoppingCar()
    //     {
    //         $is_login = (checkToken()) ? false : true;
    //         $smarty = new Smarty;
    //         $smarty->assign('is_login', $is_login);
    //         $smarty->display('../views/shopping_car.html');
    //     }

    //     /*
    //      * 頁面
    //      */
        
    //     /*
    //      * 登出頁面
    //      */
    //     public function logout()
    //     {
    //         $smarty = new Smarty;
    //         $smarty->display('../views/logout.html');
    //     }
    // }
    