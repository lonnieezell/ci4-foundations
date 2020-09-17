<?= $this->extend('layout') ?>

<?= $this->section('main') ?>
    <div class="container m-5 p-3 shadow">
        <p><a href="/">&larr; Back</a></p>

        <?= $this->setData(['post' => $post])->include('posts/_post') ?>
    </div>
<?= $this->endSection() ?>
