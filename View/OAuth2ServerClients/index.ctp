<div class="clients index">
	
	<h2><?php echo __('OAuth Consumers') ?></h2>
	
	<?php foreach($clients as $client): ?>
		
		<div class="client">
			<h3><?php echo $this->Html->link($client['OAuth2ServerClient']['name'], array('action' => 'view', $client['OAuth2ServerClient']['client_id'])) ?></h3>
			<p><?php echo $client['OAuth2ServerClient']['description'] ?></p>
		</div>
		
	<?php endforeach; ?>
	
	<?php echo $this->Html->link(__('Register a new consumer'), array('action' => 'add')) ?>
	
</div>