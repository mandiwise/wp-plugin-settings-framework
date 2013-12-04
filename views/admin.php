<?php 

/*
 *
 * Instructions:
 * Find and replace "PLUGIN_NAME" with your plugin options class name (e.g. "My_Plugin")
 * Find and replace "PLUGIN NAME" with your plugin name (e.g. "My Plugin")
 * Find and replace "PREFIX" with a prefix to help identify the options (e.g. "my_plugin")
 * 
 */

if( !class_exists( 'PLUGIN_NAME_Settings' ) ) { 
	class PLUGIN_NAME_Settings { 
		
		// - array of sections for the plugin -
		private $sections;
		private $checkboxes;
		private $settings;
		
		// - construct the plugin settings object -
		public function __construct() { 
			
			$this->checkboxes = array();
			$this->settings = array();
			$this->get_settings();
			
			// - create the settings sections -
			$this->sections['general'] = __( 'General Settings' );
			$this->sections['extra'] = __( 'Extra Settings' );
			
			add_action( 'admin_menu', array( &$this, 'add_submenu' ) );
			add_action( 'admin_init', array( &$this, 'admin_init' ) );  
			
			if ( ! get_option( 'PREFIX_options' ) )
			$this->initialize_settings();
			
		}
		
		// - create the settings fields -
		public function create_setting( $args = array() ) {
		
			$defaults = array(
				'id'      => 'default_field',
				'title'   => __( 'Default Field' ),
				'desc'    => '',
				'std'     => '',
				'type'    => 'text',
				'section' => 'general',
				'choices' => array(),
				'class'   => ''
			);
			
			extract( wp_parse_args( $args, $defaults ) );
		
			$field_args = array(
				'type'      => $type,
				'id'        => $id,
				'desc'      => $desc,
				'std'       => $std,
				'choices'   => $choices,
				'label_for' => $id,
				'class'     => $class
			);
		
			if ( $type == 'checkbox' )
				$this->checkboxes[] = $id;
		
			add_settings_field( $id, $title, array( $this, 'display_setting' ), 'PREFIX-options', $section, $field_args );
		}
		
		// - create the HTML output for each possible type of setting -
		public function display_setting( $args = array() ) {
		
			extract( $args );
			$options = get_option( 'PREFIX_options' );
		
			if ( ! isset( $options[$id] ) && $type != 'checkbox' )
				$options[$id] = $std;
			elseif ( ! isset( $options[$id] ) )
				$options[$id] = 0;
		
			$field_class = '';
			if ( $class != '' )
				$field_class = ' ' . $class;
		
			switch ( $type ) {
			
				case 'checkbox':
					echo '<input class="checkbox' . $field_class . '" type="checkbox" id="' . $id . '" name="PREFIX_options[' . $id . ']" value="1" ' . checked( $options[$id], 1, false ) . ' /> <label for="' . $id . '">' . $desc . '</label>';
					break;
			
				case 'select':
					echo '<select class="select' . $field_class . '" name="PREFIX_options[' . $id . ']">';
					foreach ( $choices as $value => $label )
						echo '<option value="' . esc_attr( $value ) . '"' . selected( $options[$id], $value, false ) . '>' . $label . '</option>';
					echo '</select>';
				
					if ( $desc != '' )
						echo '<p class="description">' . $desc . '</p>';
					break;
			
				case 'radio':
					$i = 0;
					foreach ( $choices as $value => $label ) {
						echo '<input class="radio' . $field_class . '" type="radio" name="PREFIX_options[' . $id . ']" id="' . $id . $i . '" value="' . esc_attr( $value ) . '" ' . checked( $options[$id], $value, false ) . '> <label for="' . $id . $i . '">' . $label . '</label>';
						if ( $i < count( $options ) - 1 )
							echo '<br />';
						$i++;
					}
				
					if ( $desc != '' )
						echo '<p class="description">' . $desc . '</p>';
					break;
			
				case 'textarea':
					echo '<textarea class="' . $field_class . '" id="' . $id . '" name="PREFIX_options[' . $id . ']" placeholder="' . $std . '" rows="5" cols="30">' . wp_htmledit_pre( $options[$id] ) . '</textarea>';
				
					if ( $desc != '' )
						echo '<p class="description">' . $desc . '</p>';
					break;
			
				case 'password':
					echo '<input class="regular-text' . $field_class . '" type="password" id="' . $id . '" name="PREFIX_options[' . $id . ']" value="' . esc_attr( $options[$id] ) . '" />';
				
					if ( $desc != '' )
						echo '<p class="description">' . $desc . '</p>';
					break;
			
				case 'text':
				default:
					echo '<input class="regular-text' . $field_class . '" type="text" id="' . $id . '" name="PREFIX_options[' . $id . ']" placeholder="' . $std . '" value="' . esc_attr( $options[$id] ) . '" />';
				
					if ( $desc != '' )
						echo '<p class="description">' . $desc . '</p>';
					break;
			}
		
		}
		
		// - define all settings for this plugin and their defaults -
		public function get_settings() {
		
			// - this is where you create your settings... -
		
			$this->settings['example_text'] = array(
				'section' => 'general',
				'title'   => __( 'Example Text Input' ),
				'desc'    => __( 'This is a description for the text input.' ),
				'type'    => 'text',
				'std'     => 'Default value'
			);
		
			$this->settings['example_select'] = array(
				'section' => 'general',
				'title'   => __( 'Example Select' ),
				'desc'    => __( 'This is a description for the drop-down.' ),
				'type'    => 'select',
				'std'     => '',
				'choices' => array(
					'choice1' => 'Other Choice 1',
					'choice2' => 'Other Choice 2',
					'choice3' => 'Other Choice 3'
				)
			);
			
			$this->settings['example_checkbox'] = array(
				'section' => 'extra',
				'title'   => __( 'Example Checkbox' ),
				'desc'    => __( 'This is a description for the checkbox.' ),
				'type'    => 'checkbox',
				'std'     => 1 // - set to 1 to be checked by default, 0 to be unchecked by default -
			);
		
		}
		
		// - initialize the settings to their default values -
		public function initialize_settings() {
		
			$default_settings = array();
			foreach ( $this->settings as $id => $setting ) {
				$default_settings[$id] = $setting['std'];
			}
		
			update_option( 'PREFIX_options', $default_settings );
		
		}
		
		// - callback for the general section -
		public function display_general_section() {
			echo '<p>These settings do general things for the plugin.</p>'; 
		}
		
		// - callback for the extra section -
		public function display_extra_section() {
			echo '<p>These settings do extra things for the plugin.</p>'; 
		}
		
		// - callback for future sections that don't have descriptions -
		public function display_section() {
			// - the default echos nothing for the description - 
		}
		
		public function admin_init() {
		
			register_setting( 'PREFIX_options', 'PREFIX_options', array( &$this, 'validate_settings' ) );

			foreach ( $this->sections as $slug => $title ) {
				if ( $slug == 'general' )
					add_settings_section( $slug, $title, array( &$this, 'display_general_section' ), 'PREFIX-options' );
				elseif ( $slug == 'extra' )
					add_settings_section( $slug, $title, array( &$this, 'display_extra_section' ), 'PREFIX-options' );
				else
					add_settings_section( $slug, $title, array( &$this, 'display_section' ), 'PREFIX-options' );
			}		

			$this->get_settings();

			foreach ( $this->settings as $id => $setting ) {
				$setting['id'] = $id;
				$this->create_setting( $setting );
		
			}
		}
		
		// - add the submenu page -
		public function add_submenu() { 
			add_options_page( 'PLUGIN Settings', 'PLUGIN Settings', 'manage_options', 'PREFIX-options', array( &$this, 'plugin_settings_page' ) );
		}
		
		public function plugin_settings_page() { 
			if( !current_user_can( 'manage_options' ) ) { 
				wp_die( __( 'Sorry! You don\'t have sufficient permissions to access this page.' ) ); 
			} 
			
			// - render the settings template - 
			include( sprintf( "%s/settings.php", dirname( __FILE__ ) ) ); 
		}
		
		public function validate_settings( $input ) {
			// - create array for storing the validated options  
			$output = array();  
  
			// - loop through each of the incoming options -
			foreach( $input as $key => $value ) {  
	  
				// - check to see if the current option has a value and then process it -  
				if( isset( $input[$key] ) ) {  
					$output[$key] = strip_tags( stripslashes( $input[ $key ] ) );  
				}
	  
			}

			return apply_filters( 'validate_settings', $output, $input ); 
		}
		
	} // - end class PLUGIN_NAME_Settings -
} // - end 'if class exists' -

// * Gets the plugin options (to be used in other plugin files) *
	
function PREFIX_option( $option ) {
	$options = get_option( 'PREFIX_options' );
	if ( isset( $options[$option] ) )
		return $options[$option];
	else
		return false;
}