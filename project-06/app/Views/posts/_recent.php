<h5>Recent Posts</h5>

<ul>
<?php foreach($posts as $post): ?>
    <li>
        <a href="<?= $post->link() ?>"><?= esc($post->title) ?></a>
    </li>
<?php endforeach; ?>
</ul>
