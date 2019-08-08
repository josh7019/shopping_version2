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
            $is_login = (checkToken()) ? true : false;
            $user_item = getUser();
            
            $product = new Product;
            $product_list = $product->getAllProductOnSale();
            $smarty = new Smarty;
            if ($is_login) {
                $order_menu_id = checkAndGetOrderMenuId($user_item);
                $order_detail = new OrderDetail;
                $order_detail_list = $order_detail->getAllProductId($order_menu_id);
                $smarty->assign('order_detail_list_length', count($order_detail_list));
            }
            
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
                    checkAndGetOrderMenuId($user_item);
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
            $is_login = (checkToken()) ? true : false;
            $user_item = getUser();
            if ($is_login) {
                $order_menu_id = checkAndGetOrderMenuId($user_item);
                $order_detail = new OrderDetail;
                $product_id_list = $order_detail->getAllProductId($order_menu_id);
                $product_list = [];
                $product = new Product;
                foreach($product_id_list as $product_id) {
                    $product_item = $product->getOneProductOnSale($product_id["product_id"]);
                    if (!isset($product_item["product_id"])) {
                        $order_detail->deleteOne($order_menu_id,$product_id["product_id"]);
                        continue;
                    }
                    $order_detail_item = $order_detail->getOne(checkAndGetOrderMenuId($user_item), $product_id["product_id"]);
                    $product_item['amount'] = $order_detail_item['amount'];
                    $product_list[] = $product_item;
                }
                $total_price = getTotalPrice($order_menu_id,$order_menu_id);
                $user_final_cash = $user_item['cash'] - $total_price;
            } else {
                $total_price = 0;
                $user_final_cash = 0;
                $product_list = 0;
            }
            
            
            // var_dump($user_item);
            $smarty = new Smarty;
            $smarty->assign('permission', $user_item['permission']);
            $smarty->assign('user_item', $user_item);
            $smarty->assign('product_list', $product_list);
            $smarty->assign('total_price', $total_price);
            $smarty->assign('user_final_cash', $user_final_cash);
            $smarty->assign('is_login', $is_login);
            $smarty->display('../views/shopping_car.html');
        }

        /*
         * 將產品加到購物車
         */
        public function POST_addProduct()
        {
            ##檢查是否登入
            if (!checkToken()) {
                $data = [
                    'alert' => '請先登入',
                    'is_success' => 2,
                    'location' => '/shopping/controller/usercontroller.php/login'
                ];
                echo json_encode($data);
                exit();
            }
            $product_id = $_POST['product_id'];
            $user = new User;
            $user_item = $user->getUserByToken($_COOKIE['token']);
            $order_menu_id = checkAndGetOrderMenuId($user_item);
            $order_detail = new OrderDetail;
            $product_count = $order_detail->getOneCount($order_menu_id, $product_id);
            if($product_count['count(*)']) {
                $data = [
                    'alert' => '產品已在購物車',
                    'is_success' => 0
                ];
                echo json_encode($data);
                exit();
            }
            $is_success = $order_detail->addProduct($order_menu_id, $product_id);
            if ($is_success) {
                $data = [
                    'alert' => '加入成功',
                    'is_success' => 1
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
            $user_item = getUser();
            $order_menu_id = checkAndGetOrderMenuId($user_item);
            $product_id = $_DELETE['product_id'];
            $order_detail = new OrderDetail;
            $is_success = $order_detail->deleteOne($order_menu_id, $product_id);
            $total_price = getTotalPrice($order_menu_id);
            $user_final_cash =  $user_item['cash'] - $total_price;
            if ($is_success) {
                $data = [
                    'alert' => '',
                    'is_success' => true,
                    'total_price' => $total_price,
                    'user_final_cash' => $user_final_cash
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
            $user_item = getUser();
            $order_menu_id = checkAndGetOrderMenuId($user_item);
            $product_id = $_PUT['product_id'];
            $amount = $_PUT['amount'];
            if (!preg_match('/^[1-9][0-9]{0,}$/', $amount)) {
                exit();
            }
            
            $product = new Product;
            $product_item = $product->getOneProductOnSale($product_id);
            ## 判斷產品是否售賣中
            if (!isset($product_item['product_id'])) {
                $order_detail = new OrderDetail;
                $is_success = $order_detail->updateAmount($amount, $order_menu_id, $product_id);
                $total_price = getTotalPrice($order_menu_id);
                $user_final_cash =  $user_item['cash'] - $total_price;
                $data = [
                    'alert' => '商品已下架',
                    'is_success' => 2,
                    'total_price'=> $total_price,
                    'user_final_cash' => $user_final_cash
                ];
                echo json_encode($data);
                exit();
            }
            ## 判斷庫存量是否足夠
            if ($amount > $product_item['stock']) {
                $amount = $product_item['stock'];
                $order_detail = new OrderDetail;
                $is_success = $order_detail->updateAmount($amount, $order_menu_id, $product_id);
                $total_price = getTotalPrice($order_menu_id);
                $user_final_cash =  $user_item['cash'] - $total_price;
                $data = [
                    'alert' => '庫存量不足',
                    'is_success' => 3,
                    'amount' => $amount,
                    'total_price'=> $total_price,
                    'user_final_cash' => $user_final_cash
                ];
                echo json_encode($data);
                exit();
            }
            $order_detail = new OrderDetail;
            $is_success = $order_detail->updateAmount($amount, $order_menu_id, $product_id);
            $total_price = getTotalPrice($order_menu_id);
            $user_final_cash =  $user_item['cash'] - $total_price;
            

            if ($is_success) {
                $data = [
                    'alert' => '修改數量成功',
                    'is_success' => 1,
                    'total_price'=> $total_price,
                    'user_final_cash' => $user_final_cash
                ];
            } else {
                $data = [
                    'alert' => '數量相同或商品不存在',
                    'is_success' => 0
                ];
            }
            echo json_encode($data);
        }
        
        /*
         * 結帳
         */
        public function UPDATE_checkOut()
        {
            $user_item = getUser();
            $total_price = getTotalPrice(checkAndGetOrderMenuId($user_item));
            $final_price= $user_item['cash'] - $total_price;
            ## 檢查餘額是否足夠
            if ($final_price < 0) {
                $data = [
                    'alert' => '餘額不足',
                    'is_success' => false,
                ];
                echo json_encode($data);
                exit();
            }
            $order_menu = new OrderMenu;
            $user = new User;
            $is_success_user = $user->checkOut($final_price, $user_item['user_id']);
            ## 判斷使用者結帳流程是否成功
            if (!$is_success_user) {
                $data = [
                    'alert' => '結帳失敗',
                    'is_success' => false,
                ];
                echo json_encode($data);
                exit();
            } elseif ($is_success_user) {
                updateDealPrice(checkAndGetOrderMenuId($user_item));
                $data = [
                    'alert' => '購買成功,感謝您的光臨',
                    'is_success' => false,
                    'location' => '/shopping/controller/usercontroller.php/index'
                ];
                $is_success_order = $order_menu->checkOut(checkAndGetOrderMenuId($user_item));
                checkAndGetOrderMenuId($user_item);
                echo json_encode($data);
                exit();
            } else {
                $data = [
                    'alert' => '結帳失敗,訂單不存在或已經結帳',
                    'is_success' => false,
                ];
                echo json_encode($data);
                exit();
            }
        }

        /*
         * 訂單記錄頁面
         */
        public function GET_shoppingHistory()
        {
            $is_login = (checkToken()) ? true : false;
            $user_item = getUser();
            $order_menu = new OrderMenu;
            $order_menu_list = $order_menu->getOneUserAllMenuId($user_item['user_id']);
            $order_detail = new OrderDetail;
            foreach ($order_menu_list as $index => $order_menu_item) {
                $order_menu_list[$index]['total_price'] = $order_detail->getOneMenuIdTotalPrice(
                    $order_menu_item['order_menu_id']
                );
            }
            $smarty = new Smarty;
            $smarty->assign('order_menu_list', $order_menu_list);
            $smarty->assign('permission', $user_item['permission']);
            $smarty->assign('is_login', $is_login);
            $smarty->display('../views/shopping_history.html');
        }

        /*
         * 訂單詳細資料頁面
         */
        public function GET_shoppingDetail()
        {
            $is_login = (checkToken()) ? true : false;
            $user_item = getUser();
            $order_menu_id = $this->id;
            $order_detail = new OrderDetail;
            $order_detail_list = $order_detail->getAllProduct($order_menu_id);
            $product = new Product;
            foreach ($order_detail_list as $index => $order_detail_item) {
                $product_item = $product->getOneProductWithoutDelete($order_detail_item['product_id']);
                $order_detail_list[$index]['image'] = $product_item['image'];
                $order_detail_list[$index]['name'] = $product_item['name'];
            }
            // var_dump($order_detail_list);
            $smarty = new Smarty;
            $smarty->assign('order_detail_list', $order_detail_list);
            $smarty->assign('permission', $user_item['permission']);
            $smarty->assign('is_login', $is_login);
            $smarty->display('../views/shopping_detail.html');
        }
    }

    $url_list = explode('/' , $_SERVER['REQUEST_URI']);
    $action = (isset($url_list[4])) ? $url_list[4] : '';
    $id = (isset($url_list[5])) ? $url_list[5] : '';
    $method = $_SERVER['REQUEST_METHOD'];
    $method_action = "{$method}_{$action}";
    new UserController($method_action, $id);