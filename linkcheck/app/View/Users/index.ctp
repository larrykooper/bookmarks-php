<div class="users index">
	<h2><?php echo __('Users'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('UserID'); ?></th>
			<th><?php echo $this->Paginator->sort('Password'); ?></th>
			<th><?php echo $this->Paginator->sort('EmailAddress'); ?></th>
			<th><?php echo $this->Paginator->sort('FullName'); ?></th>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($users as $user): ?>
	<tr>
		<td><?php echo h($user['User']['UserID']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['Password']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['EmailAddress']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['FullName']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['id']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $user['User']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $user['User']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $user['User']['id']), null, __('Are you sure you want to delete # %s?', $user['User']['id'])); ?>
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
	    
	   <li> <?php echo $this->Html->link( "Logout",   array('action'=>'logout') ); ?></li>
	    
		<li><?php echo $this->Html->link(__('New User'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List User Sites'), array('controller' => 'user_sites', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Site'), array('controller' => 'user_sites', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List User Site Tags'), array('controller' => 'user_site_tags', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Site Tag'), array('controller' => 'user_site_tags', 'action' => 'add')); ?> </li>
	</ul>
</div>
