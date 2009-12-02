<table width="700px">
	<thead>
		<tr>
			<th width="170px">Key</th>
			<th>String</th>
			<th width="20px"></th>
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
				<div class="info">
				<?php 
					if (isset($strings[$key->id])) {
						
						echo $strings[$key->id]['string'];
						
					} else {
						
						echo 'Untranslated';
					
					}
				?>
				</div>
				<div class="form">
					<?php 
						echo form::open();
						
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
				</div>
			</td>
			<td><?php echo html::image('tmedia/img/edit.png', array('class' => 'edit', 'title' => 'Edit')); ?></td>
		</tr>
		<?php
			$i = $i+1;
			endforeach;
		?>
	</tbody>
</table>