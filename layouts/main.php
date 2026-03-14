<?php 
$base = "/myprojects/CoffeeByte-Store"; 
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
            integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer" />
        <!-- <link rel="stylesheet" href="../assets/css/app.css">
        <link rel="stylesheet" href="../assets/css/styles.css"> -->
        <link rel="stylesheet" href="<?= $base ?>/assets/css/app.css">
<link rel="stylesheet" href="<?= $base ?>/assets/css/styles.css">
        <title><?= $title ?? "Cafe Aroma" ?></title>
    </head>
    <body>
        <?php include __DIR__ . "/../includes/header.php"; ?>

        <main><?= $content ?></main>
        
        <?php include __DIR__ . "/../includes/footer.php"; ?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>