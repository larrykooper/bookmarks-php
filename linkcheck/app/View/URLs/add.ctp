<div class="uRLs form">
<?php echo $this->Form->create('URL'); ?>
	<fieldset>
		<legend><?php echo __('Add U R L'); ?></legend>
	<?php
		echo $this->Form->input('URL');
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

		<li><?php echo $this->Html->link(__('List U R Ls'), array('action' => 'index')); ?></li>
	</ul>
</div>
