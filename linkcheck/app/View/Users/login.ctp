<div class="users form">
<?php echo $this->Session->flash('auth'); ?> 
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend>
            <?php echo __('Please enter your username and password'); ?> 
        </legend>
        <?php echo $this->Form->input('UserID');
        echo $this->Form->input('Password', array('type' => 'password')); 
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Login')); ?> 
</div>