<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/shopping/model/Model.php');

    class Product extends Model
    {
        private $table = 'product';

        /*
         * 新增一項產品
         */
        public function addProduct($name, $price, $status, $descript, $stock)
        {
            $is_success = $this->insertInto(
                $this->table,
                ['name', 'price', 'status', 'descript', 'stock'],
                [$name, $price, $status, $descript, $stock],
                'siisi'
            );
            return $is_success;
        }

        /*
         * 取得最新產品
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
            $product_list = $this->selectAllWithWhere($this->table, ['*'], ['status', 'is_delete'], [1, 0], 'ii');
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
         * 取得一項未刪除產品
         */
        public function getOneProduct($product_id)
        {
            $product_item = $this->selectSingleWithWhere(
                $this->table,
                ['*'],
                ['product_id', 'is_delete'],
                [$product_id, 0],
                'ii'
            );
            return $product_item;
        }

        /*
         * 取得一項產品
         */
        public function getOneProductWithoutDelete($product_id)
        {
            $product_item = $this->selectSingleWithWhere(
                $this->table,
                ['*'],
                ['product_id'],
                [$product_id],
                'i'
            );
            return $product_item;
        }

        /*
         * 取得一項未刪除且未下架產品
         */
        public function getOneProductOnSale($product_id)
        {
            $product_item = $this->selectSingleWithWhere(
                $this->table,
                ['*'],
                ['product_id', 'status','is_delete'],
                [$product_id, 1, 0],
                'iii'
            );
            return $product_item;
        }

        /*
         * 修改一項產品
         */

        public function editOneProduct($name, $price, $status, $descript, $stock, $product_id)
        {
            $is_success = $this->update(
                $this->table,
                ['name', 'price', 'status', 'descript', 'stock'],
                [$name, $price, $status, $descript, $stock],
                ['product_id'],
                [$product_id],
                'siisii'
            );
            return $is_success;
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
