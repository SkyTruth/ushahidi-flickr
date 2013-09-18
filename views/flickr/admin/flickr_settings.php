<table style="width: 630px;" class="my_table">
	<tr>
		<td>
			<span class="big_blue_span"><?php echo Kohana::lang('settings.flickr_key');?></span>
		</td>
		<td>
			<div class="row">
				<?php print form::input('flickr_key', $form['flickr_key'], ' class="text title_2"'); ?>
			</div>
                </td>
        </tr>
	<tr>
		<td>
			<span class="big_blue_span"><?php echo Kohana::lang('settings.flickr_key');?></span>
		</td>
		<td>
			<div class="row">
				<?php print form::input('flickr_secret', $form['flickr_secret'], ' class="text title_2"'); ?>
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<span class="big_blue_span"><?php echo Kohana::lang('settings.flickr_token');?></span>
		</td>
		<td>
			<div class="row">
				<?php print $form['flickr_token']; ?>
			</div>
		</td>
	</tr>
</table>
