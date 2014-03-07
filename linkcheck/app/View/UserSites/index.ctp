<div class="userSites index">
    <h2>
        <?php echo __('Larrybeth Bookmarks Link Checker Report'); ?>
    </h2>
    SORT BY:

            <?php echo $this->Paginator->sort('UserSiteID'); ?>
            <?php echo $this->Paginator->sort('UserID'); ?>
            <?php echo $this->Paginator->sort('SiteDescr'); ?>
            <?php echo $this->Paginator->sort('URLID'); ?>
           
            <?php echo $this->Paginator->sort('ExtendedDesc'); ?>
            <?php echo $this->Paginator->sort('OrigPostingTime'); ?>

    <?php foreach ($userSites as $userSite): ?>
        <!--  HERE BEGIN ONE listing -->
    <div class="one-url">
        <table>
            <tr>
                <td class="label">UserID:</td>
                <td>
            <?php echo $this->Html->link($userSite['User']['UserID'], array('controller' => 'users', 'action' => 'view', $userSite['User']['UserID'])); ?>
                </td>
            </tr>
            <tr>
                <td class="label">URL:</td>
                <td>
                    <?php echo $this->Html->link($userSite['Url']['URL'], $userSite['Url']['URL']); ?>
                </td>
            </tr>
            <tr>
                <td class="label">Description/Title:</td>
                <td><?php echo h($userSite['UserSite']['SiteDescr']); ?></td>
            </tr>

             <?php if (!empty($userSite['UserSite']['ExtendedDesc'])) {  ?>
                <tr>
                    <td class="label">Extended Description:</td>
                    <td><?php echo h($userSite['UserSite']['ExtendedDesc']); ?></td>
                </tr>
             <?php } ?>
            <tr>
                <td class="label">Date Posted:</td>
                <td><?php echo h($userSite['UserSite']['OrigPostingTime']); ?></td>
            </tr>
            <tr>
                <td class="label">Message:</td>
                <td><?php echo $userSite['Url']['ErrorText']; ?></td>
            </tr>
            <?php if (!empty($userSite['Url']['RedirectLocation'])) {  ?>
                <tr>
                    <td class="label">Redirect Location:</td>
                    <td><?php echo $this->Html->link($userSite['Url']['RedirectLocation'], $userSite['Url']['RedirectLocation']); ?></td>
                </tr>
            <?php } ?>
            
        </table>
        <div class="actions">
            <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $userSite['UserSite']['UserSiteID'])); ?>
            <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $userSite['UserSite']['UserSiteID']), null, __('Are you sure you want to delete # %s?', $userSite['UserSite']['UserSiteID'])); ?>
        </div>

    </div> <!-- one-url -->
    <!-- HERE END ONE listing  -->
<?php endforeach; ?>
  
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