<?php 

include_once("partials/header.php");
include_once("functions/checkout.php");

if (!isset($_SESSION["user"])) {
    header("Location: auth/login.php");
    exit;
}

// Handles making new checkouts.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addNewCheckoutBtn"])) {
    $book_id = (int) $_POST["book_id"];
    $member_id = (int) $_POST["member_id"];
    
    try {
        $checkout->makeCheckout($member_id, $book_id);
        echo "<p class='text-center fw-bold p-3 text-success'>Success.</p>";
    } catch (Exception $e) {
        echo "<p class='text-center fw-bold p-3 text-danger'>Something went wrong.</p>";
    }
}

// Handles checkout deletion.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["checkoutDeleteBtn"])) {
    $checkout_id = (int) $_POST["checkout_id"];

    $checkout->deleteCheckout($checkout_id);
}

// Handles book returns.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["returnBtn"])) {
    $checkout->returnBook($_POST["checkout_id"]);
}

// Fetches initial checkout data for the table.
$result = $checkout->getCheckoutData();

// Handles the search functionality.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["searchBtn"])) {
    $result = $checkout->handleSearch($_POST["search"]);
}
?>

<div class="my-4 container">
    <h3 class="mb-3 fw-bold">Checkouts</h3>

    <div class="d-flex flex-column">
        <div class="d-flex justify-content-between">
            <form action="checkouts.php" method="POST" class="d-flex gap-1">
                <input type="search" id="search" name="search" placeholder="Member ID..." class="form-control" />

                <button type="submit" name="searchBtn" class="btn btn-dark">
                    <i class="bi bi-search"></i>
                </button>
            </form>
            
            <a class="btn btn-dark block" data-bs-toggle="offcanvas" href="#addNewCheckout" role="button">
                New Checkout <i class="bi bi-plus"></i>
            </a>
        </div>

        <!-- Table area. --------------------------------------------------------------->
        <table class="mt-2 table table-hover table-bordered">
            <thead>
                <tr>
                    <th>Checkout ID</th>
                    <th>Member Name</th>
                    <th>Book Title</th>
                    <th>Remaining Days</th>
                    <th>Returned</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td>#<?php echo $row["checkout_id"]; ?></td>
                            <td><?php echo $row["member_name"]; ?></td>
                            <td><?php echo $row["book_title"]; ?></td>
                            <td>
                                <?php 
                                if ($row["remaining_days"] < 0) {
                                    echo 0;
                                } else {
                                    echo $row["remaining_days"];
                                }
                                ?>
                            </td>
                            <td><?php echo ucwords($row["returned"]); ?></td>
                            <td>
                                <form action="checkouts.php" method="POST">
                                    <input type="hidden" name="checkout_id" value="<?php echo $row["checkout_id"]; ?>" />
                                    <button 
                                        type="submit" 
                                        class="btn btn-danger" 
                                        name="checkoutDeleteBtn"
                                        >
                                            <i class="bi bi-trash-fill"></i>
                                    </button>
                                    <button 
                                        type="submit" 
                                        class="btn btn-dark" 
                                        name="returnBtn"
                                        >
                                            Return
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center p-4">No records found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- New checkout form. ---------------------------------------------------------->
<div class="offcanvas offcanvas-start" id="addNewCheckout">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">New Checkout.</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <form
        class="offcanvas-body"
        method="POST"
        action="checkouts.php"
    >
        <h6 class="text-dark">Create new checkout.</h6>

        <div class="mt-3 d-flex flex-column gap-2">
            <input
                type="text"
                class="form-control border border-teritory focus-ring focus-ring-secondary"
                name="member_id"
                placeholder="Member ID"
                id="member_id"
                required
            />
            <input
                type="text"
                class="form-control border border-teritory focus-ring focus-ring-secondary"
                name="book_id"
                placeholder="Book ID"
                id="book_id"
                required
            />
        </div>

        <button type="submit" name="addNewCheckoutBtn" class="mt-2 btn btn-dark fw-semibold" style="width: 10rem;">Checkout Book</button>
    </form>
</div>

<?php include_once("partials/footer.php") ?>