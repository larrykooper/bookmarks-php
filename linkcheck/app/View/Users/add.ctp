<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Add User'); ?></legend>
	<?php
		echo $this->Form->input('UserID');
		echo $this->Form->input('Password');
		echo $this->Form->input('EmailAddress');
		echo $this->Form->input('FullName');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List User Sites'), array('controller' => 'user_sites', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Site'), array('controller' => 'user_sites', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List User Site Tags'), array('controller' => 'user_site_tags', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Site Tag'), array('controller' => 'user_site_tags', 'action' => 'add')); ?> </li>
	</ul>
</div>
