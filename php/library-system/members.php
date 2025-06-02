<?php 

include_once("partials/header.php");
include_once("functions/member.php");

if (!isset($_SESSION["user"])) {
    header("Location: auth/login.php");
    exit;
}

// Handles new member creation.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addNewMemberBtn"])) {
    $fullName = $_POST["fullName"];
    $address = $_POST["address"];
    $phone = $_POST["phone"];

    $member->addNewMember($fullName, $address, $phone);
}

// Handles member deletion.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["memberDeleteBtn"])) {
    $member->deleteMember($_POST["member_id"]);
}

// Handles member update.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["memberUpdateBtn"])) {
    $member_id = (int) $_POST["member_id"];
    $fullName = $_POST["fullName"];
    $address = $_POST["address"];
    $phone = $_POST["phone"];

   $member->updateMember($member_id, $fullName, $address, $phone);
}

// Fetches initial member data for the table.
$result = $member->getMemberData();

// Handles the search functionality.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["searchBtn"])) {
    $result = $member->handleSearch($_POST["search"]);
}
?>

<div class="my-4 container">
    <h3 class="mb-3 fw-bold">Members</h3>

    <div class="d-flex flex-column">
        <div class="d-flex justify-content-between">
            <form action="members.php" method="POST" class="d-flex gap-1">
                <input type="search" id="search" name="search" placeholder="Phone or ID..." class="form-control" />

                <button type="submit" name="searchBtn" class="btn btn-dark">
                    <i class="bi bi-search"></i>
                </button>
            </form>
            
            <a class="btn btn-dark block" data-bs-toggle="offcanvas" href="#addNewMember" role="button">
                New Member <i class="bi bi-plus"></i>
            </a>
        </div>

        <!-- Table area. --------------------------------------------------------------->
        <table class="mt-2 table table-hover table-bordered">
            <thead>
                <tr>
                    <th>Member ID</th>
                    <th>Full Name</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td>#<?php echo $row["member_id"]; ?></td>
                            <td><?php echo $row["fullName"]; ?></td>
                            <td><?php echo $row["address"]; ?></td>
                            <td><?php echo $row["phone"]; ?></td>
                            <td>
                                <form action="members.php" method="POST">
                                    <input type="hidden" name="member_id" value="<?php echo $row["member_id"]; ?>" />
                                    <button 
                                        type="submit" 
                                        class="btn btn-danger" 
                                        name="memberDeleteBtn"
                                        >
                                            <i class="bi bi-trash-fill"></i>
                                    </button>
                                    <a
                                        type="submit" 
                                        class="btn btn-dark" 
                                        data-bs-toggle="offcanvas" 
                                        href="#updateMember" 
                                        role="button"
                                        id="member-update"
                                        >
                                            <i class="bi bi-pencil-square"></i>
                                            <input type="hidden" id="member_id" value="<?php echo $row["member_id"]; ?>" />
                                            <input type="hidden" id="fullName" value="<?php echo $row["fullName"]; ?>" />
                                            <input type="hidden" id="address" value="<?php echo $row["address"]; ?>" />
                                            <input type="hidden" id="phone" value="<?php echo $row["phone"]; ?>" />
                                    </a>
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

<!-- New member form. ---------------------------------------------------------->
<div class="offcanvas offcanvas-start" id="addNewMember">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">New Member.</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <form
        class="offcanvas-body"
        method="POST"
        action="members.php"
    >
        <h6 class="text-dark">Create new member.</h6>

        <div class="mt-3 d-flex flex-column gap-2">
            <input
                type="text"
                class="form-control border border-teritory focus-ring focus-ring-secondary"
                name="fullName"
                placeholder="Full Name"
                id="fullNname"
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

        <button type="submit" name="addNewMemberBtn" class="mt-2 btn btn-dark fw-semibold" style="width: 6rem;">Add</button>
    </form>
</div>

<!-- Update member form. ---------------------------------------------------------->
<div class="offcanvas offcanvas-start" id="updateMember">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Update Member.</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <form
        class="offcanvas-body"
        method="POST"
        action="members.php"
    >
        <h6 class="text-dark">Update the member.</h6>

        <div class="mt-3 d-flex flex-column gap-2">
            <input
                type="hidden"
                class="form-control border border-teritory focus-ring focus-ring-secondary"
                name="member_id"
                placeholder="member_id"
                id="member_id"
                required
            />
            <input
                type="text"
                class="form-control border border-teritory focus-ring focus-ring-secondary"
                name="fullName"
                placeholder="Full Name"
                id="fullNname"
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

        <button type="submit" name="memberUpdateBtn" class="mt-2 btn btn-dark fw-semibold" style="width: 6rem;">Update</button>
    </form>
</div>

<script>
    const updateMemberForm = document.getElementById("updateMember");

    document.addEventListener('DOMContentLoaded', () => {
        const updateButtons = document.querySelectorAll('#member-update');

        updateButtons.forEach((button) => {
            button.addEventListener('click', (event) => {
                event.preventDefault();
                
                const inputs = button.querySelectorAll("input");

               updateMemberForm.querySelector('input[name="member_id"]').value = inputs[0].value;
               updateMemberForm.querySelector('input[name="fullName"]').value = inputs[1].value;
               updateMemberForm.querySelector('input[name="address"]').value = inputs[2].value;
               updateMemberForm.querySelector('input[name="phone"]').value = inputs[3].value;
            });
        });
    });
</script>

<?php include_once("partials/footer.php") ?>