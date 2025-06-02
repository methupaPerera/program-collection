<?php

include_once("db.php");

class Checkout {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getCheckouts() {
        $sql = "
            SELECT 
                serial,
                checkouts.customer_id AS customer_id,
                customers.name AS name,
                checkouts.item_id AS item_id,
                type,
                returned,
                checkedout_date AS date,
                CASE 
                    WHEN type = 'new' THEN items.new_stock_price
                    WHEN type = 'old' THEN items.old_stock_price
                END AS price
            FROM checkouts 
            INNER JOIN customers ON checkouts.customer_id=customers.customer_id 
            INNER JOIN items ON checkouts.item_id=items.item_id
            ORDER BY serial DESC LIMIT 10";

        try {
            return $this->conn->query($sql);
        } catch (mysqli_sql_exception $e) {
            include("partials/failed.php");
        }
    }

    public function addNewCheckout($customer_id, $item_id, $type) {
        $sql = "
            INSERT INTO checkouts (customer_id, item_id, type) 
            VALUES ('$customer_id', '$item_id', '$type')
        ";

        $updateItemSql = $type === "new" ? "
            UPDATE items 
            SET new_stock = new_stock - 1,
                borrowed_new_stock = borrowed_new_stock + 1 
            WHERE item_id = '$item_id'
        " : "
            UPDATE items 
            SET old_stock = old_stock - 1,
                borrowed_old_stock = borrowed_old_stock + 1 
            WHERE item_id = '$item_id'
        ";

        try {
            $this->conn->begin_transaction();

            $this->conn->query($sql);
            $this->conn->query($updateItemSql);

            $this->conn->commit();
        } catch (mysqli_sql_exception $e) {
            $this->conn->rollback();
            include("partials/failed.php");
        }
    }

    public function deleteCheckout($serial, $item_id, $type) {
        $sql = "DELETE FROM checkouts WHERE serial=$serial";

        $updateItemSql = $type === "new" ? "
            UPDATE items 
            SET new_stock=new_stock + 1,
                borrowed_new_stock=borrowed_new_stock - 1 
            WHERE item_id='$item_id'
        " : "
            UPDATE items 
            SET old_stock=old_stock + 1,
                borrowed_old_stock=borrowed_old_stock - 1 
            WHERE item_id='$item_id'
        ";

        try {
            $this->conn->query($sql);
            $this->conn->query($updateItemSql);
        } catch (mysqli_sql_exception $e) {
            include("partials/failed.php");
        }
    }

    public function returnToInventory($serial, $item_id, $type) {
        $sql = "UPDATE checkouts SET returned=1 WHERE serial=$serial";

        $returnToInventorySql = $type === "new" ? "
            UPDATE items 
            SET borrowed_new_stock=borrowed_new_stock - 1,
                old_stock=old_stock + 1 
            WHERE item_id='$item_id'
        " : "
            UPDATE items 
            SET borrowed_old_stock=borrowed_old_stock - 1,
                old_stock=old_stock + 1 
            WHERE item_id='$item_id'
        ";

        try {
            $this->conn->query($sql);
            $this->conn->query($returnToInventorySql);
        } catch (mysqli_sql_exception $e) {
            include("partials/failed.php");
        }
    }
}

$checkout = new Checkout($conn);