<?php 

include_once("partials/header.php");
include_once("functions.php");

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

// Handles new customer creation.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addNewCustomerBtn"])) {
    $name = $_POST["name"];
    $address = $_POST["address"];
    $phone = $_POST["phone"];

    $customer->addNewCustomer($name, $address, $phone);
}

// Handles customer deletion.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["customerDeleteBtn"])) {
    $customer_id = $_POST["customer_id"];
    $customer->deleteCustomer($customer_id);
}

// Fetches initial customer data for the table.
$result = $customer->getCustomers();

// Handles the search functionality.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["searchBtn"])) {
    $result = $customer->searchCustomers($_POST["search"]);
}

?>

<div class="my-4 container">
    <h3 class="mb-3 fw-bold">Customers</h3>

    <div class="d-flex flex-column">
        <div class="d-flex justify-content-between">
            <form action="customers.php" method="POST" class="d-flex gap-1">
                <input type="search" id="search" name="search" placeholder="Phone" class="form-control" />

                <button type="submit" name="searchBtn" class="btn btn-dark">
                    <i class="bi bi-search"></i>
                </button>
            </form>
            
            <a class="btn btn-dark block" data-bs-toggle="offcanvas" href="#addNewCustomer" role="button">
                New Customer <i class="bi bi-plus"></i>
            </a>
        </div>

        <!-- Table area. --------------------------------------------------------------->
        <table class="mt-2 table table-hover table-bordered">
            <thead>
                <tr>
                    <th>Customer ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td>#<?php echo $row["customer_id"]; ?></td>
                            <td><?php echo $row["name"]; ?></td>
                            <td><?php echo $row["address"]; ?></td>
                            <td><?php echo $row["phone"]; ?></td>
                            <td class="d-flex gap-2">
                                <form action="customers.php" method="POST">
                                    <input type="hidden" name="customer_id" value="<?php echo $row["customer_id"]; ?>" />
                                    
                                    <button 
                                        type="submit" 
                                        class="btn btn-danger" 
                                        name="customerDeleteBtn"
                                        >
                                            <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>

                                <form action="update_customer.php" method="POST">
                                    <input type="hidden" name="customer_id" value="<?php echo $row["customer_id"]; ?>" />
                                    <input type="hidden" name="name" value="<?php echo $row["name"]; ?>" />
                                    <input type="hidden" name="address" value="<?php echo $row["address"]; ?>" />
                                    <input type="hidden" name="phone" value="<?php echo $row["phone"]; ?>" />

                                    <button type="submit" class="btn btn-dark">
                                        <i class="bi bi-pencil-square"></i>
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

<div class="offcanvas offcanvas-start" id="addNewCustomer">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title fw-bold">New Customer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <form
        class="offcanvas-body"
        method="POST"
        action="customers.php"
    >
        <div class="mb-1 d-flex flex-column gap-2">
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
                name="address"
                placeholder="Address"
                id="address"
                required
            />
            <input
                type="text"
                class="form-control border border-teritory focus-ring focus-ring-secondary"
                name="phone"
                placeholder="Phone"
                id="phone"
                required
            />
        </div>

        <button 
            type="submit" 
            name="addNewCustomerBtn" 
            class="mt-2 btn btn-dark fw-semibold"
        >
            Add Customer
        </button>
    </form>
</div>

<?php include_once("partials/footer.php") ?>