<?php

include_once("db.php");

class Inventory {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getInventory() {
        $sql = "SELECT 
                invoice_number, 
                items.name AS name,
                inventory.item_id AS item_id,
                added_stock_old, 
                added_stock_new, 
                purchased_date
            FROM inventory
            INNER JOIN items ON inventory.item_id = items.item_id
            ORDER BY invoice_number DESC
            LIMIT 10;
        ";

        try {
            return $this->conn->query($sql);
        } catch (mysqli_sql_exception $e) {
            include("partials/failed.php");
        }
    }

    public function addToInventory ($item_id, $added_stock_old, $added_stock_new) {
        $sql = "
            INSERT INTO inventory (item_id, added_stock_old, added_stock_new) 
            VALUES ('$item_id', $added_stock_old, $added_stock_new)
        ";

        $addToItemSql = "
            UPDATE items 
            SET old_stock=old_stock + $added_stock_old,
                new_stock=new_stock + $added_stock_new
            WHERE item_id='$item_id'
        ";

        try {
            $this->conn->query($sql);
            $this->conn->query($addToItemSql);
        } catch (mysqli_sql_exception $e) {
            include("partials/failed.php");
        }
    }


    public function deleteFromInventory(int $invoice_number, $item_id, $added_stock_old, $added_stock_new) {
        $sql = "DELETE FROM inventory WHERE invoice_number=$invoice_number";

        $removeFromItemSql = "
            UPDATE items 
            SET old_stock=old_stock - $added_stock_old,
                new_stock=new_stock - $added_stock_new
            WHERE item_id='$item_id'
        ";

        try {
            $this->conn->query($sql);
            $this->conn->query($removeFromItemSql);
        } catch (mysqli_sql_exception $e) {
            include("partials/failed.php");
        }
    }
}

$inventory = new Inventory($conn);