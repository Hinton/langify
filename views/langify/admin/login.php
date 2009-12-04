<div class="login">
<?php
	echo form::open();
	
	echo form::label('Username');
	echo form::input('username');
	
	echo '<br /><br />';
	
	echo form::label('Password');
	echo form::password('password');
	
	echo '<br /><br />';
	
	echo form::submit('Login', 'login');
	
	echo form::close();
?>
</div>