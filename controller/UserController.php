<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '\shopping\model\all.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '\shopping\controller\controller.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '\shopping\smarty\smarty_init.php');

    class UserController extends Controller
    {
        private $id;
        public function __construct($action, $id)
        {
            $this->id = $id;
            if (method_exists($this, $action)) {
                $this->$action();
            } else {
                $action = 'GET_index';
                $this->$action();
            }
            // parent::__construct();
        }
        
        public function GET_index()
        {
            $is_login = (checkToken()) ? false : true;
            $user_item = getToken();
            $product = new Product;
            $product_list = $product->getAllProductOnSale();
            $smarty = new Smarty;
            $smarty->assign('product_list', $product_list);
            $smarty->assign('permission', $user_item['permission']);
            $smarty->assign('is_login', $is_login);
            $smarty->display('../views/index.html');
        }
          
        /*
         * 檢查帳號是否重複
         */
        public function POST_checkAccount()
        {
            $account = $_POST['account'];
            $user = new User();
            $user_account = $user->getAccount($account);
            echo json_encode($user_account);
            exit();
        }

        /*
         * 註冊頁面
         */
        public function GET_signup()
        {
            $smarty = new Smarty;
            $smarty->display('../views/signup.html');
        }
        
        /*
         * 註冊
         */
        public function POST_signup()
        {
            $account = $_POST['account'];
            $password = $_POST['password'];
            $id_number = $_POST['id_number'];
            $name = $_POST['name'];
            $check_tool = new CheckTool;
            $check_result = $check_tool->checkSignupFormat($account, $password, $name, $id_number);
            ## 判斷格式是否正確
            if (!$check_result) {
                $data = [
                    'alert' => '格式錯誤或帳號已存在',
                ];
                echo json_encode($data);
                exit();
            }

            $user = new User;
            $password = password_hash($password, PASSWORD_DEFAULT);
            $is_success = $user->signup($account, $password, $name, $id_number);
            if ($is_success) {
                $data = [
                    'alert' => '註冊成功',
                    'location' => $_SERVER['DOCUMENT_ROOT'] . '/shopping/controller/userController.php/login',
                ];
            } else {
                $data = [
                    'alert' => '註冊失敗',
                ];
            }
            echo json_encode($data);
            exit();
        }

        /*
         * 登入
         */
        public function GET_login()
        {
            $smarty = new Smarty;
            $smarty->display('../views/login.html');
        }

         public function POST_login()
        {
            $account = $_POST['account'];
            $password = $_POST['password'];
            $check_tool = new CheckTool;
            $is_format_right = $check_tool->checkLoginFormat($account, $password);
            ## 檢查格式
            if (!$is_format_right) {
                $data = [
                    'alert' => '格式錯誤',
                ];
                echo json_encode($data);
                exit();
            }
            
            $user = new User;
            $user_item = $user->getAccount($account);
            ## 搜尋帳號
            if (isset($user_item['account'])){
                if (password_verify($password, $user_item['password'])) {
                    $token = produceToken();
                    $user->addToken($account, $token);
                    setcookie('token', $token, time() + 3600 ,'/');
                    ##檢查購物車
                    $order_menu = new OrderMenu;
                    $order_menu_item = $order_menu->getLastListByUserId($user_item['user_id']);
                    if (isset($order_menu_item['user_id'])) {
                        setcookie('order_menu_id', $order_menu_item['order_menu_id'], time() + 3600 , '/');
                    } else {
                        $is_success = $order_menu->addList($user_item['user_id']);
                        if($is_success){
                            $order_menu_item = $order_menu->getLastListByUserId($user_item['user_id']);
                            setcookie('order_menu_id', $order_menu_item['order_menu_id'], time() + 3600 , '/');
                        }
                    }
                    $data=[
                        'alert' => '登入成功',
                        'location' => '/shopping/controller/userController.php/index',
                    ];
                    echo json_encode($data);
                    exit();
                } else {
                    $data = [
                        'alert' => '密碼錯誤',
                    ];
                    echo json_encode($data);
                    exit();
                }
            }
        }

        /*
         * 登出
         */
        public function GET_logout()
        {
            $smarty = new Smarty;
            $smarty->display('../views/logout.html');
        }

        public function DELETE_logout()
        {
            setcookie ("token", "test", time()-100, '/');
            setcookie ("order_menu_id", "test", time()-100, '/');
            $data = [
                'alert' => '登出成功',
                'location' => '/shopping/controller/userController.php/index',
            ];
            echo json_encode($data);
            exit();
        }

        /*
         * 購物車頁面
         */
        public function GET_shoppingCar()
        {
            $is_login = (checkToken()) ? false : true;
            $smarty = new Smarty;
            $smarty->assign('is_login', $is_login);
            $smarty->display('../views/shopping_car.html');
        }
    }

    $url_list = explode('/',$_SERVER['REQUEST_URI']);
    $action = (isset($url_list[4])) ? $url_list[4] : '';
    $id = (isset($url_list[5])) ? $url_list[5] : '';
    $method = $_SERVER['REQUEST_METHOD'];
    $method_action = "{$method}_{$action}";
    new UserController($method_action, $id);