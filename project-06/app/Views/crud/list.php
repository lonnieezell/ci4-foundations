<?= $this->extend('layout') ?>

<?= $this->section('main') ?>
<div class="container m-5 p-3 shadow">
    <h1>Manage Posts</h1>

    <div class="text-right mb-3">
        <a href="/posts/create" class="btn btn-outline-primary btn-sm">New Post</a>
    </div>

    <?php if(! empty($posts)) : ?>
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 3rem">ID</th>
                    <th>Title</th>
                    <th>Published</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($posts as $post) : ?>
                <tr>
                    <td><?= $post->id ?></td>
                    <td>
                        <a href="/posts/<?= $post->id ?>">
		                    <?= $post->title ?>
                        </a>
                    </td>
                    <td><?= $post->publish_at->format('M j, Y') ?? '' ?></td>
                    <td>
                        <a href="/posts/<?= $post->id ?>/delete" onclick="return confirm('Delete post: '. <?= $post->title ?>);">Delete</a>
                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>

    <div class="pagination">
        <?= $pager->links() ?>
    </div>
    <?php else : ?>
        <div class="alert alert-info">No posts were found.</div>
    <?php endif ?>
</div>
<?= $this->endSection() ?>
