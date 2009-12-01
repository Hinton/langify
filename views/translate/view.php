<table>
	<thead>
		<tr>
			<th>Key</th>
			<th>String</th>
			<th></th>
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
			<td>
				<?php 
					if (isset($strings[$key->id])) {
						
						echo $strings[$key->id];
						
					} else {
						
						echo 'Untranslated';
					
					}
				?>
			</td>
			<td><?php echo html::image('tmedia/img/edit.png'); ?></td>
		</tr>
		<?php
			$i = $i+1;
			endforeach;
		?>
	</tbody>
</table>