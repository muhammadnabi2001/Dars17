<?php
namespace App\Interface;
    interface InterfaceModel
    {
        public function connect();
        public function all();
        public function show($id);
        public function create($data);
        public function update(array $data,int $id);
        public function delete(int $id);
        public function detect($email);
        public function where($word);
        public function attach($data);
    }
    ?>