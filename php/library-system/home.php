<?php 

include_once("partials/header.php");
include_once("functions/auth.php");

// Users can't access this page without logging in.
if (!isset($_SESSION["user"])) {
    header(("Location: auth/login.php"));
    exit;
}

// Handling password change on POST requests.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old_password = $_POST["old_password"];
    $new_password = $_POST["new_password"];

   $errors = $auth->change_password($old_password, $new_password);
}

$user = $_SESSION["user"];
?>

<div class="my-4 container">
    <div class="p-4 d-flex flex-column flex-lg-row align-items-center gap-2 shadow-lg bg-dark rounded-3">

        <!-- Profile info area. -------------------------------------------------------->
        <div class="d-flex gap-4 profile">
            <div>
                <img class="avatar rounded-circle" src="public/img/avatar.jpg" alt="profile picture" />
                <p class="fw-semibold fs-2 text-white text-center"><?php echo "#" . $user["member_id"] ?></p>
            </div>

            <div class="d-flex flex-column">
                <p class="lh-1 fw-semibold text-white" style="font-size: 2.3rem"><?php echo $user["fullName"] ?></p>
                <p class="lh-1 fw-semibold text-white" style="font-size: 1.8rem"><?php echo $user["address"] ?></p>
                <p class="lh-1 fw-semibold text-white" style="font-size: 1.4rem"><?php echo $user["phone"] ?></p>
                <p class="lh-1 fw-semibold text-secondary" style="font-size: 1.1rem">Administrator</p>
            </div>
        </div>

        <!-- Actions area. ------------------------------------------------------------->
        <div class="cards">
            <div class="d-flex flex-column gap-2 bg-white p-3 ps-4 rounded-3">
                <i class="bi bi-people-fill" style="font-size: 3rem; margin-top: -1rem"></i>
                <p class="fs-3 fw-bold lh-1" style="margin-bottom: -0.1rem">Members</p>
                <a class="text-decoration-none" href="members.php">Manage >></a>
            </div>
        
            <div class="d-flex flex-column gap-2 bg-white p-3 ps-4 rounded-3">
                <i class="bi bi-book-fill" style="font-size: 3rem; margin-top: -1rem"></i>
                <p class="fs-3 fw-bold lh-1" style="margin-bottom: -0.1rem">Books</p>
                <a class="text-decoration-none" href="books.php">Manage >></a>
            </div>
        
            <div class="d-flex flex-column gap-2 bg-white p-3 ps-4 rounded-3">
                <i class="bi bi-receipt-cutoff" style="font-size: 3rem; margin-top: -1rem"></i>
                <p class="fs-3 fw-bold lh-1" style="margin-bottom: -0.1rem">Checkouts</p>
                <a class="text-decoration-none" href="checkouts.php">Manage >></a>
            </div>
        
            <div class="d-flex flex-column gap-2 bg-white p-3 ps-4 rounded-3">
                <i class="bi bi-gear-wide-connected" style="font-size: 3rem; margin-top: -1rem"></i>
                <p class="fs-3 fw-bold lh-1" style="margin-bottom: -0.1rem">Settings</p>
                <a class="text-decoration-none" data-bs-toggle="offcanvas" href="#settings" role="button">Manage >></a>
            </div>
        </div>
    </div>
</div>

<!-- Settings area. -------------------------------------------------------------------->
<div class="offcanvas offcanvas-start" id="settings">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Settings.</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <form
        class="offcanvas-body"
        method="POST"
        action="home.php"
    >
        <h6 class="text-dark">Change Password.</h6>

        <div class="mt-3 d-flex flex-column gap-2">
            <input
                type="text"
                class="form-control border border-teritory focus-ring focus-ring-secondary"
                name="old_password"
                placeholder="Old Password"
                id="old_password"
                required
            />
            <input
                type="text"
                class="form-control border border-teritory focus-ring focus-ring-secondary"
                name="new_password"
                placeholder="New Password"
                id="new_password"
                required
            />
        </div>

        <div class="mt-2">
            <?php
            if (isset($errors)) {
                foreach ($errors as $error) {
                    echo "<p class='text-danger'>*$error</p>";
                }
            }
            ?>
        </div>

        <button type="submit" class="mt-1 btn btn-dark fw-semibold">Change Password</button>
    </form>
</div>

<?php include_once("partials/footer.php") ?>