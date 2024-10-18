<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Janrlar;
use App\Models\Kitoblar;
use PDO;

class CategoryController
{
    public function index()
    {
        $con = new PDO("mysql:host=localhost;dbname=php_darslar", 'root', 'root');
        $sql = "SELECT muallif.id,muallif.fio,COUNT(kitoblar.muallif_id) AS soni FROM muallif LEFT JOIN kitoblar ON muallif.id=kitoblar.muallif_id GROUP BY muallif.id";
        $st = $con->query($sql);
        $muallif = $st->fetchAll(PDO::FETCH_ASSOC);
        return view('index', 'Home', $muallif);
    }
    public function janrlar()
    {
        $con = new PDO("mysql:host=localhost;dbname=php_darslar", 'root', 'root');
        $sql = "SELECT janr.id,janr.name,COUNT(kitoblar.janr_id) AS soni FROM janr LEFT JOIN kitoblar ON janr.id=kitoblar.janr_id GROUP BY janr.id";
        $st = $con->query($sql);
        $janrlar = $st->fetchAll(PDO::FETCH_ASSOC);
        return view('janrlar', 'janrlar', $janrlar);
    }
    public function logout()
    {
        return view('index','Login');
    }
}
