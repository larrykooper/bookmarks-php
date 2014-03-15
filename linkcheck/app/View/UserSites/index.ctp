<?php $myUrl = Router::url(null, true); ?>
<div class="userSites index">
    <h2 class="page-title">
        <?php echo __('Larrybeth Bookmarks Link Checker Report'); ?>
    </h2>
    <span class="code-label">
        THESE ARE BAD:
    </span>
    <span class="codes">
        <?php
        echo $this->Html->link('0',
    array('controller' => 'UserSites', 'action' => 'index', 0), array('class' => 'code-link'));
        echo $this->Html->link('410',
    array('controller' => 'UserSites', 'action' => 'index', 410), array('class' => 'code-link'));
        echo $this->Html->link('502',
    array('controller' => 'UserSites', 'action' => 'index', 502), array('class' => 'code-link'));
        ?>
    <span class="code-label">
        USUALLY BAD:
    </span>
        <?php
        echo $this->Html->link('500',
    array('controller' => 'UserSites', 'action' => 'index', 500), array('class' => 'code-link'));
        ?>
    <span class="code-label">
        THESE ARE REDIRECTS:
    </span>
        <?php
        echo $this->Html->link('301',
    array('controller' => 'UserSites', 'action' => 'index', 301), array('class' => 'code-link'));
        echo $this->Html->link('302',
    array('controller' => 'UserSites', 'action' => 'index', 302), array('class' => 'code-link'));
        echo $this->Html->link('303',
    array('controller' => 'UserSites', 'action' => 'index', 303), array('class' => 'code-link'));
        echo $this->Html->link('307',
    array('controller' => 'UserSites', 'action' => 'index', 307), array('class' => 'code-link'));
        ?>
    <span class="code-label">
        SITE EXISTS, PAGE DOES NOT:
    </span>
         <?php
        echo $this->Html->link('404',
    array('controller' => 'UserSites', 'action' => 'index', 404), array('class' => 'code-link'));
        ?>
    <span class="code-label">
        THESE REQUIRE INVESTIGATION:
    </span>
         <?php
        echo $this->Html->link('400',
    array('controller' => 'UserSites', 'action' => 'index', 400), array('class' => 'code-link'));
        echo $this->Html->link('401',
    array('controller' => 'UserSites', 'action' => 'index', 401), array('class' => 'code-link'));
        echo $this->Html->link('403',
    array('controller' => 'UserSites', 'action' => 'index', 403), array('class' => 'code-link'));
        echo $this->Html->link('503',
    array('controller' => 'UserSites', 'action' => 'index', 503), array('class' => 'code-link'));
        ?>
    <span class="code-label">
        THESE ARE USUALLY OK:
    </span>
        <?php
        echo $this->Html->link('200',
    array('controller' => 'UserSites', 'action' => 'index', 200), array('class' => 'code-link'));
        echo $this->Html->link('405',
    array('controller' => 'UserSites', 'action' => 'index', 405), array('class' => 'code-link'));
        echo $this->Html->link('406',
    array('controller' => 'UserSites', 'action' => 'index', 406), array('class' => 'code-link'));
        ?>
    </span>
    <span class="sort-by-code">
        SORT BY
        <?php echo $this->Paginator->sort('Url.HttpCode', 'HTTP Code'); ?>
    </span>
    <table class="sites-table">
        <tr>
            <th class="url-col"><?php echo $this->Paginator->sort('Url.URL', 'URL'); ?></th>
            <th class="title"><?php echo $this->Paginator->sort('SiteDescr', 'Title'); ?></th>

            <th class="extended-col"><?php echo $this->Paginator->sort('ExtendedDesc'); ?></th>
            <th class="tags-col">Tags</th>
            <th class="post-date"><?php echo $this->Paginator->sort('OrigPostingTime', 'Posting Date'); ?></th>
            <th class="message-col">Message</th>
            <th class="actions">Actions</th>
        </tr>
        <?php foreach ($userSites as $userSite): ?>
            <tr class="one-url" data-url="<?php echo $userSite['UserSite']['URLID']; ?>">
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

                    <form action="/larrybeth/bookmarks/linkcheck/UserSites/delete/<?php echo $userSite['UserSite']['UserSiteID']; ?>" name="post_<?php echo $userSite['UserSite']['UserSiteID']; ?>" id="post_<?php echo $userSite['UserSite']['UserSiteID']; ?>" style="display:none;" method="post">        
                        <input type="hidden" name="_method" value="POST"/>
                        <input type="hidden" name="redirect-url" value="<?php echo $myUrl ?>">
                    </form>
                    <a class="delete-button" onclick=" if (confirm(&quot;Are you sure?&quot;)) {
                        document.post_<?php echo $userSite['UserSite']['UserSiteID']; ?>.submit(); }
                        event.returnValue = false; return false;">
                            Delete
                    </a>

                    <?php if (!empty($userSite['Url']['RedirectLocation'])) {  ?>
                        <span class="chgToRedir"><a class="changeToRedirect" data-url="<?php echo $userSite['UserSite']['URLID']; ?>">Chg URL to Redir Loc</a></span>
                    <?php } ?>

                </td>
            </tr>
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
    <?php echo $this->Html->link( "Logout", array('controller' => 'Users','action'=>'logout') ); ?>
</div>
