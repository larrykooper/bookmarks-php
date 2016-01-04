
<div class='LBBRight'>
    <div class='LBBRightTitle'>
        All tags
    </div>

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

    <!-- tag-sorting options -->

    <div class='LBBRightTitle'>
        sort by
        <? if ($_SESSION['tagsort']=='freq'): ?>
            <a class="right" href="bookmarks.php?user="<?= $userdisp ?>"&amp;settagsort=alpha">
                alpha
            </a>
             | freq
        <? else: ?>
            alpha
            <a class="right" href="bookmarks.php?user="<?= $userdisp ?>"&amp;settagsort=freq">
                | freq
            </a>

        <? endif ?>

    </div>

</div>