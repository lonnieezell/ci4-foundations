<!doctype html>
<html>
<head>
    <title><?= $siteName ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>
    <div class="container text-center mt-5">
        <h1>Welcome to Acme, Inc</h1>
        <p>Purveyor of fine
            <?php foreach($categories as $cat) : ?>
                <?= $cat .', ' ?>
            <?php endforeach ?> and more.</p>
    </div>
</body>
</html>
