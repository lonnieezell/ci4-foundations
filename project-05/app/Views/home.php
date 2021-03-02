<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

	<title>Car Breeds</title>
</head>
<body>
    <div class="container p-5">

        <h1>Cat Breeds</h1>

        <div class="card">
            <div class="card-body">
            <?php if (isset($breeds) && count($breeds)) : ?>
                <div class="mb-3">
                    <select name="breed" id="breed" class="form-control">
                        <option value="">Select a breed...</option>
                        <?php foreach($breeds as $breed) : ?>
                            <option value="<?= esc($breed['id'], 'attr') ?>"><?= esc($breed['name']) ?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <input type="submit" class="btn btn-primary" id="search-btn" value="Search">

            <?php else : ?>
                <div class="alert alert-info">The cats are currently sleeping. Please try back later.</div>
            <?php endif ?>
            </div>
        </div>

        <div id="photos" class="mt-5"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <script>
        $('#search-btn').click(function(e) {
            e.preventDefault();

            // POST request
            $('#photos').load('/search', {
                breed: $('#breed').val()
            });
        });
    </script>
</body>
</html>
