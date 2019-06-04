<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 10/01/2018
 * Time: 15:26
 */

namespace UdyWfToWp\Ui;

class Form{

	private $form;
	private $form_wrapper;

	public function __construct( $form_wrapper = true ) {
		$this->form_wrapper = $form_wrapper;
		if($this->form_wrapper) {
			$this->form = '<div class="cdg-woo-kit-form">';
		}
	}

	public function add_title($title = '', $size = 'medium', $class = ''){
		switch ($size) {
			case 'xsmall':
				$this->form .= '<h4 class="' . $class . '">' . $title . '</h4>';
				break;
			case 'small':
				$this->form .= '<h3 class="' . $class . '">' . $title . '</h3>';
				break;
			case 'medium':
				$this->form .= '<h2 class="' . $class . '">' . $title . '</h2>';
				break;
			case 'large':
				$this->form .= '<h1 class="' . $class . '">' . $title . '</h1>';
				break;
		}
		$this->add_break_line();
	}

	public function add_break_line(){
		$this->form .= '<div class="cdg-woo-kit-form-break-line"></div>';
	}

	public function add_break_line_border($class = ''){
		$this->form .= '<div class="cdg-woo-kit-form-break-line-border ' . $class . '"></div>';
	}

	public function add_datepicker($id = '', $input_name = '', $field_name = '', $value = '', $description = '', $required = false, $class = ''){
		$field = '<div class="cdg-woo-kit-form-field ' . $class . '">';
		$field .= '<label for="' . $id . '">' . $field_name . '</label>';
		$required = $required ? 'required' : '';
		$field .= '<input class="cdg-woo-kit-ui-datepicker" ' . $required . ' type="text" id="' . $id . '" name="' . $input_name . '" value="' . $value . '">';
		$field .= '<span class="cdg-woo-kit-form-field-description">' . $description . '</span>';
		$field .= '</div>';

		$this->form .= $field;
	}

	public function add_datetimepicker($id = '', $input_name = '', $field_name = '', $value = '', $description = '', $required = false, $class = ''){
		$field = '<div class="cdg-woo-kit-form-field ' . $class . '">';
		$field .= '<label for="' . $id . '">' . $field_name . '</label>';
		$required = $required ? 'required' : '';
		$field .= '<input class="cdg-woo-kit-ui-datetimepicker" ' . $required . ' type="text" id="' . $id . '" name="' . $input_name . '" value="' . $value . '">';
		$field .= '<span class="cdg-woo-kit-form-field-description">' . $description . '</span>';
		$field .= '</div>';

		$this->form .= $field;
	}

	public function add_raw($raw, $class = ''){
		$this->form .= '<div class="cdg-woo-kit-form-field ' . $class . '">'.$raw.'</div>';
	}

	public function add_key_value( $key, $value, $class = '' ){
		$line = "<p><strong>$key:</strong> $value</p>";
		$this->add_raw($line, $class);
	}

	public function add_text($id = '', $input_name = '', $field_name = '', $placeholder = '', $value = '', $description = '', $required = false, $class = ''){
		$field = '<div class="cdg-woo-kit-form-field ' . $class . '">';
			$field .= '<label for="' . $id . '">' . $field_name . '</label>';
			$required = $required ? 'required' : '';
			$field .= '<input ' . $required . ' type="text" id="' . $id . '" name="' . $input_name . '" placeholder="' . $placeholder . '" value="' . $value . '">';
			$field .= '<span class="cdg-woo-kit-form-field-description">' . $description . '</span>';
		$field .= '</div>';

		$this->form .= $field;
	}

	public function add_wp_editor($id = '', $input_name = '', $field_name = '', $content = '', $height_px = '400',$class = ''){
		$field = '<div class="cdg-woo-kit-form-field-wp-editor ' . $class . '">';
			$field .= '<label for="' . $id . '">' . $field_name . '</label>';
		$settings = array(
			'teeny' => true,
			'tabindex' => 1
		);

		ob_start();

		wp_editor( $content, $id, $settings );

		$temp = ob_get_clean();
		$temp .= '<style>.cdg-woo-kit-form-field-wp-editor iframe{min-height: '. $height_px .'px !important;}</style>';
		//$temp .= \_WP_Editors::enqueue_scripts();
		//print_footer_scripts();
		//$temp .= \_WP_Editors::editor_js();
		$field.=$temp;

		$field .= '</div>';

		$this->form .= $field;
	}

