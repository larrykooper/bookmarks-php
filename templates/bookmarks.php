<html>
<head>
    <title><?php echo $myTitle?></title>
    <link rel="stylesheet" type="text/css" href="css/bkm.css">
</head>
<body class="bookmarksPage">

<?
if ($validated) {
    include('templates/headerlogged.php');
} else {
    include('templates/header.php');
}
require "templates/allTags.php";

if ($pageFrom != 'random') {
    display_pnt();
}
?>

<div class="LBBMain">

    <p class="help">
        Welcome, <?= $theusername ?>.

        You are now viewing the bookmarks of <a href="bookmarks.php?user=<?= $userdisp ?> "class='body' ><?= $wantedUser ?></a>
    </p>
    <? if ($pageFrom != 'random'): ?>
        Sort by:
    <? endif   ?>
    <?
    if ($Tagfilter) {
        $queryStringTags = "&tags=$wantedTagString";

    } else {
        $queryStringTags = "";
    }

    ?>

    <table border="0">
        <tr>
            <th>
                <a href="bookmarks.php?user=<?= $userdisp?>&amp;sortkey=name&amp;dir=<?= $displayDirection?><?=$queryStringTags ?>" class="bodyt">Name</a>
            </th>
            <th class="rttopu">
                <a href="bookmarks.php?user=<?= $userdisp?>&amp;sortkey=postdate&amp;dir=<?= $displayDirection?><?=$queryStringTags ?>" class="bodyt">Posting Date</a>
            </th>
            <th class="rttopu">
                <a href="bookmarks.php?sortkey=lastvisit&amp;dir=<?= $displayDirection?><?=$queryStringTags ?>" class="bodyt">Last Visited</a></th>
            <th class="rttopu">
                <a href="bookmarks.php?sortkey=count&amp;dir=<?= $displayDirection?><?=$queryStringTags ?>" class="bodyt">Total Visits</a>
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
</div>
</body>
</html>