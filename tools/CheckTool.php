<?php
    class CheckTool 
    {
        private $account_patt = "/^[a-zA-Z][a-zA-Z0-9]{6,20}$/";
        private $password_patt = '/^[a-zA-Z0-9]{4,20}$/';
        // private $name_patt = '/^[\u4e00-\u9fa5]{2,3}$/';
        private $id_number_patt = '/^[A-Z][12]\d{8}$/';
        
        /*
         * 檢查註冊表單
         */
        public function checkSignupFormat($account, $password, $name, $id_number)
        {
            $result_account = $this->checkAccount($account);
            $result_password = preg_match($this->password_patt, $password);
            // $result_name = preg_match($this->name_patt, $name);
            $result_name = true;
            $result_id_number = $this->checkIdNumber($id_number);
            return ($result_account && $result_password && $result_name && $result_id_number) ? true : false;
        }

        
        /*
         * 檢查註冊表單
         */
        public function checkLoginFormat($account, $password)
        {
            $account_format_right=preg_match($this->account_patt, $account);
            if (!$account_format_right) {
                return false;
            }
            $result_password = preg_match($this->password_patt, $password);
            if (!$result_password) {
                return false;
            }
            return true;
        }
        
        /*
         * 檢查身分證號碼
         */
        public function checkIdNumber($id)
        {
            $result = false;
            $matt ='/^[A-Z][12][0-9]{8}$/';
            $checkchar = preg_match($matt, $id);

            if($checkchar){
                $replaceCode = "ABCDEFGHJKLMNPQRSTUVXYWZIO";
                $c1 = substr($id, 0, 1);
                $n12 = strpos($replaceCode, $c1) + 10;
                $n1 = (int)($n12/10);
                $n2 = $n12 % 10;
                $n3 = substr($id, 1, 1);
                $n4 = substr($id, 2, 1);
                $n5 = substr($id, 3 ,1);
                $n6 = substr($id, 4, 1);
                $n7 = substr($id, 5, 1);
                $n8 = substr($id, 6, 1);
                $n9 = substr($id, 7, 1);
                $n10 = substr($id, 8, 1);
                $n11 = substr($id, 9, 1);
                $sum = $n1 + $n2*9 + $n3 * 8 + $n4*7 + $n5*6 + $n6*5 + $n7*4 + $n8*3 + $n9*2 + $n10 + $n11;
                if($sum%10 == 0){
                    $result = true;
                }
            }
            return $result;
        }

        /*
         * 檢查帳號格式及是否重複
         */
        public function checkAccount($account)
        {
            $is_format_right=preg_match($this->account_patt, $account);
            if (!$is_format_right) {
                return false;
            }
            $user=new User;
            $user_account=$user->getAccount($account);
            ## 如果帳號不存在
            if (!$user_account) {
                return true;
            } else {
                return false;
            }

        }
    }