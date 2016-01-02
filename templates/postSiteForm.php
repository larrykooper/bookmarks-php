<fieldset class="chg">
    <legend>Post a site</legend>
    <form method="POST" action="bookpost.php">
        <table>
            <tr>
                <td align="right"><label for="url">URL:</label></td>
                <td>
                    <input type="text" name="url" value="<?=$urlstring ?>" size=80>
                    <input type="submit" name="btn_title" value="get page title">
                </td>
            </tr>
            <tr>
                <td align="right"></td>
                <td>Example: http://www.mysite.com</td>
            </tr>
            <tr>
                <td align="right"><label for="name">Name:</label></td>
                <td>
                    <input type="text" class="freshPost" name="description" value="<?=$descstring ?>" size=80 id="titleField">
                </td>
            </tr>
            <tr>
                <td align="right"></td>
                <td>Title of the site or name you wish to use for it</td>
            </tr>
            <tr>
                <td align="right"><label for="extended">Extended:</label></td>
                <td>
                    <input type="text" name="extended" value="<?= $extenstring ?>" size=80> (optional)
                </td>
            </tr>
            <tr>
                <td align="right"></td>
                <td>Optional extended description of the site</td>
            </tr>
            <tr>
                <td align="right">
                    <label for="tags">Tags:</label>
                </td>
                <td>
                    <input type="text" name="tags" value="<?= $tagstring ?>" size=80> (space separated)
                </td>
            </tr>
            <tr>
                <td align="right"></td>
                <td>Keywords you would like to use to categorize the site</td>
            </tr>

            <tr>
                <td align="right"></td>
                <td>
                    <input type="checkbox" name="cb_inrotation" value="y">
                    <label for="cb_inrotation">In Rotation</label> -- Check here if you would like to regularly visit this site
                </td>
            </tr>
            <tr>
                <td align="right"></td>
                <td>
                    <input type="checkbox" name="cb_private" value="y">
                    <label for="cb_private">Private</label> -- Do not display this bookmark to other users<br /><br />
                </td>
            </tr>
            <tr>
                <td align="right">
                    <input type="hidden" name="submit_type" value="save">
                    <input type=image src="images/save.jpg" align="absmiddle" name="submit">
                </td>
            </tr>
    </table>
    </form>
</fieldset>