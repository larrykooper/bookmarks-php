Sort by:
<table border="0">
    <tr>
        <th>
            <a href="bookmarks.php?user=<?= $userdisp?>&amp;sortkey=name&amp;dir=<?= $displayDirection?>" class="bodyt">Name</a>
        </th>
        <th class="rttopu">
            <a href="bookmarks.php?user=<?= $userdisp?>&amp;sortkey=postdate&amp;dir=<?= $displayDirection?>" class="bodyt">Posting Date</a>
        </th>
        <th class="rttopu">
            <a href="bookmarks.php?sortkey=lastvisit&amp;dir=<?= $displayDirection?>" class="bodyt">Last Visited</a></th>
        <th class="rttopu">
            <a href="bookmarks.php?sortkey=count&amp;dir=<?= $displayDirection?>" class="bodyt">Total Visits</a>
        </th>

    </tr>
    <? foreach ($bookmarks_data as $bookmark_row): ?>

        <? extract($bookmark_row['bookmark']);  ?>
        <!-- bookmark  -->
        <tr>
            <td>
                <a href="bkmarkredir.php?snum=<?=$URLID ?>" target="new" class="bodyl"><?=stripslashes($SiteDescr) ?></a>
            </td>
            <td class="rttop">
                <?=$PostTime ?>
            </td>
            <td class="rttop" align="right">
                <?=$LVDispl ?>
            </td>
            <td class="rttop" align="right">
                <?=$mycol ?>
            </td>
        </tr>

        <!-- Extended description   -->
        <tr>
            <td colspan="2">
                <?=stripslashes($ExtendedDesc) ?>
            </td>
        </tr>
        <!--  In Rotation and Private  -->
        <? if ($InRotation): ?>
        <tr>
            <td>
            In-Rotation
            </td>
        </tr>

        <? endif ?>

        <?if ($Private): ?>
        <tr>
            <td>
            Private
            </td>
        </tr>

        <? endif ?>
        <!-- tags -->

        <tr>
            <td class="below">

                <? foreach ($bookmark_row['tags'] as $tag): ?>

                    <a href="bookmarks.php?user=<?=$userdisp ?>&amp;tags=<?=$tag ?>" class="bodym">
                        <?= $tag ?>
                    </a>
                <? endforeach ?>
                ...
            </td>

        <!-- end of tags -->
            <td colspan="3" class="rtside">
                <a href="editpost.php?editsite=<?=$URLID ?>&amp;redirectUrl=<?= urlencode($currentURL)?>" class="bodyt">Edit</a>
                this item
            </td>
        </tr>

    <? endforeach ?>
</table>