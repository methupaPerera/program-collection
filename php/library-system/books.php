<?php

include_once("partials/header.php");
include_once("functions/book.php");

if (!isset($_SESSION["user"])) {
    header("Location: auth/login.php");
    exit;
}

// Handles new book creation.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addNewBookBtn"])) {
    $title = $_POST["title"];
    $author = $_POST["author"];
    $genre = $_POST["genre"];

    $book->addNewBook($title, $author, $genre);
}

// Handles book deletion.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["bookDeleteBtn"])) {
    $book->deleteBook($_POST["book_id"]);
}

// Handles book update.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["bookUpdateBtn"])) {
    $book_id = (int) $_POST["book_id"];
    $title = $_POST["title"];
    $author = $_POST["author"];
    $genre = $_POST["genre"];

    $book->updateBook($book_id, $title, $author, $genre);
}

// Fetches initial book data for the table.
$result = $book->getBookData();

// Handles the search functionality.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["searchBtn"])) {
    $result = $book->handleSearch($_POST["search"]);
}
?>

<div class="my-4 container">
    <h3 class="mb-3 fw-bold">Books</h3>

    <div class="d-flex flex-column">
        <div class="d-flex justify-content-between">
            <form action="books.php" method="POST" class="d-flex gap-1">
                <input type="search" id="search" name="search" placeholder="Title..." class="form-control" />

                <button type="submit" name="searchBtn" class="btn btn-dark">
                    <i class="bi bi-search"></i>
                </button>
            </form>

            <a class="btn btn-dark block" data-bs-toggle="offcanvas" href="#addNewBook" role="button">
                New Book <i class="bi bi-plus"></i>
            </a>
        </div>

        <!-- Table area. --------------------------------------------------------------->
        <table class="mt-2 table table-hover table-bordered">
            <thead>
                <tr>
                    <th>Book ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Genre</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0) : ?>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td>#<?php echo $row["book_id"]; ?></td>
                            <td><?php echo $row["title"]; ?></td>
                            <td><?php echo $row["author"]; ?></td>
                            <td><?php echo ucwords($row["genre"]); ?></td>
                            <td>
                                <form action="books.php" method="POST">
                                    <input type="hidden" name="book_id" value="<?php echo $row["book_id"]; ?>" />
                                    <button type="submit" class="btn btn-danger" name="bookDeleteBtn">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                    <a type="submit" class="btn btn-dark" data-bs-toggle="offcanvas" href="#updateBook" role="button" id="book-update">
                                        <i class="bi bi-pencil-square"></i>
                                        <input type="hidden" id="book_id" value="<?php echo $row["book_id"]; ?>" />
                                        <input type="hidden" id="title" value="<?php echo $row["title"]; ?>" />
                                        <input type="hidden" id="author" value="<?php echo $row["author"]; ?>" />
                                        <input type="hidden" id="genre" value="<?php echo $row["genre"]; ?>" />
                                    </a>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="text-center p-4">No records found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- New book form. ---------------------------------------------------------->
<div class="offcanvas offcanvas-start" id="addNewBook">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">New Book.</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <form class="offcanvas-body" method="POST" action="books.php">
        <h6 class="text-dark">Create new book.</h6>

        <div class="mt-3 d-flex flex-column gap-2">
            <input type="text" class="form-control border border-teritory focus-ring focus-ring-secondary" name="title" placeholder="Title" id="title" required />
            <input type="text" class="form-control border border-teritory focus-ring focus-ring-secondary" name="author" placeholder="Author" id="author" required />
            <select class="form-select" name="genre" id="genre" required>
                <option selected>Choose a genre.</option>
                <option value="action">Action</option>
                <option value="adventure">Adventure</option>
                <option value="thriller">Thriller</option>
            </select>
        </div>

        <button type="submit" name="addNewBookBtn" class="mt-2 btn btn-dark fw-semibold" style="width: 6rem;">Add</button>
    </form>
</div>

<!-- Update book form. ---------------------------------------------------------->
<div class="offcanvas offcanvas-start" id="updateBook">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Update Book.</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <form class="offcanvas-body" method="POST" action="books.php">
        <h6 class="text-dark">Update the book.</h6>

        <div class="mt-3 d-flex flex-column gap-2">
            <input type="hidden" class="form-control border border-teritory focus-ring focus-ring-secondary" name="book_id" placeholder="book_id" id="book_id" required />
            <input type="text" class="form-control border border-teritory focus-ring focus-ring-secondary" name="title" placeholder="Title" id="fullNname" required />
            <input type="text" class="form-control border border-teritory focus-ring focus-ring-secondary" name="author" placeholder="Author" id="author" required />
            <select class="form-select" name="genre" id="genre" required>
                <option selected>Choose a genre.</option>
                <option value="action">Action</option>
                <option value="adventure">Adventure</option>
                <option value="thriller">Thriller</option>
            </select>
        </div>

        <button type="submit" name="bookUpdateBtn" class="mt-2 btn btn-dark fw-semibold" style="width: 6rem;">Update</button>
    </form>
</div>

<script>
    const updateBookForm = document.getElementById("updateBook");

    document.addEventListener('DOMContentLoaded', () => {
        const updateButtons = document.querySelectorAll('#book-update');

        updateButtons.forEach((button) => {
            button.addEventListener('click', (event) => {
                event.preventDefault();

                const inputs = button.querySelectorAll("input");

                updateBookForm.querySelector('input[name="book_id"]').value = inputs[0].value;
                updateBookForm.querySelector('input[name="title"]').value = inputs[1].value;
                updateBookForm.querySelector('input[name="author"]').value = inputs[2].value;
                updateBookForm.querySelector('select[name="genre"]').value = inputs[3].value;
            });
        });
    });
</script>

<?php include_once("partials/footer.php") ?>