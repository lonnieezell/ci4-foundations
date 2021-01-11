<article>
    <header>
        <h2><a href="<?= $post->link() ?>"><?= esc($post->title) ?></a></h2>
        <p class="text-muted small">Published: <?= $post->publish_at->humanize() ?></p>
    </header>

    <?= $post->body ?>
</article>

<hr>
