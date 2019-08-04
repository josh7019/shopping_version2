<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/shopping/model/Model.php');

    class User extends Model 
    {
        private $table = 'user';

        public function getAccount($account)
        {
            $user_item = $this->selectSingleWithWhere($this->table, ['*'], ['account'], [$account], 's');
            return $user_item;
        }

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

        public function addToken($account, $token)
        {
            $is_success = $this->update($this->table, ['token'], [$token], ['account'], [$account], 'ss');
            return $is_success;
        }

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

        public function getAllUser()
        {
            $user_list = $this->selectAll(
                $this->table,
                ['user_id', 'account', 'id_number', 'name', 'cash', 'permission', 'created_at', 'updated_at']
            );
            return $user_list;
        }
    }
    