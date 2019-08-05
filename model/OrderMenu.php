<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/shopping/model/Model.php');

    class OrderMenu extends Model
    {
        private $table = 'Order_menu';

        /*
         * 新增一筆訂單(購物車)
         */
        public function addList($user_id)
        {
            $is_success = $this->insertInto($this->table, ['user_id'], [$user_id], 'i');
            return $is_success;
        }

        /*
         * 藉由user_id取得一筆未結帳訂單(購物車)
         */
        public function getLastListByUserId($user_id)
        {
            $order_menu_item = $this->selectLastOneWithWhere(
                $this->table,
                ['*'],
                ['user_id', 'is_checkout'],
                [$user_id, 0],
                'ii',
                'order_menu_id'
            );
            return $order_menu_item;
        }
    }
