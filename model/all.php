<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/shopping/model/User.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/shopping/model/manager.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/shopping/tools/CheckTool.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/shopping/model/Product.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/shopping/model/OrderDetail.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/shopping/model/OrderMenu.php');
    
    /*
     * 產生token
     */
    function produceToken()
    {
        $random_string = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $token_string = '';
        for ($i=0; $i<250; $i++) {
            $token_string .= substr($random_string, rand(0, strlen($random_string)-1), 1);
        }
        return $token_string;
    }
    
    /*
     * 檢查token
     */
    function checkToken()
    {
        if (isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
            $user_model = new User;
            $user_item = $user_model->getUserByToken($token);
            if ($user_item['account']) {
                return true;
            } else {
                setcookie ("token", "delete", time()-100);
                return false;
            }
        } else {
            return false;
        }
    }

    /*
     * 檢查token並回傳資料
     */
    function getUser()
    {
        if(checkToken()){
            if (isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
            $user_model = new User;
            $user_item = $user_model->getUserByToken($token);
            if ($user_item['user_id']) {
                return $user_item;
            }
        }
        }
        
    }


    function uploadImage($product_item){
        $files = $_FILES["image"];
        $product = new Product;
            // echo json_encode($files);
        if (!$files["error"]) {//判斷是否有誤
            //判斷圖片格式及大小
            if (($files["type"] == "image/png" || $files["type"] == "image/jpeg") && $files["size"] < 10240000) {
                //存放位置及檔名
                $file_type = (preg_match('/.jpg$/', $files['name'])) ? ".jpg" : ".png";
                $filename = 'product_id=' . $product_item['product_id'] . $file_type;
                $filepath = $_SERVER['DOCUMENT_ROOT']."/shopping/img/" . $filename;
                //檢查目錄是否存在
                if (!file_exists($filepath)) {
                    $is_upload=move_uploaded_file($files["tmp_name"], $filepath);//存放檔案
                    $product->updateImage($product_item['product_id'], $filename);
                    $data = [
                        'alert' => '新增產品及圖片成功',
                        'location' => '/shopping/controller/managercontroller.php/product',
                        'is_success' => true,
                    ];
                    echo json_encode($data);
                    exit();
                } else {
                    $is_upload=move_uploaded_file($files["tmp_name"], $filepath);//存放檔案
                    $product->updateImage($product_item['product_id'], $filename);
                    $data = [
                        'alert' => '修改產品及圖片成功',
                        'location' => '/shopping/controller/managercontroller.php/product',
                        'is_success' => true,
                    ];
                    echo json_encode($data);
                    exit();
                }
            }    
        }
    }

    /*
     * 檢查並更新購物車
     */
    function checkAndGetOrderMenuId($user_item)
    {
        $user = new User;
        $order_menu = new OrderMenu;
        $order_menu_item = $order_menu->getLastListByUserId($user_item['user_id']);
        if (isset($order_menu_item['user_id'])) {
            // $user->updateOrderMenuId($user_item['user_id'], $order_menu_item['order_menu_id']);
            return $order_menu_item['order_menu_id'];
        } else {
            $is_success = $order_menu->addList($user_item['user_id']);
            if ($is_success) {
                $order_menu_item = $order_menu->getLastListByUserId($user_item['user_id']);
                // $user->updateOrderMenuId($user_item['user_id'], $order_menu_item['order_menu_id']);
                return $order_menu_item['order_menu_id'];
            }
        }
    }

    /*
     * 取得總價
     */
    function getTotalPrice($order_menu_id)
    {
        $total_price = 0;
        $order_detail = new OrderDetail;
        $order_detail_list = $order_detail->getAllProduct($order_menu_id);
        $product = new Product;
        foreach ($order_detail_list as $order_detail_item) {
            $product_item = $product->getOneProductOnSale($order_detail_item['product_id']);
            if (!isset($product_item['price'])) {continue;}
            $total_price += $product_item['price'] * $order_detail_item['amount'];
        }
        return $total_price;
    }
    
    /*
     * 寫上結帳價格
     */
    function updateDealPrice($order_menu_id)
    {
        $order_detail = new OrderDetail;
        $order_detail_list = $order_detail->getAllProduct($order_menu_id);
        $product = new Product;
        foreach ($order_detail_list as $order_detail_item) {
            $product_item = $product->getOneProductOnSale($order_detail_item['product_id']);
            if (!isset($product_item['price'])) {continue;}
            $order_detail->updateDealPrice($product_item['price'], $order_menu_id, $order_detail_item['product_id']);
        }
    }