	public function add_email($id = '', $input_name = '', $field_name = '', $placeholder = '', $value = '', $description = '', $required = false, $class = ''){
		$field = '<div class="cdg-woo-kit-form-field ' . $class . '">';
		$field .= '<label for="' . $id . '">' . $field_name . '</label>';
		$required = $required ? 'required' : '';
		$field .= '<input ' . $required . ' type="email" id="' . $id . '" name="' . $input_name . '" placeholder="' . $placeholder . '" value="' . $value . '">';
		$field .= '<span class="cdg-woo-kit-form-field-description">' . $description . '</span>';
		$field .= '</div>';

		$this->form .= $field;
	}

	public function add_hidden($id = '', $input_name = '', $value = '', $class = ''){
		$field = '<div class="cdg-woo-kit-form-field hidden-input ' . $class . '">';
			$field .= '<input type="hidden" id="' . $id . '" name="' . $input_name . '" value="' . $value . '">';
		$field .= '</div>';
		$this->form .= $field;
	}

	public function add_button($id = '', $text = '', $class = '', $btn_class = '', $disabled = false){
		$field = '<div class="cdg-woo-kit-form-field ' . $class . '">';

		$disabled = $disabled ? 'disabled' : '';

		$field .= '<button ' . $disabled  . ' type="button" id="' . $id . '" class="' . $btn_class . '">' . $text . '</button>';
		$field .= '</div>';
		$this->form .= $field;
	}

	public function add_number($id = '', $input_name = '', $field_name = '', $placeholder = '', $value = '', $min = 0, $max = 1000, $description = '', $required = false, $class = '', $step = 1){
		$field = '<div class="cdg-woo-kit-form-field ' . $class . '">';
			$field .= '<label for="' . $id . '">' . $field_name . '</label>';
			$required = $required ? 'required' : '';
			$field .= '<input step="' . $step . '" ' . $required . ' min="' . $min . '" max="' . $max . '" type="number" id="' . $id . '" name="' . $input_name . '" placeholder="' . $placeholder . '" value="' . $value . '">';
			$field .= '<span class="cdg-woo-kit-form-field-description">' . $description . '</span>';
		$field .= '</div>';

		$this->form .= $field;
	}

	public function add_password($id = '', $input_name = '', $field_name = '', $value = '', $description = '', $required = false, $class = ''){
		$field = '<div class="cdg-woo-kit-form-field ' . $class . '">';
			$field .= '<label for="' . $id . '">' . $field_name . '</label>';
			$required = $required ? 'required' : '';
			$field .= '<input ' . $required . ' type="password" id="' . $id . '" name="' . $input_name . '" value="' . $value . '">';
			$field .= '<span class="cdg-woo-kit-form-field-description">' . $description . '</span>';
		$field .= '</div>';

		$this->form .= $field;
	}

	public function add_checkbox($id = '', $input_name = '', $field_name = '', $value = '', $checked = false, $required = false, $class = ''){
		$field = '<div class="cdg-woo-kit-form-field checkbox ' . $class . '">';
			$required = $required ? 'required' : '';
			$field .= '<input ' . ($checked ? 'checked' : '') . $required . ' type="checkbox" id="' . $id . '" name="' . $input_name . '" value="' . $value . '">';
			$field .= '<label for="' . $id . '">' . $field_name . '</label>';
		$field .= '</div>';

		$this->form .= $field;
	}

	public function add_radio($id = '', $input_name = '', $field_name = '', $value = '', $checked = false,  $required = false, $class = ''){
		$field = '<div class="cdg-woo-kit-form-field radio ' . $class . '">';
			$required = $required ? 'required' : '';
			$field .= '<input ' . ($checked ? 'checked' : '') . $required . ' type="radio" id="' . $id . '" name="' . $input_name . '" value="' . $value . '">';
			$field .= '<label for="' . $id . '">' . $field_name . '</label>';
		$field .= '</div>';

		$this->form .= $field;
	}

	public function add_switch_boolean($id = '', $input_name = '', $field_name = '', $checked = true, $class = ''){
		$field = '<div class="cdg-woo-kit-form-field switch ' . $class . '">';

			$field .= '<div class="cdg-woo-kit-form-switch-field">';
				$field .= '<div class="cdg-woo-kit-form-switch-title">' . $field_name . '</div>';
				$field .= '<input type="radio" id="' . $id . '_left" name="' . $input_name . '" value="true" ' . ($checked ? 'checked' : '') . '/>';
				$field .= '<label for="' . $id . '_left">Yes</label>';
				$field .= '<input type="radio" id="' . $id . '_right" name="' . $input_name . '" value="false" ' . ($checked ? '' : 'checked') . ' />';
				$field .= '<label for="' . $id . '_right">No</label>';
			$field .= '</div>';

		$field .= '</div>';

		$this->form .= $field;
	}

