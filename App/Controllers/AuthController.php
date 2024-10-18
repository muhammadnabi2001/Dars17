<?php

namespace App\Controllers;

use App\Helpers\Views;
use App\Models\Product;
use App\Models\User;
use App\Models\Task;

class Authcontroller
{
    public function __construct()
    {
        //layout(loginMain);
    }
    public function loginpage()
    {
        //dd(123);
        return view('login', 'Login');
    }
    public function json()
    {
        $b=new Product();
        $mahsulot=$b->all();
        header("Content-Type: application/json"); 
        echo json_encode(["mahsulot"=>$mahsulot],JSON_PRETTY_PRINT);
        exit;
    }
    public function product()
    {
        if (isset($_POST['ok'])) {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $data = explode('.', $_FILES['image']['name']);
            $filePath = date('Y-m-d_H-i-s') . '.' . $data[1];
            move_uploaded_file($_FILES['image']['tmp_name'], 'rasm/' . $filePath);
            $product = [
                'name' => $name,
                'price' => $price,
                'quantity' => $_POST['quantity'],
                'image' => $filePath
            ];
            $help=new Product();

            $help->create($product);
            header("location: /product");
        }
    }
    public function userpage()
    {
        if (isset($_SESSION['Auth'])) {
            return view('user', 'User');
        } else {
            header("location: /login");
        }
    }
    public function admin()
    {
        // dd(123);
        return view('admin', 'Admin');
    }
    public function registerPage()
    {
        return view('/register', 'Register');
    }
    
    public function register()
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];
        if ($password1 != $password2) {
            header("location: /register");
        } else {
            if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password1']) && isset($_POST['password2'])) {
                $password = md5($password1);

                $data = [
                    'name' => $_POST['name'],
                    'email' => $_POST['email'],
                    'password' => $password,
                    'status' => 'user'
                ];
                $ch = new User();
                $check = $ch->detect($email);
                if ($check) {
                    header("location: /register");
                } else {
                    $create = new User();
                    $create->create($data);
                    return view('product', "Product");
                }
            }
        }
    }
    public function login()
    {
        $data = [
            'email' => $_POST['email'],
            'password' => $_POST['password']
        ];
        $a = new User();
        $user = $a->attach($data);
        if ($user->status == "admin") {
            $_SESSION['Auth'] = $user;
            return view('product', 'Product');
        }
        if ($user->status == 'user') {
            $_SESSION['Auth'] = $user;
            return view('product', "Product");
        } else {
            $_SESSION['message'] = 'email yoki password xato';
            header('location: /');
        }
    }
    public function logout()
    {
        unset($_SESSION['Auth']);
        header("location: /index");
    }
}
