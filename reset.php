<?php include("header.php") ?>
<?php include("helpers/helpers.php") ?>

<div class="container mt-5 d-flex flex-column align-items-center">
    <p class="fs-2 fw-bold text-center">Reset Password</p>
    <form action="controllers/ResetPassController.php" method="post" class="w-50">
        <?php flash("reset") ?>
        <input type="email" placeholder="Enter your email" name="email" class="form-control mt-2">
        <input type="submit" value="Receive email" class="btn btn-warning w-100 my-3">
    </form>
</div>

<?php include("footer.php") ?>