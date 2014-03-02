<div class="uRLs view">
<h2><?php echo __('U R L'); ?></h2>
	<dl>
		<dt><?php echo __('URLID'); ?></dt>
		<dd>
			<?php echo h($uRL['URL']['URLID']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('URL'); ?></dt>
		<dd>
			<?php echo h($uRL['URL']['URL']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('LastChecked'); ?></dt>
		<dd>
			<?php echo h($uRL['URL']['LastChecked']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('HttpCode'); ?></dt>
		<dd>
			<?php echo h($uRL['URL']['HttpCode']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('ErrorText'); ?></dt>
		<dd>
			<?php echo h($uRL['URL']['ErrorText']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('RedirectLocation'); ?></dt>
		<dd>
			<?php echo h($uRL['URL']['RedirectLocation']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit U R L'), array('action' => 'edit', $uRL['URL']['URLID'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete U R L'), array('action' => 'delete', $uRL['URL']['URLID']), null, __('Are you sure you want to delete # %s?', $uRL['URL']['URLID'])); ?> </li>
		<li><?php echo $this->Html->link(__('List U R Ls'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New U R L'), array('action' => 'add')); ?> </li>
	</ul>
</div>
