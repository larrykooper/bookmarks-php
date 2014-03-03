<div class="userSites view">
<h2><?php echo __('User Site'); ?></h2>
	<dl>
		<dt><?php echo __('UserSiteID'); ?></dt>
		<dd>
			<?php echo h($userSite['UserSite']['UserSiteID']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($userSite['User']['UserID'], array('controller' => 'users', 'action' => 'view', $userSite['User']['UserID'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('SiteDescr'); ?></dt>
		<dd>
			<?php echo h($userSite['UserSite']['SiteDescr']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Url'); ?></dt>
		<dd>
			<?php echo $this->Html->link($userSite['Url']['URL'], array('controller' => 'urls', 'action' => 'view', $userSite['Url']['URLID'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('InRotation'); ?></dt>
		<dd>
			<?php echo h($userSite['UserSite']['InRotation']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('ExtendedDesc'); ?></dt>
		<dd>
			<?php echo h($userSite['UserSite']['ExtendedDesc']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('OrigPostingTime'); ?></dt>
		<dd>
			<?php echo h($userSite['UserSite']['OrigPostingTime']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Private'); ?></dt>
		<dd>
			<?php echo h($userSite['UserSite']['Private']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User Site'), array('action' => 'edit', $userSite['UserSite']['UserSiteID'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete User Site'), array('action' => 'delete', $userSite['UserSite']['UserSiteID']), null, __('Are you sure you want to delete # %s?', $userSite['UserSite']['UserSiteID'])); ?> </li>
		<li><?php echo $this->Html->link(__('List User Sites'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Site'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Urls'), array('controller' => 'urls', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Url'), array('controller' => 'urls', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
