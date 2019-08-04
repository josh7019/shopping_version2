<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/shopping/model/User.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/shopping/model/manager.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/shopping/tools/CheckTool.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/shopping/model/Product.php');
    
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
     * 檢查token並回傳資料
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
    function getToken()
    {
        if (isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
            $user_model = new User;
            $user_item = $user_model->getUserByToken($token);
            if ($user_item['user_id']) {
                return $user_item;
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
                    $filepath = "../img/" . $filename;
                    //檢查目錄是否存在
                    if (!file_exists($filepath)) {
                        $is_upload=move_uploaded_file($files["tmp_name"], $filepath);//存放檔案
                        $product->updateImage($product_item['product_id'], $filename);
                        $data = [
                            'alert' => '新增產品及圖片成功',
                            'location' => '/shopping/controller/managerpagecontroller.php/product'
                        ];
                        echo json_encode($data);
                        exit();
                    } else {
                        $is_upload=move_uploaded_file($files["tmp_name"], $filepath);//存放檔案
                        $product->updateImage($product_item['product_id'], $filename);
                        $data = [
                            'alert' => '修改圖片成功',
                            'location' => '/shopping/controller/managerpagecontroller.php/product'
                        ];
                        echo json_encode($data);
                        exit();
                    }
                }    
            }
    }
