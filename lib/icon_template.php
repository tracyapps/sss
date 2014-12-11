<?php
/**
 * template to display the icon chooser in admin
 */
	$cb_id =  esc_attr( sanitize_text_field( $data_row['value'] ) );
	$icon_path = get_template_directory_uri() . '/assets/img/icons/png/';
?>
<div class="fm-option category-icon" style="width: 60px; height: 50px; float: left; padding: 5px; margin-right: 20px; margin-bottom: 20px; border:1px solid #ccc;">
	<input
		class="fm-element"
		type="radio"
		value="<?php echo esc_attr( basename( $cb_id ) ); ?>"
		name="<?php echo $this->get_form_name(); ?>"
		id="<?php echo $cb_id; ?>"
		<?php echo $this->get_element_attributes(); ?>
		<?php echo $this->option_selected( $data_row['value'], $value, "checked" ); ?>
		/>
	<?php if ( '' !=  $cb_id ) : // if there's an icon selected ?>
		<label for="<?php echo esc_attr( basename( $cb_id ) ); ?>" class="fm-option-label">
			<?php
			echo '<img src="' .  $icon_path;
			echo esc_attr( basename( $cb_id ) );
			echo '" style="width: 40px; height: auto; float:right;" />';
			?>
		</label>
	<?php else : // if there is no icon selected ?>
		<label for="blank" class="fm-option-label">
			<strong><?php esc_html_e( 'No icon', 'sss' ); ?></strong>
		</label>
	<?php endif; ?>
</div>