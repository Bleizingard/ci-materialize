<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container">
	<div class="row">
		<?php echo form_open('signin', array("class" => "col s12 m7 offset-m3 l6 offset-l3")); ?>
			<div class="row">
				<div class="input-field col s12">
				<?php 
					echo form_input($form_login);
					
					echo form_label($form_login_label);
				?>
					<input id="login" type="text" class="validate"> <label for="login">Login</label>
				</div>
			</div>
			<div class="row">
				<div class="input-field col s12">
					<input id="password" type="password" class="validate"> <label
						for="password">Password</label>
				</div>
			</div>
			<div class="row">
				<button class="btn waves-effect waves-light" type="submit">
					Sign in <i class="material-icons right">send</i>
				</button>
			</div>

		<?php echo form_close(); ?>
	</div>
</div>