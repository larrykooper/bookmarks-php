<div class="uRLs form">
<?php echo $this->Form->create('URL'); ?>
	<fieldset>
		<legend><?php echo __('Edit U R L'); ?></legend>
	<?php
		echo $this->Form->input('URLID');
		echo $this->Form->input('URL', array('type' => 'text'));
		echo $this->Form->input('LastChecked');
		echo $this->Form->input('HttpCode');
		echo $this->Form->input('ErrorText');
		echo $this->Form->input('RedirectLocation');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('URL.URLID')), null, __('Are you sure you want to delete # %s?', $this->Form->value('URL.URLID'))); ?></li>
		<li><?php echo $this->Html->link(__('List U R Ls'), array('action' => 'index')); ?></li>
	</ul>
</div>
