<?= $this->extend('layout') ?>

<?= $this->section('main') ?>
<div class="container m-5 p-3 shadow">
    <?php if($formType == 'create') : ?>
	    <h1>Create New Post</h1>
    <?php else : ?>
        <h1>Edit Post</h1>
    <?php endif ?>

    <form action="<?php if($formType == 'create'): ?>/posts<?php else: ?>/posts/<?= $post->id ?><?php endif ?>" method="post">
        <?= csrf_field() ?>

        <!-- title -->
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" value="<?= old('title', $post->title ?? '') ?>">
        </div>

        <!-- publish at -->
        <div class="form-group">
            <label for="publish_at">Publish At</label>
            <input type="date" name="publish_at" class="form-control" value="<?= old('publish_at', ! empty($post->publish_at) ? $post->publish_at->format('Y-m-d') : '') ?>">
        </div>

        <!-- body -->
        <div class="form-group">
            <label for="body">Post Body</label>
            <textarea name="body" rows="15" class="form-control"><?= old('body', $post->body ?? '') ?></textarea>
        </div>

        <br>

        <input type="submit" class="btn btn-primary" value="Save Post">
    </form>
</div>
<?= $this->endSection() ?>
