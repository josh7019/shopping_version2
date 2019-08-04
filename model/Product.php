<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/shopping/model/Model.php');

    class Product extends Model
    {
        private $table = 'product';

        /*
         * 新增一項產品
         */
        public function addProduct($name, $price, $status, $descript)
        {
            $is_success = $this->insertInto(
                $this->table,
                ['name', 'price', 'status', 'descript'],
                [$name, $price, $status, $descript],
                'siis'
            );
            return $is_success;
        }

        /*
         * 取得最新產品id
         */
        public function getNewProductId()
        {
            $product_item = $this->selectLastOne($this->table, ['product_id'], 'product_id');
            return $product_item;
        }

        /*
         * 更新圖片
         */
        public function updateImage($product_id, $image)
        {
            $is_success = $this->update($this->table, ['image'], [$image], ['product_id'], [$product_id], 'si');
            return $is_success;
        }

        /*
         * 取得所有售賣中產品
         */
        public function getAllProductOnSale()
        {
            $product_list = $this->selectAllWithWhere($this->table, ['*'], ['status'], [1], 'i');
            return $product_list;
        }

        /*
         * 取得所有產品
         */
        public function getAllProduct()
        {
            $product_list = $this->selectAllWithWhere($this->table, ['*'], ['is_delete'], [0], 'i');
            return $product_list;
        }

        /*
         * 軟刪除一項產品
         */
        public function deleteOne($product_id)
        {
            $is_success = $this->update($this->table, ['is_delete'], [1], ['product_id'], [$product_id], 'ii');
            return $is_success;
        }
    }
