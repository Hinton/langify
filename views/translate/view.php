<table>
	<thead>
		<tr>
			<th width="100px">Key</th>
			<th width="250px">String</th>
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
				<div class="info">
				<?php 
					if (isset($strings[$key->id])) {
						
						echo $strings[$key->id];
						
					} else {
						
						echo 'Untranslated';
					
					}
				?>
				</div>
				<div class="form">
					<?php 
						echo form::open();
						
						echo form::hidden('id', $key->id);
						
						if (isset($strings[$key->id])) {
							echo form::input('string', $strings[$key->id]);
						} else {
							echo form::input('string');
						}
						
						echo form::submit('submit', 'Edit', array('class' => 'change'));
						
						echo form::close();
					?>
				</div>
			</td>
			<td><?php echo html::image('tmedia/img/edit.png', array('class' => 'edit')); ?></td>
		</tr>
		<?php
			$i = $i+1;
			endforeach;
		?>
	</tbody>
</table>