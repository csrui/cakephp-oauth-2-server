<div class="clients form">
	
	<h3>Create a new OAuth client</h3>
	<?php echo $this->Form->create(); ?>
	
		<?php echo $this->Form->input('name') ?>
		<?php echo $this->Form->input('redirect_uri') ?>	
		
		
		<?php echo $this->Form->input('description') ?>	
	
	<?php echo $this->Form->end(__('Create')) ?>
	
</div>