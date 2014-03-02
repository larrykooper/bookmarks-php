<div class="uRLs index">
	<h2><?php echo __('U R Ls'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('URLID'); ?></th>
			<th><?php echo $this->Paginator->sort('URL'); ?></th>
			<th><?php echo $this->Paginator->sort('LastChecked'); ?></th>
			<th><?php echo $this->Paginator->sort('HttpCode'); ?></th>
			<th><?php echo $this->Paginator->sort('ErrorText'); ?></th>
			<th><?php echo $this->Paginator->sort('RedirectLocation'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($uRLs as $uRL): ?>
	<tr>
		<td><?php echo h($uRL['URL']['URLID']); ?>&nbsp;</td>
		<td><?php echo h($uRL['URL']['URL']); ?>&nbsp;</td>
		<td><?php echo h($uRL['URL']['LastChecked']); ?>&nbsp;</td>
		<td><?php echo h($uRL['URL']['HttpCode']); ?>&nbsp;</td>
		<td><?php echo h($uRL['URL']['ErrorText']); ?>&nbsp;</td>
		<td><?php echo h($uRL['URL']['RedirectLocation']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $uRL['URL']['URLID'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $uRL['URL']['URLID'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $uRL['URL']['URLID']), null, __('Are you sure you want to delete # %s?', $uRL['URL']['URLID'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New U R L'), array('action' => 'add')); ?></li>
	</ul>
</div>
