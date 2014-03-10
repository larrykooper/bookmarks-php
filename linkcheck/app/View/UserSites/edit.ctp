<div class="userSites form">
<?php echo $this->Form->create('UserSite'); ?>
	<fieldset>
		<legend><?php echo __('Edit User Site'); ?></legend>
	<?php
		echo $this->Form->input('UserSiteID');
		echo $this->Form->input('UserID');
		echo $this->Form->input('SiteDescr');
		echo $this->Form->input('URLID');
		echo $this->Form->input('ExtendedDesc');

	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List User Sites'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Urls'), array('controller' => 'urls', 'action' => 'index')); ?> </li>
	</ul>
</div>
