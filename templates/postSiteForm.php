<fieldset class="chg">
    <legend>Post a site</legend>
    <form method="POST" action="bookpost.php">

        <label class="firstCol" for="url"><span>URL:</span></label>

        <input type="text" name="url" value="<?=$urlstring ?>" size=80>
        <input type="submit" name="btn_title" value="get page title">
        <div class="explanation">Example: http://www.mysite.com</div>
        <label class="firstCol" for="name"><span>Name:</span></label>

        <input type="text" class="freshPost" name="description" value="<?=$descstring ?>" size=80 id="titleField">

        <div class="explanation">Title of the site or name you wish to use for it</div>
        <label class="firstCol" for="extended"><span>Extended:</span></label>

        <input type="text" name="extended" value="<?= $extenstring ?>" size=80> (optional)
        <div class="explanation">Optional extended description of the site</div>
        <label class="firstCol" for="tags"><span>Tags:</span></label>

        <input id="tagEntry" type="text" name="tags" value="<?= $tagstring ?>" size=80> (space separated)

        <div class="explanation">Keywords you would like to use to categorize the site</div>
        <div class="checkboxes">
            <input type="checkbox" name="cb_inrotation" value="y">

            <label for="cb_inrotation">In Rotation</label>
            -- Check here if you would like to regularly visit this site
        </div>
        <div class="checkboxes private">
            <input type="checkbox" name="cb_private" value="y">
            <label for="cb_private">Private</label> -- Do not display this bookmark to other users
        </div>

        <input type="hidden" name="submit_type" value="save">
        <input type=image src="images/save.jpg" align="absmiddle" name="submit">

    </form>
</fieldset>