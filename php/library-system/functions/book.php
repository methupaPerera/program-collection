<?php

include_once("db.php");

class Book {
    private $conn; // SQL connection variable.

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getBookData() {
        $sql = "SELECT * FROM books ORDER BY book_id DESC LIMIT 10";

        return mysqli_query($this->conn, $sql);
    }

    public function addNewBook(string $title, string $author, string $genre) {
        $sql = "INSERT INTO books (title, author, genre) VALUES ('$title', '$author', '$genre')";

        if (!mysqli_query($this->conn, $sql)) {
            echo "Something went wrong.";
        }
    }

    public function updateBook(int $book_id, string $title, string $author, string $genre) {
        $sql = "UPDATE books SET title='$title', author='$author', genre='$genre' WHERE book_id=$book_id";

        if (!mysqli_query($this->conn, $sql)) {
            echo "Something went wrong.";
        }
    }

    public function deleteBook(int $book_id) {
        $sql = "DELETE FROM books WHERE book_id = $book_id";

        if (!mysqli_query($this->conn, $sql)) {
            echo "Something went wrong.";
        }
    }

    public function handleSearch(string $search) {
        $sql = "SELECT * FROM books WHERE title LIKE '$search%'";
        return mysqli_query($this->conn, $sql);
    }
}

$book = new Book($conn);