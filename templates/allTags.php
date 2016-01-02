

<? foreach ($tags_data as $tag_row): ?>

    <? extract($tag_row); ?>

    <!-- do this for each tag -->
    <div class=LBBTag>
        <span class="LBBNum"><?=$tcount ?></span>
        <a href="bookmarks.php?tags=<?= $Tag ?>&amp;user=<?=$userdisp ?>" class="right">
            <?= $Tag ?>
        </a>
    </div>

<? endforeach ?>