<?php include("header.php") ?>

<div class="container">
    <p class="fs-1 fw-bold text-center mt-5">Welcome, <?= $_SESSION["name"] ?? "Guest" ?></p>
</div>

<?php include("footer.php") ?>