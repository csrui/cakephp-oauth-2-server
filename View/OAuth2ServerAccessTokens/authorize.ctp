<?php
/**
 * @file
 * Sample authorize endpoint.
 *
 * This sample provides two click-jacking prevention methods, neither which are perfect. 
 * The javascript solution is similar to what facebook used to have (but can be defeated with a 
 * specially crafted frame-wrapper).
 */

// Clickjacking prevention (supported by IE8+, FF3.6.9+, Opera10.5+, Safari4+, Chrome 4.1.249.1042+)
header('X-Frame-Options: DENY');
?>

<script>
	if (top != self) {
		window.document.write("<div style='background:black; opacity:0.5; filter: alpha (opacity = 50); position: absolute; top:0px; left: 0px;"
		+ "width: 9999px; height: 9999px; zindex: 1000001' onClick='top.location.href=window.location.href'></div>");
	}
</script>


<p>Do you authorize <strong><?php echo $client['OAuth2ServerClient']['name'] ?></strong> to access your data on <?php echo configure::read('App.name') ?>?</p>

<p class="client-description"><?php echo $client['OAuth2ServerClient']['description'] ?></p>

<?php echo $this->Form->create(null) ?>

      <?php foreach ($auth_params as $key => $value) : ?>
      	<input type="hidden" name="<?php echo htmlspecialchars($key, ENT_QUOTES); ?>" value="<?php echo htmlspecialchars($value, ENT_QUOTES); ?>" />
      <?php endforeach; ?>

	
		<input type="submit" name="accept" value="yes" /> 
		<input type="submit" name="accept" value="no" />

<?php echo $this->Form->end(); ?>