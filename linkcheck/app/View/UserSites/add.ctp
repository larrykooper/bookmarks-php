<div class="userSites form">
<?php echo $this->Form->create('UserSite'); ?>
	<fieldset>
		<legend><?php echo __('Add User Site'); ?></legend>
	<?php
		echo $this->Form->input('UserID');
		echo $this->Form->input('SiteDescr');
		echo $this->Form->input('URLID');
		echo $this->Form->input('InRotation');
		echo $this->Form->input('ExtendedDesc');
		echo $this->Form->input('OrigPostingTime');
		echo $this->Form->input('Private');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List User Sites'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Urls'), array('controller' => 'urls', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Url'), array('controller' => 'urls', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
