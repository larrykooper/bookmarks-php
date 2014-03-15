<div class="users view">
<h2><?php echo __('User'); ?></h2>
	<dl>
		<dt><?php echo __('UserID'); ?></dt>
		<dd>
			<?php echo h($user['User']['UserID']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Password'); ?></dt>
		<dd>
			<?php echo h($user['User']['Password']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('EmailAddress'); ?></dt>
		<dd>
			<?php echo h($user['User']['EmailAddress']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('FullName'); ?></dt>
		<dd>
			<?php echo h($user['User']['FullName']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($user['User']['id']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete User'), array('action' => 'delete', $user['User']['id']), null, __('Are you sure you want to delete # %s?', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List User Sites'), array('controller' => 'user_sites', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Site'), array('controller' => 'user_sites', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List User Site Tags'), array('controller' => 'user_site_tags', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Site Tag'), array('controller' => 'user_site_tags', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related User Sites'); ?></h3>
	<?php if (!empty($user['UserSite'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('UserSiteID'); ?></th>
		<th><?php echo __('UserID'); ?></th>
		<th><?php echo __('SiteDescr'); ?></th>
		<th><?php echo __('URLID'); ?></th>
		<th><?php echo __('InRotation'); ?></th>
		<th><?php echo __('ExtendedDesc'); ?></th>
		<th><?php echo __('OrigPostingTime'); ?></th>
		<th><?php echo __('Private'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($user['UserSite'] as $userSite): ?>
		<tr>
			<td><?php echo $userSite['UserSiteID']; ?></td>
			<td><?php echo $userSite['UserID']; ?></td>
			<td><?php echo $userSite['SiteDescr']; ?></td>
			<td><?php echo $userSite['URLID']; ?></td>
			<td><?php echo $userSite['InRotation']; ?></td>
			<td><?php echo $userSite['ExtendedDesc']; ?></td>
			<td><?php echo $userSite['OrigPostingTime']; ?></td>
			<td><?php echo $userSite['Private']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'user_sites', 'action' => 'view', $userSite['UserSiteID'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'user_sites', 'action' => 'edit', $userSite['UserSiteID'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'user_sites', 'action' => 'delete', $userSite['UserSiteID']), null, __('Are you sure you want to delete # %s?', $userSite['UserSiteID'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New User Site'), array('controller' => 'user_sites', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related User Site Tags'); ?></h3>
	<?php if (!empty($user['UserSiteTag'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('UserSiteTagID'); ?></th>
		<th><?php echo __('UserID'); ?></th>
		<th><?php echo __('URLID'); ?></th>
		<th><?php echo __('TagOrder'); ?></th>
		<th><?php echo __('Tag'); ?></th>
		<th><?php echo __('UserSiteID'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($user['UserSiteTag'] as $userSiteTag): ?>
		<tr>
			<td><?php echo $userSiteTag['UserSiteTagID']; ?></td>
			<td><?php echo $userSiteTag['UserID']; ?></td>
			<td><?php echo $userSiteTag['URLID']; ?></td>
			<td><?php echo $userSiteTag['TagOrder']; ?></td>
			<td><?php echo $userSiteTag['Tag']; ?></td>
			<td><?php echo $userSiteTag['UserSiteID']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'user_site_tags', 'action' => 'view', $userSiteTag['UserSiteTagID'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'user_site_tags', 'action' => 'edit', $userSiteTag['UserSiteTagID'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'user_site_tags', 'action' => 'delete', $userSiteTag['UserSiteTagID']), null, __('Are you sure you want to delete # %s?', $userSiteTag['UserSiteTagID'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New User Site Tag'), array('controller' => 'user_site_tags', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
