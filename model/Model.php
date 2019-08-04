<?php

    class Model 
    {
        private $server = "localhost";
        private $user = 'root';
        private $password = '';
        private $db_name = 'shopping';
        private $mysqli;

        public function __construct()
        {
            date_default_timezone_set('Asia/Taipei');
            $this->mysqli = new mysqli($this->server, $this->user, $this->password, $this->db_name);
            $this->mysqli->set_charset('utf8');
        }

        /*
         * 取得全部資料
         */
        public function selectAll($table, $select_list){
            $select_string = '';
            foreach ($select_list as $select_single) {
                $select_string .= $select_single.',';
            }

            $select_string = substr($select_string, 0, strlen($select_string)-1);
            $sql = "select {$select_string} from {$table}";
            $pre = $this->mysqli->prepare($sql);
            $pre->execute();
            $result = $pre->get_result();
            $resultList = [];
            $resultItem = [];
                while ($row = $result->fetch_assoc()) {
                    foreach ($row as $key => $value) {
                        $resultItem[$key] = $value;
                    }
                    $resultList[] = $resultItem;
                }
            return $resultList;
        }

        /*
         * 取得全部資料
         */
        public function selectLastOne($table, $select_list, $order_by_colum){
            $select_string = '';
            foreach ($select_list as $select_single) {
                $select_string .= $select_single.',';
            }

            $select_string = substr($select_string, 0, strlen($select_string)-1);
            $sql = "select {$select_string} from {$table} order by {$order_by_colum} desc limit 1";
            $pre = $this->mysqli->prepare($sql);
            $pre->execute();
            $result = $pre->get_result();
            $resultItem = [];
                $row = $result->fetch_assoc();
                    foreach ($row as $key => $value) {
                        $resultItem[$key] = $value;
                    }
                    $resultItem;
            return $resultItem;
        }

        /*
         * 使用where取得多筆資料
         */
        public function selectAllWithWhere($table, $select_list, $where_colum_list, $where_value_list, $type_string)
        {
            $where_colum_string = '';
            $where_value_string = '';
            $select_string = '';
            ## 組成select字串
            foreach ($select_list as $select_single) {
                $select_string .= $select_single.',';
            }
            ## 組成where字串
            foreach ($where_colum_list as $where_colum) {
                $where_colum_string .= $where_colum.',';
            }
            foreach ($where_value_list as $where_value) {
                $where_value_string .= '?,';
            }
            ## 去逗號
            $where_colum_string = substr($where_colum_string, 0, strlen($where_colum_string)-1);
            $where_value_string = substr($where_value_string, 0, strlen($where_value_string)-1);
            $select_string = substr($select_string, 0, strlen($select_string)-1);
            ## 組成sql語法
            $sql = "select $select_string from $table 
            where ({$where_colum_string})  =  ($where_value_string)";
            $pre = $this->mysqli->prepare($sql);
            $pre->bind_param($type_string,...$where_value_list);
            $pre->execute();
            $result = $pre->get_result();
            $resultList = [];
            $resultItem = [];
                while ($row = $result->fetch_assoc()) {
                    foreach ($row as $key => $value) {
                        $resultItem[$key] = $value;
                    }
                    $resultList[] = $resultItem;
                }
            return $resultList;
        }

        /*
         * 使用where取得單一筆資料
         */
        public function selectSingleWithWhere($table, $select_list, $where_colum_list, $where_value_list, $type_string)
        {
            $where_colum_string = '';
            $where_value_string = '';
            $select_string = '';
            ## 組成select字串
            foreach ($select_list as $select_single) {
                $select_string .= $select_single.',';
            }
            ## 組成where字串
            foreach ($where_colum_list as $where_colum) {
                $where_colum_string .= $where_colum.',';
            }
            foreach ($where_value_list as $where_value) {
                $where_value_string .= '?,';
            }
            ## 去逗號
            $where_colum_string = substr($where_colum_string, 0, strlen($where_colum_string)-1);
            $where_value_string = substr($where_value_string, 0, strlen($where_value_string)-1);
            $select_string = substr($select_string, 0, strlen($select_string) - 1);
            ## 組成sql語法
            $sql = "select $select_string from $table 
            where ({$where_colum_string})  =  ($where_value_string)";
            $pre = $this->mysqli->prepare($sql);
            $pre->bind_param($type_string, ...$where_value_list);
            $pre->execute();
            $result = $pre->get_result();
            $resultItem = [];
                while ($row = $result->fetch_assoc()) {
                    foreach ($row as $key => $value) {
                        $resultItem[$key] = $value;
                    }
                }
            return $resultItem;
        }


        /*
         * 新增一筆資料
         */
        public function insertInto($table, $insert_colum_list, $insert_value_list, $type_string)
        {  
            $insert_colum_string = '';
            $insert_value_string = '';
            ## 組成insert字串
                foreach ($insert_colum_list as $insert_colum) {
                    $insert_colum_string .= $insert_colum.',';
                }
                $insert_colum_string = substr($insert_colum_string, 0, strlen($insert_colum_string)-1);
                
                foreach ($insert_value_list as $insert_value) {
                    $insert_value_string .= '?,';
                }
            ## 去掉尾端逗號
            $insert_value_string = substr($insert_value_string, 0, strlen($insert_value_string)-1);
            $sql = "insert into {$table} ({$insert_colum_string}) values ({$insert_value_string})";
            $pre = $this->mysqli->prepare($sql);
            $pre->bind_param($type_string, ...$insert_value_list);
            $pre->execute();
            return $pre->affected_rows;
        }

        /*
         * 刪除一筆資料
         */
        public function delete($table, $where_colum_list, $where_value_list, $type_string)
        {
            $where_colum_string = '';
            $where_value_string = '';
            ## 組成where字串
                foreach ($where_colum_list as $where_colum) {
                    $where_colum_string .= $where_colum.',';
                }
                foreach ($where_value_list as $where_value) {
                    $where_value_string .= '?,';
                }
            ## 去逗號
            $where_colum_string = substr($where_colum_string, 0, strlen($where_colum_string)-1);
            $where_value_string = substr($where_value_string, 0, strlen($where_value_string)-1);
            $sql = "delete from $table where ($where_colum_string)  =  ($where_value_string)";
            $pre = $this->mysqli->prepare($sql);
            $pre->bind_param($type_string, ...$where_value_list);
            $pre->execute();
            return $pre->affected_rows;
        }

        /*
         * 修改一筆資料
         */
        public function update(
            $table,
            $set_colum_list,
            $set_value_list,
            $where_colum_list,
            $where_value_list,
            $type_string
        )
        {
            $set_colum_string = '';
            $where_colum_string = '';
            $where_value_string = '';
            ## 組成set字串
                foreach ($set_colum_list as $set_colum) {
                    $set_colum_string .= $set_colum.' = ?,';
                }
            ## 組成where字串
                foreach ($where_colum_list as $where_colum) {
                    $where_colum_string .= $where_colum.',';
                }
                foreach ($where_value_list as $where_value) {
                    $where_value_string .= '?,';
                }
            ## 去逗號
            $where_colum_string = substr($where_colum_string, 0, strlen($where_colum_string)-1);
            $where_value_string = substr($where_value_string, 0, strlen($where_value_string)-1);
            $set_colum_string = substr($set_colum_string, 0, strlen($set_colum_string)-1);
            $sql = "update $table set $set_colum_string where ($where_colum_string)  =  ($where_value_string)";
            $pre = $this->mysqli->prepare($sql);
            $pre->bind_param($type_string, ...$set_value_list, ...$where_value_list);
            $pre->execute();
            return $pre->affected_rows;
        }

    }
