<?php 

include_once("partials/header.php");
include_once("functions.php");

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

// Handles new checkout creation.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addNewCheckoutBtn"])) {
    $customer_id = $_POST["customer_id"];
    $item_id = $_POST["item_id"];
    $type = $_POST["type"];

    $checkout->addNewCheckout($customer_id, $item_id, $type);
}

// Handles checkout update.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["checkoutUpdateBtn"])) {
    $serial = $_POST["serial"];
    $item_id = $_POST["item_id"];
    $type = $_POST["type"];

    $checkout->returnToInventory($serial, $item_id, $type);
}

// Handles checkout deletion.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["checkoutDeleteBtn"])) {
    $serial = $_POST["serial"];
    $item_id = $_POST["item_id"];
    $type = $_POST["type"];

    $checkout->deleteCheckout($serial, $item_id, $type);
}

// Fetches initial checkout data for the table.
$result = $checkout->getCheckouts();

?>

<div class="my-4 container">
    <h3 class="mb-3 fw-bold">Checkouts</h3>

    <div class="d-flex flex-column">
        <div class="d-flex justify-content-end">
            <a class="btn btn-dark block" data-bs-toggle="offcanvas" href="#addNewCheckout" role="button">
                New Checkout <i class="bi bi-plus"></i>
            </a>
        </div>

        <!-- Table area. --------------------------------------------------------------->
        <table class="mt-2 table table-hover table-bordered">
            <thead>
                <tr>
                    <th>Serial</th>
                    <th>Customer ID</th>
                    <th>Customer Name</th>
                    <th>Item ID</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Price</th>
                    <th>Returned</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td>#<?php echo $row["serial"]; ?></td>
                            <td><?php echo $row["customer_id"]; ?></td>
                            <td><?php echo $row["name"]; ?></td>
                            <td><?php echo $row["item_id"]; ?></td>
                            <td><?php echo $row["type"]; ?></td>
                            <td><?php echo $row["date"]; ?></td>
                            <td><?php echo $row["price"]; ?></td>
                            <td><?php echo $row["returned"] ? "Returned" : "Not Returned"; ?></td>
                            <td class="d-flex gap-2">
                                <form action="checkouts.php" method="POST">
                                    <input type="hidden" name="serial" value="<?php echo $row["serial"]; ?>" />
                                    <input type="hidden" name="item_id" value="<?php echo $row["item_id"]; ?>" />
                                    <input type="hidden" name="type" value="<?php echo $row["type"]; ?>" />

                                    <button 
                                        type="submit" 
                                        class="btn btn-danger" 
                                        name="checkoutDeleteBtn"
                                        <?php if ($row['returned']): ?>
                                            disabled
                                        <?php endif; ?>
                                        >
                                            <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>

                                <form action="checkouts.php" method="POST">
                                    <input type="hidden" name="serial" value="<?php echo $row["serial"]; ?>" />
                                    <input type="hidden" name="item_id" value="<?php echo $row["item_id"]; ?>" />
                                    <input type="hidden" name="type" value="<?php echo $row["type"]; ?>" />

                                    <button 
                                        type="submit" 
                                        class="btn btn-secondary" 
                                        name="checkoutUpdateBtn"
                                        <?php if ($row['returned']): ?>
                                            disabled
                                        <?php endif; ?>
                                        >
                                            Return
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center p-4">No records found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="offcanvas offcanvas-start" id="addNewCheckout">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title fw-bold">New Checkout</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <form
        class="offcanvas-body"
        method="POST"
        action="checkouts.php"
    >
        <div class="mb-1 d-flex flex-column gap-2">
            <input
                type="text"
                class="form-control border border-teritory focus-ring focus-ring-secondary"
                name="customer_id"
                placeholder="Customer ID"
                id="customer_id"
                required
            />

            <input
                type="text"
                class="form-control border border-teritory focus-ring focus-ring-secondary"
                name="item_id"
                placeholder="Item ID"
                id="item_id"
                required
            />

            <select class="form-select" name="type">
                <option selected disabled>Type</option>
                <option value="old">Old</option>
                <option value="new">New</option>
            </select>
        </div>

        <button 
            type="submit" 
            name="addNewCheckoutBtn" 
            class="mt-2 btn btn-dark fw-semibold"
        >
            Add Checkout
        </button>
    </form>
</div>

<?php include_once("partials/footer.php") ?>