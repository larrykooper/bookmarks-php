<div class="uRLs index">
    <h2>
        <?php echo __('Larrybeth Bookmarks Link Checker Report'); ?>
    </h2>
    SORT BY:

    <?php echo $this->Paginator->sort('URLID'); ?>
    <?php echo $this->Paginator->sort('URL'); ?>
    <?php echo $this->Paginator->sort('LastChecked'); ?>
    <?php echo $this->Paginator->sort('HttpCode'); ?>
    <?php echo $this->Paginator->sort('ErrorText'); ?>
    <?php echo $this->Paginator->sort('RedirectLocation'); ?>

    <?php foreach ($uRLs as $uRL): ?>
        <!--  HERE BEGIN ONE SITE (URL) -->
        <div class="one-url">
            <table>
                <tr>
                    <td class="label">URLID:</td>
                    <td><?php echo h($uRL['URL']['URLID']); ?></td>
                </tr>
                <tr>
                    <td class="label">URL:</td>
                    <td><a href="<?php echo $uRL['URL']['URL'] ?>"><?php echo h($uRL['URL']['URL']); ?></a></td>
                </tr>
                <tr>
                    <td class="label">Last Checked:</td>
                    <td><?php echo h($uRL['URL']['LastChecked']); ?></td>
                </tr>
                <tr>
                    <td class="label">Http Code:</td>
                    <td><?php echo h($uRL['URL']['HttpCode']); ?></td>
                </tr>
                <tr>
                    <td class="label">Message:</td>
                    <td><?php echo h($uRL['URL']['ErrorText']); ?></td>
                </tr>
                <tr>
                    <td class="label">Redirect Location:</td>
                    <td><?php echo h($uRL['URL']['RedirectLocation']); ?></td>
                </tr>
            </table>
            <div class="actions">
                <?php echo $this->Html->link(__('View'), array('action' => 'view', $uRL['URL']['URLID'])); ?>
                <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $uRL['URL']['URLID'])); ?>
                <?php echo $this->Form->postLink(__('Delete - not working yet'), array('action' => 'delete', $uRL['URL']['URLID']), null, __('Are you sure you want to delete # %s?', $uRL['URL']['URLID'])); ?>
            </div>

        </div> <!-- one-url -->
        <!-- HERE END ONE SITE  -->
    <?php endforeach; ?>
    <?php echo $this->Html->link(__('Add a URL'), array('action' => 'add')); ?>
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
