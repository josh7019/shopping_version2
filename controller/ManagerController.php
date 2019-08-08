<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '\shopping\model\all.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '\shopping\controller\controller.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '\shopping\smarty\smarty_init.php');
    
    
    

    class ManagerController extends Controller
    {
        private $id;
        public function __construct($action, $id)
        {
            $this->id = $id;
            if (method_exists($this, $action)) {
                $this->$action();
            } else {
                $action = 'getout';
                $this->$action();
            }
        }

        /*
         * 管理者登入
         */
        public function POST_login()
        {
            $account = $_POST['account'];
            $password = $_POST['password'];
            $check_tool = new CheckTool;
            $is_format_right = $check_tool->checkLoginFormat($account, $password);
            ## 檢查格式
            if (!$is_format_right){
                $data=[
                    'alert' => '格式錯誤',
                ];
                echo json_encode($data);
            }
            
            $manager = new Manager;
            $manager_item = $manager->getAccount($account);
            ## 搜尋帳號
            if (isset($manager_item['account'])){
                if (password_verify($password, $manager_item['password'])) {
                    $token = produceToken();
                    $manager->addToken($account, $token);
                    setcookie('token', $token, time() + 3600);
                    $data=[
                        'alert' => '管理者登入成功',
                        'location' => '/shopping/controller/PageController.php/index',
                    ];
                    echo json_encode($data);
                } else {
                    $data=[
                        'alert' => '密碼錯誤',
                    ];
                    echo json_encode($data);
                }
            }
        }

        /*
         * 產品管理頁面
         */
        public function GET_product()
        {
            $is_login = (checkToken()) ? true : false;
            $user_item = getUser();
            $product = new Product;
            $product_list = $product->getAllProduct();
            $smarty = new Smarty;
            $smarty->assign('product_list', $product_list);
            $smarty->assign('permission', $user_item['permission']);
            $smarty->assign('is_login', $is_login);
            $smarty->display('../views/manager_product.html');
        }
        
        /*
         * 刪除產品
         */
        public function DELETE_product()
        {
            // $product_id = $_POST['product_id'];
            parse_str(file_get_contents('php://input'), $_DELETE);
            $product_id = $_DELETE['product_id'];
            $product = new Product;
            $is_success = $product->deleteOne($product_id);
            if ($is_success) {
                $data = [
                    'alert' => '刪除成功',
                    'is_success' => true
                ];
                echo json_encode($data);
                exit();
            } else {
                $data = [
                    'alert' => '刪除失敗',
                    'is_success' => false
                ];
                echo json_encode($data);
                exit();
            }
        }

        /*
         * 修改產品
         */
        public function POST_product()
        {
            // $product_id = $_POST['product_id'];
            $product_id = $_POST['product_id'];
            $price = $_POST['price'];
            $status = $_POST['status'];
            $descript = $_POST['descript'];
            $name = $_POST['name'];
            $product = new Product;
            $is_success = $product->editOneProduct($name, $price, $status, $descript, $product_id);
            $product_item=$product->getOneProduct($product_id);
            uploadImage($product_item);
            if ($is_success) {
                $data = [
                    'alert' => '修改成功',
                    'is_success' => true,
                    'location' => '/shopping/controller/managercontroller.php/product'
                ];
                echo json_encode($data);
                exit();
            } else {
                $data = [
                    'alert' => '修改失敗',
                    'is_success' => false
                ];
                echo json_encode($data);
                exit();
            }
        }

        /*
         * 新增產品頁面
         */
        public function GET_addProduct()
        {
            $is_login = (checkToken()) ? true : false;
            $user_item = getUser();
            $smarty = new Smarty;
            $smarty->assign('permission', $user_item['permission']);
            $smarty->assign('is_login', $is_login);
            $smarty->display('../views/manager_add_product.html');
        }
        
        /*
         * 新增產品
         */
        public function POST_addProduct()
        {
            
            $name = $_POST['name'];
            $price = $_POST['price'];
            $status = $_POST['status'];
            $stock = $_POST['stock'];
            $descript = $_POST['descript'];
            $product = new Product;
            $is_success = $product->addProduct($name, $price, $status, $descript, $stock);
            $data = [
                'alert' => '新增產品成功',
                'location' => '/shopping/controller/managercontroller.php/product'
            ];
            $product_item = $product->getNewProductId();
            uploadImage($product_item);
            echo json_encode($data);
        }

        /*
         * 產品編輯頁面
         */
        public function GET_editProduct()
        {
            $is_login = (checkToken()) ? true : false;
            $user_item = getUser();
            $product = new Product();
            $product_item = $product->getOneProduct($this->id);
            $smarty = new Smarty;
            $smarty->assign('product_item', $product_item);
            $smarty->assign('permission', $user_item['permission']);
            $smarty->assign('is_login', $is_login);
            $smarty->display('../views/maneger_edit_product.html');
        }

         /*
         * 會員管理頁面
         */
        public function GET_member()
        {
            $is_login = (checkToken()) ? true : false;
            $user_item = getUser();
            $user = new User;
            $user_list = $user->getAllUser();
            $smarty = new Smarty;
            $smarty->assign('user_list', $user_list);
            $smarty->assign('permission', $user_item['permission']);
            $smarty->assign('is_login', $is_login);
            $smarty->display('../views/maneger_member.html');
        }

        /*
         * 會員權限修改
         */
        public function PUT_member()
        {
            parse_str(file_get_contents('php://input'), $_PUT);
            $user_id = $_PUT['user_id'];
            $permission = $_PUT['permission'];
            $user = new User;
            $is_success = $user->updatePermission($user_id, $permission);
            if ($is_success) {
                $data = [
                    'alert' => '修改成功',
                    'location' => '',
                    'is_success' => true,
                ];
            } else {
                $data = [
                    'alert' => '修改失敗',
                    'location' => '',
                    'is_success' => false,
                ];
            }
            echo json_encode($data);
        }

        /*
         * 訂單管理頁面
         */
        public function GET_orderMenu()
        {
            $is_login = (checkToken()) ? true : false;
            $user_item = getUser();
            $order_menu = new OrderMenu;
            $order_menu_list = $order_menu->getAllOrderMenu();
            $user = new User;
            $order_detail = new OrderDetail;
            foreach ($order_menu_list as $index => $order_menu_item) {
                $order_menu_list[$index]['total_price'] = $order_detail->getOneMenuIdTotalPrice(
                    $order_menu_item['order_menu_id']
                );
                $user_account = $user->getOneAccountByUserId($order_menu_item['user_id']);
                $order_menu_list[$index]['account'] = $user_account['account'];
            }

            $smarty = new Smarty;
            $smarty->assign('order_menu_list', $order_menu_list);
            $smarty->assign('permission', $user_item['permission']);
            $smarty->assign('is_login', $is_login);
            $smarty->display('../views/manager_order_menu.html');
        }
    }
    
    $url_list = explode('/',$_SERVER['REQUEST_URI']);
    $action = (isset($url_list[4])) ? $url_list[4] : '';
    $id = (isset($url_list[5])) ? $url_list[5] : '';
    $method = $_SERVER['REQUEST_METHOD'];
    $method_action = "{$method}_{$action}";
    new ManagerController($method_action, $id);

