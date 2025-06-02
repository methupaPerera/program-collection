<?php

include_once("db.php");

class Customer {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getCustomers() {
        $sql = "SELECT * FROM customers ORDER BY customer_id DESC LIMIT 10";

        try {
            return $this->conn->query($sql);
        } catch (mysqli_sql_exception $e) {
            include("partials/failed.php");
        }
    }

    public function addNewCustomer ($name, $address, $phone) {
        $sql = "
            INSERT INTO customers (name, address, phone) 
            VALUES ('$name', '$address', '$phone')
        ";

        try {
            $this->conn->query($sql);
        } catch (mysqli_sql_exception $e) {
            include("partials/failed.php");
        }
    }

    public function updateCustomer(int $customer_id, $name, $address, $phone) {
        $sql = "
            UPDATE customers 
            SET name='$name', 
                address='$address', 
                phone='$phone' 
            WHERE customer_id=$customer_id
        ";
        
        try {
            $this->conn->query($sql);
            include("partials/success.php");
        } catch (mysqli_sql_exception $e) {
            include("partials/failed.php");
        }
    }

    public function deleteCustomer(int $customer_id) {
        $sql = "DELETE FROM customers WHERE customer_id=$customer_id";

        try {
            $this->conn->query($sql);
        } catch (mysqli_sql_exception $e) {
            include("partials/failed.php");
        }
    }

    public function searchCustomers($search) {
        $sql = "SELECT * FROM customers WHERE phone LIKE '%$search%' ORDER BY customer_id DESC";

        try {
            return $this->conn->query($sql);
        } catch (mysqli_sql_exception $e) {
            include("partials/failed.php");
        }
        
    }
}

$customer = new Customer($conn);