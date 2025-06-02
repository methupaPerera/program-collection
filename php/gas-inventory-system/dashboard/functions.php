<?php

include_once("db.php");

class Item {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getItems() {
        $sql = "SELECT * FROM items";

        try {
            return $this->conn->query($sql);
        } catch (mysqli_sql_exception $e) {
            include("partials/failed.php");
        }
    }

    public function addNewItem ($item_id, $name, $old_stock_price, $new_stock_price) {
        $sql = "
            INSERT INTO items (item_id, name, old_stock_price, new_stock_price) 
            VALUES ('$item_id', '$name', $old_stock_price, $new_stock_price)
        ";

        try {
            $this->conn->query($sql);
        } catch (mysqli_sql_exception $e) {
            include("partials/failed.php");
        }
    }

    public function updateItem($item_id, $name, $old_stock_price, $new_stock_price) {
        $sql = "
            UPDATE items 
            SET name='$name', 
                old_stock_price=$old_stock_price, 
                new_stock_price=$new_stock_price 
            WHERE item_id='$item_id'";
            
        try {
            $this->conn->query($sql);
            include("partials/success.php");
        } catch (mysqli_sql_exception $e) {
            include("partials/failed.php");
        }
    }

    public function deleteItem($item_id) {
        $sql = "DELETE FROM items WHERE item_id='$item_id'";

        try {
            $this->conn->query($sql);
        } catch (mysqli_sql_exception $e) {
            include("partials/failed.php");
        }
    }
}

$item = new Item($conn);