<ul class="pagination">
    <?php if ($pager->hasPrevious()): ?>
        <li><a href="<?= $pager->getPrevious() ?>">&laquo; Previous</a></li>
    <?php endif; ?>

    <?php foreach ($pager->links() as $link): ?>
        <li><a href="<?= $link['href'] ?>"><?= $link['title'] ?></a></li>
    <?php endforeach; ?>

    <?php if ($pager->hasNext()): ?>
        <li><a href="<?= $pager->getNext() ?>">Next &raquo;</a></li>
    <?php endif; ?>
</ul>
