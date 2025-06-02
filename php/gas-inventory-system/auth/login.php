<?php 

include_once("partials/header.php");
include_once("functions.php");

$user_id = "";
$password = "";

// Redirecting to dashboard if logged in.
if (isset($_SESSION["user"])) {
    header("Location: dashboard.php");
    exit;
}

// Handling user authentication on POST requests.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST["user_id"];
    $password = $_POST["password"];

    $errors = $auth->login($user_id, $password);
}
?>

<form
    class="mt-5 p-4 mx-auto d-flex flex-column gap-3 shadow-lg rounded-2"
    style="width: 22rem"
    method="POST"
    action="login.php"
>
    <h2 class="fw-bold text-dark">Log in</h2>

    <div class="d-flex flex-column gap-2">
        <input
            type="text"
            class="form-control border border-teritory focus-ring focus-ring-secondary"
            name="user_id"
            placeholder="User ID"
            id="user_id"
            value="<?php echo $user_id ?>"
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

    <?php
    if (isset($errors)) {
        foreach ($errors as $error) {
            echo "<p class='text-danger' style='margin-bottom: -0.1rem;'>*$error</p>";
        }
    }
    ?>

    <button type="submit" class="btn btn-dark fw-semibold">Log in</button>
</form>


<?php include_once("partials/footer.php") ?>