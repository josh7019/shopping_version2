<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '\shopping\model\all.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '\shopping\controller\controller.php');
    $url_list = explode('/',$_SERVER['REQUEST_URI']);
    $action = (isset($url_list[4])) ? $url_list[4] : '';
    $id = (isset($url_list[5])) ? $url_list[5] : '';
    
    new ManagerController($action, $id);

    class ManagerController
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
            // parent::__construct();
        }

        /*
         * 管理者登入
         */
        public function login()
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
                        'location' => 'PageController.php/index',
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
         * 新增產品
         */
        public function addProduct()
        {
            
            $name = $_POST['name'];
            $price = $_POST['price'];
            $status = $_POST['status'];
            $descript = $_POST['descript'];
            $product = new Product;
            $is_success = $product->addProduct($name, $price, $status, $descript);
            $data = [
                'alert' => '新增產品成功',
                'location' => '/shopping/controller/managerpagecontroller.php/product'
            ];
            $product_item = $product->getNewProductId();
            uploadImage($product_item);
            echo json_encode($data);
        }
        
        /*
         * 刪除產品
         */
        public function deleteProduct()
        {
            $product_id = $_POST['product_id'];
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
    }
