<!doctype html>
<html>
<head>
    <title>My Instruments</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

</head>
<body>
    <div class="container">
        <h1>Instruments for Sale</h1>

        <?php if (isset($products) && count($products)) : ?>
            <div class="row row-cols-md-2">
                <?php foreach($products as $product) : ?>
                    <div class="col mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?= esc($product->name) ?></h5>
                                <p>$<?= number_format($product->price / 100, 2) ?></p>
                                <p><?= $typography->autoTypography(esc($product->description)) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>

            <?= $pager->links() ?>
        <?php else: ?>
            <p><b>No products found.</b></p>
        <?php endif ?>
    </div>
</body>
</html>