	public function add_wp_nonce($action, $name, $referer = false){
		$this->form .= wp_nonce_field( $action, $name, $referer, false );
	}

	public function add_select($id = '', $input_name = '', $field_name = '', $options = array(), $selected = '', $description = '', $multiple = false, $required = false, $class = '', $attributes = array()){
		$field = '<div class="cdg-woo-kit-form-field ' . $class . '">';
		$field .= '<label for="' . $id . '">' . $field_name . '</label>';
		$required = $required ? 'required' : '';
		$multiple = $multiple ? 'multiple' : '';

		$attribute_flat = '';
		foreach ($attributes as $key => $value){
			$attribute_flat .= $key . '="' . $value . '" ';
		}

		$field .= '<select ' . $attribute_flat . $required . ' ' . $multiple . ' id="' . $id . '" name="' . $input_name . '">';
			foreach ($options as $value => $text){
				if($multiple == true){
					if($selected == '[*]') {
						$field .= '<option selected value="' . $value . '">' . $text . '</option>';
					}else{
						$field .= '<option ' . ( in_array( $value, $selected ) ? 'selected' : '' ) . ' value="' . $value . '">' . $text . '</option>';
					}
				}else{
					$field .= '<option ' . ($selected == $value ? 'selected' : '') . ' value="' . $value . '">' . $text . '</option>';
				}
			}
		$field .= '</select>';
		$field .= '<span class="cdg-woo-kit-form-field-description">' . $description . '</span>';
		$field .= '</div>';

		$this->form .= $field;
	}

	public function add_select_optgroups($id = '', $input_name = '', $field_name = '', $optgroups = array(), $selected = '', $description = '', $multiple = false, $required = false, $class = '', $attributes = array()){
		$field = '<div class="cdg-woo-kit-form-field ' . $class . '">';
		$field .= '<label for="' . $id . '">' . $field_name . '</label>';
		$required = $required ? 'required' : '';
		$multiple = $multiple ? 'multiple' : '';

		$attribute_flat = '';
		foreach ($attributes as $key => $value){
			$attribute_flat .= $key . '="' . $value . '" ';
		}

		$field .= '<select ' . $attribute_flat . $required . ' ' . $multiple . ' id="' . $id . '" name="' . $input_name . '">';
		foreach ($optgroups as $optgroup_name => $optgroup_options) {
			$field .= '<optgroup label="'. $optgroup_name . '">';
			foreach ( $optgroup_options as $value => $text ) {
				if ( $multiple == true ) {
					if ( $selected == '[*]' ) {
						$field .= '<option selected value="' . $value . '">' . $text . '</option>';
					} else {
						$field .= '<option ' . ( in_array( $value, $selected ) ? 'selected' : '' ) . ' value="' . $value . '">' . $text . '</option>';
					}
				} else {
					$field .= '<option ' . ( $selected == $value ? 'selected' : '' ) . ' value="' . $value . '">' . $text . '</option>';
				}
			}
			$field .= '</optgroup>';
		}
		$field .= '</select>';
		$field .= '<span class="cdg-woo-kit-form-field-description">' . $description . '</span>';
		$field .= '</div>';

		$this->form .= $field;
	}

	public function add_submit( $value = 'Submit', $class = ''){
		$field = '<input type="submit" class="cdg-woo-kit-submit-button button button-primary '.$class.'" value="'.$value.'">';
		$this->form .= $field;
	}

	public function get_form($echo = false){
		if($this->form_wrapper) {
			$this->form .= '</div>';
		}

		if($echo){
			echo $this->form;
		}else{
			return $this->form;
		}
	}

	public function add_textarea($name, $value,  $rows = 4, $cols = 50, $class = '', $title = '') {
		$field = '<div class="cdg-woo-kit-form-field ' . $class . '">';
		if($title != '')
			$field .= "<label>$title</label>";

		$field .= "<textarea rows=\"$rows\" cols=\"$cols\" class=\"cdg-woo-kit-textarea\" name='$name'>
$value
</textarea>";
		$field .= '</div>';

		$this->form .= $field;
	}

	public function add_color_picker($id = '', $input_name = '', $field_name = '', $placeholder = '', $value = '', $description = '', $required = false, $class = ''){
		$this->form .= '<div class="cdg-woo-kit-form-field ' . $class . '">';
		$this->add_text($id, $input_name, '<div class="colorpicker-preview"></div>' . $field_name, $placeholder, $value, $description, $required, $class. ' cdg-woo-kit-color-field');
		$this->form .= '</div>';
	}

}