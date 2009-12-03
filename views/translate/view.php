<table width="800px">
	<thead>
		<tr>
			<th width="120px">Key</th>
			<th>English</th>
			<th width="320px">String</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$i = 0;
			foreach($keys as $key):
				
			if ($i % 2 == 1) {
				echo '<tr class="zebra">';
			} else {
				echo '<tr>';
			}
		?>
		
			<td><?php echo $key->key; ?></td>
			<td><?php echo $english[$key->id]; ?></td>
			<td>
				<?php
					/*
					if (isset($strings[$key->id])) {
						
						echo $strings[$key->id]['string'];
						
					} else {
						
						echo 'Untranslated';
					
					}*/
				?>
				<?php 
					echo form::open(NULL, array('class' => 'edit_form') );
					
					if (isset($strings[$key->id])) {
						echo form::hidden('id', $strings[$key->id]['id']);
					} else {
						echo form::hidden('key_id', $key->id);
					}
					
					if (isset($strings[$key->id])) {
						echo form::input('string', $strings[$key->id]['string']);
					} else {
						echo form::input('string');
					}
						
					echo form::submit('submit', 'Edit', array('class' => 'change'));
						
					echo form::close();
				?>
			</td>
		</tr>
		<?php
			$i = $i+1;
			endforeach;
		?>
	</tbody>
</table>