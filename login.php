<?php include("header.php") ?>
<?php include("helpers/helpers.php") ?>

<div class="container mt-5 d-flex flex-column align-items-center">
    <p class="fs-2 fw-bold text-center">Please login</p>
    <form action="controllers/LoginController.php" method="post" class="w-50">
        <?php flash("login") ?>

        <input type="text" placeholder="Enter your email or username" name="email" class="form-control mt-2">

        <input type="password" placeholder="Enter your password" name="password" class="form-control mt-2">

        <input type="submit" value="Login" class="btn btn-primary w-100 my-3">
    </form>
    <a href="reset.php">Forgetten Password?</a>
</div>

<?php include("footer.php") ?>