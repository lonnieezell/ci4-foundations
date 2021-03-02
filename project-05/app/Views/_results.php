<?php if (isset($images) && count($images)) : ?>

    <h2><?= esc($images[0]->breeds[0]->name) ?? 'Cat Photos' ?></h2>

    <p class="lead"><?= esc($images[0]->breeds[0]->description) ?></p>

	<div class="row row-cols-3">
	<?php foreach($images as $image) : ?>
		<div class="col">
			<div class="card h-100 mb-3">
				<img src="<?= esc($image->url, 'attr') ?>" alt="<?= esc($image->breeds[0]->name, 'attr') ?>" class="card-img-top">
			</div>
		</div>
	<?php endforeach ?>
	</div>


<?php else : ?>
	<div class="alert alert-info">No images found. Choose a different breed.</div>
<?php endif ?>
