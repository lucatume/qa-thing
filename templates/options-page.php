<div class="wrap">
	<h1><?php echo $title ?></h1>

	<form id="qa">
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e( 'Available configurations', 'qa' ) ?></th>
				<td>
					<?php if ( empty( $issues ) ) : ?>
						<p><?php _e( 'No configurations found...' ) ?></p>
					<?php else: ?>
						<select title="Select the configuration to apply" name="qa-configuration" class="widefat" id="qa-configuration">
							<?php /** @var qa_Interfaces_IssueInterface $issue */
							foreach ( $issues as $issue ) : ?>
								<option value="<?php echo $issue->getId() ?>">
									<?php echo $issue->getTitle() ?>
								</option>
							<?php endforeach; ?>
						</select>
					<?php endif; ?>
				</td>
			</tr>
		</table>

		<p class="submit">
			<button id="qa-apply" class="wp-rest button <?php echo $buttonClass ?>"><?php _e( 'Apply', 'qa' ) ?></button>
		</p>
	</form>

	<div id="qa-work-zone">
		<h4 id="qa-working-title" class="blink"><?php _e( 'Applying configuration: ', 'qa' ) ?><span class="target"></span></h4>
		<h4 id="qa-work-title"><?php _e( 'Applied configuration: ', 'qa' ) ?><span class="target"></span></h4>
		<div id="qa-work-log"
			 class="wp-rest"
			 contenteditable="true"
			 ic-poll="500ms"
			 ic-verb="POST"
			 ic-src="<?php echo $applyConfigUrl ?>"
			 ic-include="#qa"
			 ic-pause-polling="true">
			<p class="qa-notice"><?php _e( 'This is the work log: here the configuration script will output errors, notices and informations.', 'qa' ) ?></p>
		</div>
	</div>
</div>

