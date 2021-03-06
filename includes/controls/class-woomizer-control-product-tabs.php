<?php
/**
 * Custom WordPress Customize Control classes for product tabs
 *
 * @link       https://github.com/sofyansitorus
 * @since      1.0.0
 *
 * @package    Woomizer
 * @subpackage Woomizer/includes/controls
 */

/**
 * Woomizer_Control_Product_Tabs classes
 *
 * @since      1.0.0
 * @package    Woomizer
 * @subpackage Woomizer/includes/controls
 * @author     Sofyan Sitorus <sofyansitorus@gmail.com>
 */
class Woomizer_Control_Product_Tabs extends Woomizer_Customize_Control {
	/**
	 * Control's Type.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $type = 'product_tabs';

	/**
	 * Render content.
	 *
	 * @since      1.0.0
	 */
	public function render_content() {
		$tabs           = array(
			'description'            => __( 'Description Tab', 'woomizer' ),
			'additional_information' => __( 'Additional Information Tab', 'woomizer' ),
			'reviews'                => __( 'Reviews Tab', 'woomizer' ),
		);
		$input_id       = '_customize-input-' . $this->id;
		$description_id = '_customize-description-' . $this->id;
		$form_data      = $this->value();
		if ( is_array( $form_data ) ) {
			$form_data = wp_json_encode( $form_data );
		}
		$form_data = json_decode( $this->value(), true );
		if ( json_last_error() !== JSON_ERROR_NONE ) {
			$form_data = array(
				'description_hidden'            => 'no',
				'description_title'             => __( 'Description', 'woomizer' ),
				'additional_information_hidden' => 'no',
				'additional_information_title'  => __( 'Additional Information', 'woomizer' ),
				'reviews_hidden'                => 'no',
				// Translators: Reviews count.
				'reviews_title'                 => __( 'Reviews (%d)', 'woomizer' ),
			);
		}
		?>
		<?php if ( ! empty( $this->label ) ) : ?>
			<label for="<?php echo esc_attr( $this->id ); ?>" class="customize-control-title"><?php echo esc_html( $this->label ); ?></label>
		<?php endif; ?>
		<?php if ( ! empty( $this->description ) ) : ?>
			<span id="<?php echo esc_attr( $description_id ); ?>" class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
		<?php endif; ?>
		<div id="<?php echo esc_attr( $this->id ); ?>" class="woomizer_product_tabs_wrap">
		<div class="woomizer_product_tabs">
			<?php
			foreach ( $tabs as $tab_id => $tab_label ) {
				$hidden_value = isset( $form_data[ $tab_id . '_hidden' ] ) ? $form_data[ $tab_id . '_hidden' ] : 'no';
				$title_value  = isset( $form_data[ $tab_id . '_title' ] ) ? $form_data[ $tab_id . '_title' ] : '';
			?>
			<h3 class="accordion-toggle accordion-section-title"><?php echo esc_html( $tab_label ); ?></h3>
			<div class="accordion-content">
				<div class="woomizer_product_tabs_hidden">
					<label class="customize-control-title"><?php esc_html_e( 'Hide Tab', 'woomizer' ); ?></label>
					<input id="woomizer_product_tab_<?php echo esc_attr( $tab_id ); ?>_<?php echo esc_attr( $this->id ); ?>_hidden" type="checkbox" value="yes" data-name="<?php echo esc_attr( $tab_id ); ?>_hidden" <?php checked( $hidden_value, 'yes' ); ?> />
					<label for="woomizer_product_tab_<?php echo esc_attr( $tab_id ); ?>_<?php echo esc_attr( $this->id ); ?>_hidden" ><?php esc_html_e( 'Yes', 'woomizer' ); ?></label>
				</div>
				<hr />
				<div class="woomizer_product_tabs_title">
					<label for="woomizer_product_tab_<?php echo esc_attr( $tab_id ); ?>_<?php echo esc_attr( $this->id ); ?>_title" class="customize-control-title"><?php esc_html_e( 'Tab Title Text', 'woomizer' ); ?></label>
					<input id="woomizer_product_tab_<?php echo esc_attr( $tab_id ); ?>_<?php echo esc_attr( $this->id ); ?>_title" type="text" data-name="<?php echo esc_attr( $tab_id ); ?>_title" value="<?php echo esc_attr( $title_value ); ?>" />
				</div>
			</div>
			<?php
			}
			?>
		</div>
		<input
		id="<?php echo esc_attr( $input_id ); ?>"
		type="hidden"
		class="woomizer_product_tab_value"
		value="<?php echo esc_attr( $this->value() ); ?>"
		<?php $this->link(); ?>
		/>
		</div>
		<?php
	}

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @since 1.0.0
	 */
	public function enqueue() {
		$css_file = ( defined( 'WOOMIZER_DEV' ) && WOOMIZER_DEV ) ? add_query_arg( array( 't' => time() ), WOOMIZER_URL . 'assets/css/control-product-tabs.css' ) : WOOMIZER_URL . 'assets/css/control-product-tabs.min.css';
		wp_enqueue_style(
			'woomizer-control-product-tabs', // Give the script a unique ID.
			$css_file, // Define the path to the JS file.
			array(), // Define dependencies.
			WOOMIZER_VERSION, // Define a version (optional).
			false // Specify whether to put in footer (leave this false).
		);

		$js_file = ( defined( 'WOOMIZER_DEV' ) && WOOMIZER_DEV ) ? add_query_arg( array( 't' => time() ), WOOMIZER_URL . 'assets/js/control-product-tabs.js' ) : WOOMIZER_URL . 'assets/js/control-product-tabs.min.js';
		wp_enqueue_script(
			'woomizer-control-product-tabs', // Give the script a unique ID.
			$js_file, // Define the path to the JS file.
			array( 'jquery' ), // Define dependencies.
			WOOMIZER_VERSION, // Define a version (optional).
			true // Specify whether to put in footer (leave this true).
		);
	}
}
