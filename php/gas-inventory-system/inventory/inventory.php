<?php 

include_once("partials/header.php");
include_once("functions.php");

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

// Handles new inventory creation.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addToInventoryBtn"])) {
    $item_id = $_POST["item_id"];
    $added_stock_old = $_POST["added_stock_old"];
    $added_stock_new = $_POST["added_stock_new"];

    $inventory->addToInventory($item_id, $added_stock_old, $added_stock_new);
}

// Handles inventory deletion.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["inventoryDeleteBtn"])) {
    $item_id = $_POST["item_id"];
    $invoice_number = $_POST["invoice_number"];
    $added_stock_old = $_POST["added_stock_old"];
    $added_stock_new = $_POST["added_stock_new"];

    $inventory->deleteFromInventory($invoice_number, $item_id, $added_stock_old, $added_stock_new);
}

// Fetches initial inventory data for the table.
$result = $inventory->getInventory();

?>

<div class="my-4 container">
    <h3 class="mb-3 fw-bold">Inventory</h3>
    <p class="text-muted w-25" style="margin-top: -0.5rem;"><i class="bi bi-info-circle"></i> This can be used as a brief history of inventory.</p>

    <div class="d-flex flex-column">
        <div class="d-flex justify-content-end">
            <a class="btn btn-dark block" data-bs-toggle="offcanvas" href="#addNewInventory" role="button">
                New Inventory <i class="bi bi-plus"></i>
            </a>
        </div>

        <!-- Table area. --------------------------------------------------------------->
        <table class="mt-2 table table-hover table-bordered">
            <thead>
                <tr>
                    <th>Invoice Number</th>
                    <th>Name</th>
                    <th>Added Stock (Old)</th>
                    <th>Added Stock (New)</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td>#<?php echo $row["invoice_number"]; ?></td>
                            <td><?php echo $row["name"]; ?></td>
                            <td><?php echo $row["added_stock_old"]; ?></td>
                            <td><?php echo $row["added_stock_new"]; ?></td>
                            <td><?php echo $row["purchased_date"]; ?></td>
                            <td class="d-flex gap-2">
                                <form action="inventory.php" method="POST">
                                    <input type="hidden" name="invoice_number" value="<?php echo $row["invoice_number"]; ?>" />
                                    <input type="hidden" name="item_id" value="<?php echo $row["item_id"]; ?>" />
                                    <input type="hidden" name="added_stock_old" value="<?php echo $row["added_stock_old"]; ?>" />
                                    <input type="hidden" name="added_stock_new" value="<?php echo $row["added_stock_new"]; ?>" />
                                    
                                    <button 
                                        type="submit" 
                                        class="btn btn-danger" 
                                        name="inventoryDeleteBtn"
                                        >
                                            <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center p-4">No records found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="offcanvas offcanvas-start" id="addNewInventory">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title fw-bold">Add to Inventory</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <form
        class="offcanvas-body"
        method="POST"
        action="inventory.php"
    >
        <div class="mb-1 d-flex flex-column gap-2">
            <select class="form-select" name="item_id">
                <option selected disabled>Item ID</option>
                <option value="C02.0">C02.0</option>
                <option value="C06.0">C06.0</option>
                <option value="C12.5">C12.5</option>
            </select>

            <input
                type="text"
                class="form-control border border-teritory focus-ring focus-ring-secondary"
                name="added_stock_old"
                placeholder="Add (Old)"
                id="added_stock_old"
                required
            />

            <input
                type="text"
                class="form-control border border-teritory focus-ring focus-ring-secondary"
                name="added_stock_new"
                placeholder="Add (New)"
                id="added_stock_new"
                required
            />
        </div>

        <button 
            type="submit" 
            name="addToInventoryBtn" 
            class="mt-2 btn btn-dark fw-semibold"
        >
            Add to Inventory
        </button>
    </form>
</div>

<?php include_once("partials/footer.php") ?>