<?php 

include_once("../partials/header.php");
include_once("../functions/auth.php");

$member_id = "";
$password = "";

// Redirecting to home if logged in.
if (isset($_SESSION["user"])) {
    header("Location: ../home.php");
    exit;
}

// Handling user log on POST requests.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $member_id = (int) $_POST["member_id"];
    $password = $_POST["password"];

    $errors = $auth->login($member_id, $password);
}
?>

<form
    class="mt-5 mx-auto d-flex flex-column p-4 shadow-lg rounded-2"
    style="width: 22rem"
    method="POST"
    action="login.php"
>
    <h2 class="fw-bold text-dark">Log in</h2>

    <div class="mt-2 d-flex flex-column gap-2">
        <input
            type="text"
            class="form-control border border-teritory focus-ring focus-ring-secondary"
            name="member_id"
            placeholder="Member ID"
            id="member_id"
            value="<?php echo $member_id ?>"
            required
        />
        <input
            type="password"
            class="form-control border border-teritory focus-ring focus-ring-secondary"
            name="password"
            placeholder="Password"
            id="password"
            value="<?php echo $password ?>"
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

    <button type="submit" class="btn btn-dark fw-semibold">Log in</button>
</form>


<?php include_once("../partials/footer.php") ?>