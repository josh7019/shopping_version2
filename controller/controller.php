<?php
    
    class Controller
    {
        public function isGet()
        {
            if (!$_SERVER['REQUEST_METHOD'] == 'GET') {
                $date = [
                    'alert' => '錯誤請求'
                ];
                echo json_encode($date);
                exit();
            }
        }

        public function isPost()
        {
            if (!$_SERVER['REQUEST_METHOD'] == 'POST') {
                $date = [
                    'alert' => '錯誤請求'
                ];
                echo json_encode($date);
                exit();
            }
        }


        public function isPut()
        {
            if (!$_SERVER['REQUEST_METHOD'] == 'PUT') {
                $date = [
                    'alert' => '錯誤請求'
                ];
                echo json_encode($date);
                exit();
            }
        }


        public function isDelete()
        {
            if (!$_SERVER['REQUEST_METHOD'] == 'DELETE') {
                $date = [
                    'alert' => '錯誤請求'
                ];
                echo json_encode($date);
                exit();
            }
        }
    }
    