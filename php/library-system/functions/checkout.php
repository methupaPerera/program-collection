<?php

include_once("db.php");

class Checkout {
    private $conn; // SQL connection variable.

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getCheckoutData() {
        $sql = "SELECT 
                    checkout_id,
                    returned,
                    books.title AS book_title,
                    members.fullName AS member_name,
                    DATEDIFF(return_date, CURRENT_DATE) AS remaining_days
                FROM 
                    checkouts
                JOIN 
                    books ON checkouts.book_id = books.book_id
                JOIN 
                    members ON checkouts.member_id = members.member_id
                WHERE
                    returned = 'not returned'";
    
        return mysqli_query($this->conn, $sql);
    
    }

    public function makeCheckout(int $member_id, int $book_id) {
        $borrowed_date = date("Y-m-d");
        $return_date = date("Y-m-d", strtotime($borrowed_date . "+14 days"));

        $sql = "INSERT INTO checkouts (member_id, book_id, borrowed_date, return_date) VALUES ($member_id, $book_id, '$borrowed_date', '$return_date')";

        if (!mysqli_query($this->conn, $sql)) {
            echo "Something went wrong.";
        }
    }

    public function deleteCheckout(int $checkout_id) {
        $sql = "DELETE FROM checkouts WHERE checkout_id = $checkout_id";

        if (!mysqli_query($this->conn, $sql)) {
            echo "Something went wrong.";
        }
    }

    public function returnBook(int $checkout_id) {
        $sql = "UPDATE checkouts SET returned = 'returned' WHERE checkout_id = $checkout_id";

        if (!mysqli_query($this->conn, $sql)) {
            echo "Something went wrong.";
        }
    }

    public function handleSearch(string $search) {
        $sql = "SELECT 
                    checkout_id,
                    returned,
                    books.title AS book_title,
                    members.fullName AS member_name,
                    DATEDIFF(return_date, borrowed_date) AS remaining_days
                FROM 
                    checkouts
                JOIN 
                    books ON checkouts.book_id = books.book_id
                JOIN 
                    members ON checkouts.member_id = members.member_id
                WHERE 
                    members.member_id = $search";

        return mysqli_query($this->conn, $sql);
    }
}

$checkout = new Checkout($conn);