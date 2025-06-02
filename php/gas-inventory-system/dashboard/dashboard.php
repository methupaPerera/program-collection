<?php 

include_once("partials/header.php");
include_once("functions.php");

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

// Handles new item creation.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addNewItemBtn"])) {
    $name = $_POST["name"];
    $item_id = $_POST["item_id"];
    $old_stock_price = $_POST["old_stock_price"];
    $new_stock_price = $_POST["new_stock_price"];

    $item->addNewItem($item_id, $name, $old_stock_price, $new_stock_price);
}

// Handles item deletion.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["itemDeleteBtn"])) {
    $item_id = $_POST["item_id"];
    $item->deleteItem($item_id);
}

// Fetches initial item data for the table.
$result = $item->getItems();

?>

<div class="my-4 container">
    <h3 class="mb-3 fw-bold">Dashboard</h3>

    <div class="d-flex flex-column">
        <div class="d-flex justify-content-end">            
            <a class="btn btn-dark block" data-bs-toggle="offcanvas" href="#addNewItem" role="button">
                New Item <i class="bi bi-plus"></i>
            </a>
        </div>

        <!-- Table area. --------------------------------------------------------------->
        <table class="mt-2 table table-hover table-bordered">
            <thead>
                <tr>
                    <th>Item ID</th>
                    <th>Name</th>
                    <th>Stock (Old)</th>
                    <th>Borrowed (Old)</th>
                    <th>Price (Old)</th>
                    <th>Stock (New)</th>
                    <th>Borrowed (New)</th>
                    <th>Price (New)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td>#<?php echo $row["item_id"]; ?></td>
                            <td><?php echo $row["name"]; ?></td>
                            <td><?php echo $row["old_stock"]; ?></td>
                            <td><?php echo $row["borrowed_old_stock"]; ?></td>
                            <td><?php echo $row["old_stock_price"]; ?></td>
                            <td><?php echo $row["new_stock"]; ?></td>
                            <td><?php echo $row["borrowed_new_stock"]; ?></td>
                            <td><?php echo $row["new_stock_price"]; ?></td>
                            <td class="d-flex gap-2">
                                <form action="dashboard.php" method="POST">
                                    <input type="hidden" name="item_id" value="<?php echo $row["item_id"]; ?>" />
                                    
                                    <button 
                                        type="submit" 
                                        class="btn btn-danger" 
                                        name="itemDeleteBtn"
                                        >
                                            <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>

                                <form action="update_dashboard.php" method="POST">
                                    <input type="hidden" name="item_id" value="<?php echo $row["item_id"]; ?>" />
                                    <input type="hidden" name="name" value="<?php echo $row["name"]; ?>" />
                                    <input type="hidden" name="old_stock_price" value="<?php echo $row["old_stock_price"]; ?>" />
                                    <input type="hidden" name="new_stock_price" value="<?php echo $row["new_stock_price"]; ?>" />

                                    <button type="submit" class="btn btn-dark">
                                        <i class="bi bi-pencil-square"></i>
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

<div class="offcanvas offcanvas-start" id="addNewItem">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title fw-bold">New Item</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <form
        class="offcanvas-body"
        method="POST"
        action="dashboard.php"
    >
        <div class="mb-1 d-flex flex-column gap-2">
            <input
                type="text"
                class="form-control border border-teritory focus-ring focus-ring-secondary"
                name="item_id"
                placeholder="Item ID"
                id="item_id"
                required
            />
            <input
                type="text"
                class="form-control border border-teritory focus-ring focus-ring-secondary"
                name="name"
                placeholder="Name"
                id="name"
                required
            />
            <input
                type="text"
                class="form-control border border-teritory focus-ring focus-ring-secondary"
                name="old_stock_price"
                placeholder="Price (Old)"
                id="old_stock_price"
                required
            />
            <input
                type="text"
                class="form-control border border-teritory focus-ring focus-ring-secondary"
                name="new_stock_price"
                placeholder="Price (New)"
                id="new_stock_price"
                required
            />
        </div>

        <button 
            type="submit" 
            name="addNewItemBtn" 
            class="mt-2 btn btn-dark fw-semibold"
        >
            Add Item
        </button>
    </form>
</div>

<?php include_once("partials/footer.php") ?>