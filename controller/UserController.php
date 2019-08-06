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
                    ##檢查並更新購物車
                    checkOrderMenuId($user_item);
                    $data = [
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
            $user_item = getToken();
            $order_menu_id = $user_item['order_menu_id'];
            $order_detail = new OrderDetail;
            $product_id_list = $order_detail->getAllProductId($order_menu_id);
            $product_list = [];
            $product = new Product;
            foreach($product_id_list as $product_id) {
                $product_item = $product->getOneProduct($product_id["product_id"]);
                if (!isset($product_item["product_id"])) {
                    continue;
                }
                $order_detail_item = $order_detail->getOne($user_item['order_menu_id'], $product_id["product_id"]);
                $product_item['amount'] = $order_detail_item['amount'];
                $product_list[] = $product_item;
            }
            $smarty = new Smarty;
            $smarty->assign('product_list', $product_list);
            $smarty->assign('is_login', $is_login);
            $smarty->display('../views/shopping_car.html');
        }

        /*
         * 將產品加到購物車
         */
        public function POST_addProduct()
        {
            $product_id = $_POST['product_id'];
            $user = new User;
            $user_item = $user->getUserByToken($_COOKIE['token']);
            $order_menu_id = $user_item['order_menu_id'];
            $order_detail = new OrderDetail;
            $product_count = $order_detail->getOneCount($order_menu_id, $product_id);
            if($product_count['count(*)']) {
                $data = [
                    'alert' => '產品已在購物車',
                    'is_success' => false
                ];
                echo json_encode($data);
                exit();
            }
            $is_success = $order_detail->addProduct($order_menu_id, $product_id);
            if ($is_success) {
                $data = [
                    'alert' => '加入成功',
                    'is_success' => true
                ];
            }
            echo json_encode($data);
        }

        /*
         * 將產品從購物車移除
         */
        public function DELETE_product()
        {
            parse_str(file_get_contents('php://input'), $_DELETE);
            $user_item = getToken();
            $order_menu_id = $user_item['order_menu_id'];
            $product_id = $_DELETE['product_id'];
            $order_detail = new OrderDetail;
            $is_success = $order_detail->deleteOne($order_menu_id, $product_id);
            if ($is_success) {
                $data = [
                    'alert' => '移除成功',
                    'is_success' => true
                ];
            } else {
                $data = [
                    'alert' => '商品不存在',
                    'is_success' => false
                ];
            }
            echo json_encode($data);
        }

        /*
         * 修改購物車中產品數量
         */
        public function PUT_product()
        {
            parse_str(file_get_contents('php://input'), $_PUT);
            $user_item = getToken();
            $order_menu_id = $user_item['order_menu_id'];
            $product_id = $_PUT['product_id'];
            $amount = $_PUT['amount'];
            $order_detail = new OrderDetail;
            $is_success = $order_detail->updateAmount($amount, $order_menu_id, $product_id);
            if ($is_success) {
                $data = [
                    'alert' => '修改數量成功',
                    'is_success' => true
                ];
            } else {
                $data = [
                    'alert' => '修改數量失敗',
                    'is_success' => false
                ];
            }
            echo json_encode($data);
        }
    }

    $url_list = explode('/' , $_SERVER['REQUEST_URI']);
    $action = (isset($url_list[4])) ? $url_list[4] : '';
    $id = (isset($url_list[5])) ? $url_list[5] : '';
    $method = $_SERVER['REQUEST_METHOD'];
    $method_action = "{$method}_{$action}";
    new UserController($method_action, $id);