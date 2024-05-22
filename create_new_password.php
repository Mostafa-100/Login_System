<?php include("header.php") ?>
<?php include("helpers/helpers.php") ?>

<?php

$isEmpty = empty($_GET["selector"]) || empty($_GET["token"]);
$isHex = !ctype_xdigit($_GET["selector"]) || !ctype_xdigit($_GET["token"]);

if ($isEmpty || $isHex) {
    die("Could not validate your request!");
}

?>

<div class="container mt-5 d-flex flex-column align-items-center">
    <p class="fs-2 fw-bold text-center">Reset your password</p>
    <form action="controllers/CreateNewPassController.php" method="post" class="w-50">

        <?php flash("reset") ?>

        <input type="hidden" name="selector" value="<?= $_GET["selector"] ?>">

        <input type="hidden" name="token" value="<?= $_GET["token"] ?>">

        <input type="password" placeholder="Enter new password" name="password" class="form-control mt-2">

        <input type="password" placeholder="Repeat your password" name="re_password" class="form-control mt-2">

        <input type="submit" value="Reset password" class="btn btn-success w-100 my-3">
    </form>
</div>

<?php include("footer.php") ?>