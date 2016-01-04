<!-- previous -->
<? if ($start <> 0):  ?>

    <? $newstart = $start - $perpage; ?>
    <a href="bookmarks.php?<?= $MyQS ?><?= $Delim ?>start=<?= $newstart ?>" class="rt">< previous</a>

<? else: ?>
    &nbsp;
<? endif ?>

<!-- next -->
<? if (($start + $perpage) < $total_rows): ?>

    <? $newstart = $start + $perpage; ?>
    <a href="bookmarks.php?<?= $MyQS ?><?= $Delim ?>start=<?= $newstart ?>" class="bodyl">next ></a>

<? else: ?>
    &nbsp;
<? endif ?>
&nbsp;<?=$total_rows ?> items total