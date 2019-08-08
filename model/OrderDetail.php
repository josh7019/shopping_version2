<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/shopping/model/Model.php');

    class OrderDetail extends Model
    {
        private $table = 'order_detail';

        /*
         * 藉由order_menu_id取得清單中所有物品
         */
        public function getAllProduct($order_menu_id)
        {
            $order_detail_list = $this->selectAllWithWhere(
                $this->table,
                ['*'],
                ['order_menu_id'],
                [$order_menu_id],
                'i'
            );
            return $order_detail_list;
        }
        
        /*
         * 藉由order_menu_id取得清單中所有物品id
         */
        public function getAllProductId($order_menu_id)
        {
            $product_id_list = $this->selectAllWithWhere(
                $this->table,
                ['product_id'],
                ['order_menu_id'],
                [$order_menu_id],
                'i'
            );
            return $product_id_list;
        }

        /*
         * 新增產品到購物車
         */
        public function addProduct($order_menu_id, $product_id)
        {
            $is_success = $this->insertInto(
                $this->table,
                ['order_menu_id', 'product_id'],
                [$order_menu_id, $product_id],
                'ii'
            );
            return $is_success;
        }

        /*
         * 藉由order_menu_id,product_id取得單一產品筆數
         */
        public function getOneCount($order_menu_id, $product_id)
        {
            $product_count = $this->selectSingleWithWhere(
                $this->table,
                ['count(*)'],
                ['order_menu_id', 'product_id'],
                [$order_menu_id, $product_id],
                'ii'
            );
            return $product_count;
        }

        /*
         * 藉由order_menu_id,product_id取得單一產品
         */
        public function getOne($order_menu_id, $product_id)
        {
            $product_count = $this->selectSingleWithWhere(
                $this->table,
                ['*'],
                ['order_menu_id', 'product_id'],
                [$order_menu_id, $product_id],
                'ii'
            );
            return $product_count;
        }

        /*
         * 刪除購物車的一項產品
         */
         public function deleteOne($order_menu_id, $product_id)
         {
            $is_success = $this->delete(
                $this->table,
                ['order_menu_id', 'product_id'],
                [$order_menu_id, $product_id],
                'ii'
            );
            return $is_success;
         }

         /*
         * 修改購物車的一項產品數量
         */
        public function updateAmount($amount, $order_menu_id, $product_id)
        {
            $is_success = $this->update(
                $this->table,
                ['amount'],
                [$amount],
                ['order_menu_id', 'product_id'],
                [$order_menu_id, $product_id],
                'iii'
            );
            return $is_success;
        }

        /*
         * 修改購物車的一項產品結帳價格
         */
        public function updateDealPrice($deal_price, $order_menu_id, $product_id)
        {
            $is_success = $this->update(
                $this->table,
                ['deal_price'],
                [$deal_price],
                ['order_menu_id', 'product_id'],
                [$order_menu_id, $product_id],
                'iii'
            );
            return $is_success;
        }

        /*
         * 取得同一訂單結帳後總金額
         */
        public function getOneMenuIdTotalPrice($order_menu_id)
        {
            $total_price = $this->selectSingleWithWhere(
                $this->table,
                ['sum(deal_price*amount) as total_price'],
                ['order_menu_id'],
                [$order_menu_id],
                'i'
            );
            return $total_price['total_price'];
        }
    }