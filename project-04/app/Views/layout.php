<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>Project 04 - Simple Blog</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-3 mt-5">
                <?= view_cell('App\Controllers\BlogController::recentPostsCell', 'limit=5') ?>
            </div>
            <!-- Main Content -->
            <div class="col-9">
                <?= $this->renderSection('main') ?>
            </div>
        </div>
    </div>
</body>
</html>
