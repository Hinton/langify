<table>
	<thead>
		<tr>
			<td>Key</td>
			<td>String</td>
		</tr>
	</thead>
	<tbody>
		<?php foreach($keys as $key): ?>
		<tr>
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
		</tr>
		<?php endforeach ?>
	</tbody>
</table>