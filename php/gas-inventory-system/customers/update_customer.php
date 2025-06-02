<?php

include_once("partials/header.php");
include_once("functions.php");

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

$customer_id = (int) $_POST["customer_id"];
$name = $_POST["name"];
$address = $_POST["address"];
$phone = $_POST["phone"];

// Handles customer update.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["customerUpdateBtn"])) {
    $customer->updateCustomer($customer_id, $name, $address, $phone);
}

?>

<form
        class="mt-5 w-50 p-4 mx-auto d-flex flex-column gap-3 shadow-lg rounded-2"
        method="POST"
        action="update_customer.php"
    >
        <h3 class="text-dark fw-bold">Update customer.</h3>

        <div class="mt-2 d-flex flex-column gap-2">
            <input
                type="hidden"
                name="customer_id"
                id="customer_id"
                value="<?php echo $customer_id ?>"
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
                name="address"
                placeholder="Address"
                id="address"
                value="<?php echo $address ?>"
                required
            />
            <input
                type="text"
                class="form-control border border-teritory focus-ring focus-ring-secondary"
                name="phone"
                placeholder="Phone"
                id="phone"
                value="<?php echo $phone ?>"
                required
            />
        </div>

        <div class="w-full d-flex gap-2">
            <button type="submit" name="customerUpdateBtn" class="mt-2 w-50 btn btn-dark fw-semibold">Update</button>
            <a href="customers.php" class="w-50 text-center btn btn-secondary fw-semibold mt-2 text-decoration-none">
                Return
            </a>            
        </div>
    </form>

<?php include_once("partials/footer.php"); ?>