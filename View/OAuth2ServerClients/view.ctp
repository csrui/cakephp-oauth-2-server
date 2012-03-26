<div class="clients view">	
		
	<h3><?php echo $client['OAuth2ServerClient']['name'] ?></h3>
	
	<p><a href="<?php echo $client['OAuth2ServerClient']['url'] ?>"><?php echo $client['OAuth2ServerClient']['url'] ?></a></p>
	
	<p><?php echo $client['OAuth2ServerClient']['description'] ?></p>
	
	<dl>
		<dt>CLIENT ID</dt>
		<dd><?php echo $client['OAuth2ServerClient']['client_id'] ?></dd>
		<dt>CLIENT SECRET</dt>
		<dd><?php echo $client['OAuth2ServerClient']['client_secret'] ?></dd>
		<dt>CALLBACK URL</dt>
		<dd><?php echo $client['OAuth2ServerClient']['redirect_uri'] ?></dd>
	</dl>
	
		<?php echo $this->Html->link(__('Delete consumer'), array('action' => 'delete', $client['OAuth2ServerClient']['client_id'])) ?>
		
</div>