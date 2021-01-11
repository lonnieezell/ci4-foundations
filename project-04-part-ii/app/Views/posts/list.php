<?= $this->extend('layout') ?>

<?= $this->section('main') ?>
    <div class="container m-5 p-3 shadow">
        <h1>Latest News</h1>

        <?php if (isset($posts) && count($posts)) : ?>
            <?php foreach($posts as $post) : ?>
                <?= $this->setData(['post' => $post])->include('posts/_post') ?>
            <?php endforeach ?>

            <?= $pager->links() ?>
        <?php else : ?>
            <div class="alert alert-info">No news is good news, right?</div>
        <?php endif ?>
    </div>
<?= $this->endSection() ?>
