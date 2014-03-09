<div class="userSites index">
    <h2 class="page-title">
        <?php echo __('Larrybeth Bookmarks Link Checker Report'); ?>
    </h2>
    <span class="codes">
        NULL 0 200 301 302 303 307 400 401 403 404 405 406 410 500 502 503
    </span>
    <span class="sort-by-code">
        SORT BY
        <?php echo $this->Paginator->sort('Url.HttpCode', 'Httpcode'); ?>
    </span>
    <table class="sites-table">
        <tr>
            <th class="url-col">URL</th>
            <th class="title"><?php echo $this->Paginator->sort('SiteDescr', 'Title'); ?></th>

            <th class="extended-col"><?php echo $this->Paginator->sort('ExtendedDesc'); ?></th>
            <th class="tags-col">Tags</th>
            <th class="post-date"><?php echo $this->Paginator->sort('OrigPostingTime', 'Posting Date'); ?></th>
            <th class="message-col">Message</th>
            <th class="actions">Actions</th>

        </tr>
        <?php foreach ($userSites as $userSite): ?>

            <!--  HERE BEGIN ONE listing -->

            <tr>
                <td class="url-col">
                    <?php echo $this->Html->link($userSite['Url']['URL'], $userSite['Url']['URL'], array('class' => 'url-link')); ?>&nbsp;
                </td>

                <td class="title"><?php echo h($userSite['UserSite']['SiteDescr']); ?>&nbsp;</td>

                <td class="extended-col"><?php echo h($userSite['UserSite']['ExtendedDesc']); ?>&nbsp;</td>

                <td class="tags-col">
                    <?php foreach($userSite['UserSiteTag'] as $theTag) {   ?>
                        <?php echo $theTag['Tag']; ?>
                    <?php  } ?>&nbsp;
                </td>

                <td class="post-date"><?php echo date("Y-m-d", strtotime($userSite['UserSite']['OrigPostingTime'])); ?>&nbsp;</td>

                <td class="message-col"><?php echo $userSite['Url']['ErrorText']; ?>&nbsp;
                    <?php if (!empty($userSite['Url']['RedirectLocation'])) { ?>
                        <?php echo $this->Html->link($userSite['Url']['RedirectLocation'], $userSite['Url']['RedirectLocation'], array('class' => 'redirect-url')); ?>

                    <?php } ?></td>
                <td class="actions">

                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $userSite['UserSite']['UserSiteID'])); ?>

                    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $userSite['UserSite']['UserSiteID']), null, __('Are you sure you want to delete # %s?', $userSite['UserSite']['UserSiteID'])); ?>

                    <?php if (!empty($userSite['Url']['RedirectLocation'])) {  ?>
                        <span class="chgToRedir"><a class="changeToRedirect" data-url="<?php echo $userSite['UserSite']['URLID']; ?>">Chg URL to Redir Loc</a></span>
                    <?php } ?>

                </td>
            </tr>
  
    <!-- HERE END ONE listing  -->
        <?php endforeach; ?>
    </table> 
    <p>
        <?php
        echo $this->Paginator->counter(array(
        'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
        ));
        ?> 
    </p>
    <div class="paging">
    <?php
        echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
        echo $this->Paginator->numbers(array('separator' => ''));
        echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
    ?>
    </div>
</div>
