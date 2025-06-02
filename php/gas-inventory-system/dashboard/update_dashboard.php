<?php

include_once("partials/header.php");
include_once("functions.php");

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

$item_id = $_POST["item_id"];
$name = $_POST["name"];
$old_stock_price = $_POST["old_stock_price"];
$new_stock_price = $_POST["new_stock_price"];

// Handles item update.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["itemUpdateBtn"])) {
    $item->updateItem($item_id, $name, $old_stock_price, $new_stock_price);
}

?>

<form
        class="mt-5 w-50 p-4 mx-auto d-flex flex-column gap-3 shadow-lg rounded-2"
        method="POST"
        action="update_dashboard.php"
    >
        <h3 class="text-dark fw-bold">Update item.</h3>

        <div class="mt-2 d-flex flex-column gap-2">
            <input
                type="hidden"
                name="item_id"
                id="item_id"
                value="<?php echo $item_id ?>"
            />
            <input
                type="text"
                class="form-control border border-teritory focus-ring focus-ring-secondary"
                name="name"
                placeholder="Name"
                id="name"
                value="<?php echo $name ?>"
                required
            />
            <input
                type="text"
                class="form-control border border-teritory focus-ring focus-ring-secondary"
                name="old_stock_price"
                placeholder="Price (Old)"
                id="old_stock_price"
                value="<?php echo $old_stock_price ?>"
                required
            />
            <input
                type="text"
                class="form-control border border-teritory focus-ring focus-ring-secondary"
                name="new_stock_price"
                placeholder="Price (New)"
                id="new_stock_price"
                value="<?php echo $new_stock_price ?>"
                required
            />
        </div>

        <div class="w-full d-flex gap-2">
            <button type="submit" name="itemUpdateBtn" class="mt-2 w-50 btn btn-dark fw-semibold">Update</button>
            <a href="dashboard.php" class="w-50 text-center btn btn-secondary fw-semibold mt-2 text-decoration-none">
                Return
            </a>            
        </div>
    </form>

<?php include_once("partials/footer.php"); ?>