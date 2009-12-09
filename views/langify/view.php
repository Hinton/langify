<table width="800px">
	<thead>
		<tr>
			<th width="120px"><?php echo i18n::get('key'); ?></th>
			<th>English</th>
			<th width="320px"><?php echo i18n::get('string'); ?></th>
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
			<?php if (isset($english[$key->id])): ?>
				<td><?php echo $english[$key->id]; ?></td>
			<?php else: ?>
				<td></td>
			<?php endif ?>
			<td>
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
					
					echo html::image('tmedia/img/ajax.gif', array('class' => 'ajax'));
											
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