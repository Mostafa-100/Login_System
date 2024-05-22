<?php include("header.php") ?>
<?php include("helpers/helpers.php") ?>

<div class="container mt-5 d-flex flex-column align-items-center">
    <p class="fs-2 fw-bold text-center">Please Signup</p>
    <form action="controllers/SignUpController.php" method="post" class="w-50">
        <?php flash("register"); ?>

        <input type="text" placeholder="Enter your full name" name="full-name" class="form-control mt-2">

        <input type="text" placeholder="Enter your email" name="email" class="form-control mt-2" id="email">

        <input type="text" placeholder="Enter your username" name="username" class="form-control mt-2">

        <input type="password" placeholder="Enter your password" name="password" class="form-control mt-2">

        <input type="password" placeholder="Repeat your password" name="re-password" class="form-control mt-2">

        <input type="submit" value="Sign up" class="btn btn-danger w-100 mt-3">
    </form>
</div>

<?php include("footer.php") ?>