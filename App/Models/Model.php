<?php
namespace App\Models;
use PDO;
use App\Interface\InterfaceModel;
abstract class Model implements InterfaceModel
{
    public static $table;

    public function connect()
    {
        $db = new PDO("mysql:host=localhost;dbname=php_darslar", "root", "root");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    }
    public function all()
    {
        $sql = "SELECT * FROM " . static::$table;
        $query = self::connect()->query($sql);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function show($id)
    {
        $sql = "SELECT * FROM " . static::$table . "  WHERE id='{$id}'";
        $query = self::connect()->query($sql);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function create($data)
    {
        $columns = implode(", ", array_keys($data));
        $values = "'" . implode("','", array_values($data)) . "'";
        $query = "INSERT INTO " . static::$table . " ({$columns})  VALUES ({$values})";
        $stmt = self::connect()->prepare($query);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function update(array $data, int $id)
    {
        $setParts = [];
        $params = [];

        foreach ($data as $key => $value) {
            $setParts[] = "{$key} = :{$key}";
            $params[":{$key}"] = $value;
        }

        $cleanedString = implode(", ", $setParts);

        $query = "UPDATE " . static::$table . " SET {$cleanedString} WHERE id = :id";

        $params[':id'] = $id;

        $stat = self::connect()->prepare($query);

        foreach ($params as $key => $value) {
            $stat->bindValue($key, $value);
        }

        return $stat->execute();
    }

    public function delete(int $id)
    {
        $query = "DELETE FROM " . static::$table . " WHERE id = {$id}";
        $stat = self::connect()->prepare($query);
        if ($stat->execute()) {
            header("location: index.php");
        } else {
            return false;
        }
    }
    public function detect($email)
    {
        $query = "SELECT * FROM " . static::$table . " WHERE email = '{$email}'";
        $stat = self::connect()->query($query);
        $data=$stat->fetchAll(PDO::FETCH_ASSOC);
        if ($stat->execute()) {
            return $data;
        }
    }
    public function where($word)
    {
        $sql = "SELECT * FROM " . static::$table . " WHERE name LIKE :word OR price LIKE :word or quantity LIKE :word";
        $stmt = self::connect()->prepare($sql);

        $search = "%$word%";
        $stmt->bindParam(':word', $search);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function attach($data)
    {
        $stringValue = "";
        foreach ($data as $key => $value) {
            if ($key == "password") {
                $value = md5($value);
            }
            $stringValue = $stringValue . " {$key}= '{$value}' AND ";
        }
        $cleanedString = rtrim($stringValue, "AND ");

        $db = self::connect();
        $stmt = $db->query("SELECT * FROM " . static::$table . " WHERE {$cleanedString}");
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

}
