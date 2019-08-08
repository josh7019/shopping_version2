<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/shopping/model/Model.php');

    class User extends Model 
    {
        private $table = 'user';

        /*
         * 取得帳號所有資料
         */
        public function getAccount($account)
        {
            $user_item = $this->selectSingleWithWhere($this->table, ['*'], ['account'], [$account], 's');
            return $user_item;
        }

        /*
         * 註冊
         */
        public function signup($account, $password, $name, $id_number)
        {
            $is_success = $this->insertInto(
                $this->table,
                ['account', 'password', 'name', 'id_number'],
                [$account, $password, $name, $id_number],
                'ssss'
            );
            return $is_success;
        }

        /*
         *  更新token
         */
        public function addToken($account, $token)
        {
            $is_success = $this->update($this->table, ['token'], [$token], ['account'], [$account], 'ss');
            return $is_success;
        }

        /*
         * 藉由token取得使用者資訊
         */
        public function getUserByToken($token)
        {
            $user_item = $this->selectSingleWithWhere(
                $this->table,
                ['user_id', 'account', 'id_number', 'name', 'cash', 'permission', 'created_at', 'updated_at'],
                ['token'],
                [$token],
                's'
            );
            return $user_item;
        }

        /*
         * 取得所有使用者資訊
         */
        public function getAllUser()
        {
            $user_list = $this->selectAll(
                $this->table,
                ['user_id', 'account', 'id_number', 'name', 'cash', 'permission', 'created_at', 'updated_at']
            );
            return $user_list;
        }

        /*
         * 更新權限
         */
        public function updatePermission($user_id, $permission)
        {
            $is_success = $this->update(
                $this->table,
                ['permission'],
                [$permission],
                ['user_id'],
                [$user_id],
                'ii'
            );
            return $is_success;
        }

        /*
         * 更新使用中購物車
         */
        public function updateOrderMenuId($user_id, $order_menu_id)
        {
            $is_success = $this->update(
                $this->table,
                ['order_menu_id'],
                [$order_menu_id],
                ['user_id'],
                [$user_id],
                'ii'
            );
            return $is_success;
        }

        /*
         * 結帳
         */
        public function checkout($cash, $user_id)
        {
            $is_success = $this->update(
                $this->table,
                ['cash'],
                [$cash],
                ['user_id'],
                [$user_id],
                'ii'
            );
            return $is_success;
        }

        /*
         * 結帳
         */
        public function getOneAccountByUserId($user_id)
        {
            $is_success = $this->selectSingleWithWhere(
                $this->table,
                ['account'],
                ['user_id'],
                [$user_id],
                'i'
            );
            return $is_success;
        }
    }
    