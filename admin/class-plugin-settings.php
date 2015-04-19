<?php

/*
 * INSTRUCTIONS:
 *
 * Find and replace "PLUGIN_NAME" with your underscored plugin name (e.g. "My_Plugin")
 * Find and replace "PLUGIN NAME" with your the name of your plugin
 * Find and replace "PREFIX" with a prefix to help identify the options (e.g. "my_plugin")
 * Set your plugin text domain in the constructor function
 *
 */

/**
 * The settings page to control plugin options.
 *
 * @package    PLUGIN_NAME
 * @subpackage PLUGIN_NAME/admin
 * @author     Your Name <you@email.com>
 */
if ( ! class_exists( 'PLUGIN_NAME_Settings' ) ) {

   class PLUGIN_NAME_Settings {

      /**
       * The settings sections.
       *
       * @since    1.0.0
       * @access   private
       * @var      array    $sections    The array of settings sections.
       */
      private $sections;

      /**
       * The checkbox-based settings.
       *
       * @since    1.0.0
       * @access   private
       * @var      array    $checkboxes    The array of checkbox-based settings.
       */
      private $checkboxes;

      /**
       * The settings fields.
       *
       * @since    1.0.0
       * @access   private
       * @var      array    $settings    The array of settings fields.
       */
      private $settings;

      /**
       * The domain specified for this plugin.
       *
       * @since    1.0.0
       * @access   private
       * @var      string    $domain    The domain identifier for this plugin.
       */
      private $domain;

      /**
       * Initialize the class and set its properties.
       *
       * @since    1.0.0
       */
      public function __construct() {

         $this->domain = 'PREFIX';
         $this->settings = array();
         $this->checkboxes = array();
         $this->get_settings();

         // Create the settings sections
         $this->sections['general'] = __( 'General Settings', $this->domain );
         $this->sections['extra'] = __( 'Extra Settings', $this->domain );

         add_action( 'admin_menu', array( $this, 'add_submenu' ) );
         add_action( 'admin_init', array( $this, 'admin_init' ) );

         if ( ! get_option( 'PREFIX_options' ) ) {
            $this->initialize_settings();
         }

      }

      /**
       * Create settings field default args.
       *
       * @param    array    The default args for a given setting.
       * @since    1.0.0
       */
      public function create_setting( $args = array() ) {

         $defaults = array(
            'id'      => 'default_field',
            'title'   => __( 'Default Field', $this->domain ),
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

         if ( $type == 'checkbox' ) {
            $this->checkboxes[] = $id;
         }

         add_settings_field( $id, $title, array( $this, 'display_setting' ), 'PREFIX-options', $section, $field_args );
      }

      /**
       * Create the HTML output for each possible type of setting
       *
       * @param    array    The default args for a given setting.
       * @since    1.0.0
       */
      public function display_setting( $args = array() ) {

         extract( $args );
         $options = get_option( 'PREFIX_options' );

         if ( ! isset( $options[$id] ) && $type != 'checkbox' ) {
            $options[$id] = $std;
         } elseif ( ! isset( $options[$id] ) ) {
            $options[$id] = 0;
         }

         $field_class = '';

         if ( $class != '' ) {
            $field_class = ' ' . $class;
         }

         switch ( $type ) {

            case 'checkbox':
               echo '<input class="checkbox' . $field_class . '" type="checkbox" id="' . $id . '" name="PREFIX_options[' . $id . ']" value="1" ' . checked( $options[$id], 1, false ) . ' /> <label for="' . $id . '">' . $desc . '</label>';
            break;

            case 'select':
               echo '<select class="select' . $field_class . '" name="PREFIX_options[' . $id . ']">';
               foreach ( $choices as $value => $label ) {
                  echo '<option value="' . esc_attr( $value ) . '"' . selected( $options[$id], $value, false ) . '>' . $label . '</option>';
               }
               echo '</select>';

               if ( $desc != '' ) {
                  echo '<p class="description">' . $desc . '</p>';
               }
            break;

            case 'radio':
               $i = 0;
               foreach ( $choices as $value => $label ) {
                  echo '<input class="radio' . $field_class . '" type="radio" name="PREFIX_options[' . $id . ']" id="' . $id . $i . '" value="' . esc_attr( $value ) . '" ' . checked( $options[$id], $value, false ) . '> <label for="' . $id . $i . '">' . $label . '</label>';
                  if ( $i < count( $options ) - 1 )
                  echo '<br />';
                  $i++;
               }

               if ( $desc != '' ) {
                  echo '<p class="description">' . $desc . '</p>';
               }
            break;

            case 'textarea':
               echo '<textarea class="' . $field_class . '" id="' . $id . '" name="PREFIX_options[' . $id . ']" placeholder="' . $std . '" rows="5" cols="30">' . wp_htmledit_pre( $options[$id] ) . '</textarea>';

               if ( $desc != '' ) {
                  echo '<p class="description">' . $desc . '</p>';
               }
            break;

            case 'password':
               echo '<input class="regular-text' . $field_class . '" type="password" id="' . $id . '" name="PREFIX_options[' . $id . ']" value="' . esc_attr( $options[$id] ) . '" />';

               if ( $desc != '' ) {
                  echo '<p class="description">' . $desc . '</p>';
               }
            break;

            case 'text':
            default:
               echo '<input class="regular-text' . $field_class . '" type="text" id="' . $id . '" name="PREFIX_options[' . $id . ']" placeholder="' . $std . '" value="' . esc_attr( $options[$id] ) . '" />';

               if ( $desc != '' ) {
                  echo '<p class="description">' . $desc . '</p>';
               }
            break;
         }

      }

      /**
       * Define all settings for the plugin and their defaults.
       *
       * @since    1.0.0
       */
       public function get_settings() {

          // This is where the actual settings are created...

          $this->settings['example_text'] = array(
             'section' => 'general',
             'title'   => __( 'Example Text Input', $this->domain ),
             'desc'    => __( 'This is a description for the text input.', $this->domain ),
             'type'    => 'text',
             'std'     => __( 'Default value', $this->domain )
          );

          $this->settings['example_select'] = array(
            'section' => 'general',
            'title'   => __( 'Example Select', $this->domain ),
            'desc'    => __( 'This is a description for the drop-down.', $this->domain ),
            'type'    => 'select',
            'std'     => '',
            'choices' => array(
               'choice1' => __( 'Other Choice 1', $this->domain ),
               'choice2' => __( 'Other Choice 2', $this->domain ),
               'choice3' => __( 'Other Choice 3', $this->domain )
            )
          );

          $this->settings['example_checkbox'] = array(
             'section' => 'extra',
             'title'   => __( 'Example Checkbox', $this->domain ),
             'desc'    => __( 'This is a description for the checkbox.', $this->domain ),
             'type'    => 'checkbox',
             'std'     => 1 // set to 1 to be checked by default, 0 to be unchecked by default
          );

       }

      /**
       * Initialize the settings to their default values.
       *
       * @since    1.0.0
       */
      public function initialize_settings() {

         $default_settings = array();
         foreach ( $this->settings as $id => $setting ) {
            $default_settings[$id] = $setting['std'];
         }

         update_option( 'PREFIX_options', $default_settings );

      }

      /**
       * Callback for the "General" sample section.
       *
       * @since    1.0.0
       */
      public function display_general_section() {
         echo '<p>These settings do general things for the plugin.</p>';
      }

      /**
       * Callback for the "Extra" sample section.
       *
       * @since    1.0.0
       */
      public function display_extra_section() {
         echo '<p>These settings do extra things for the plugin.</p>';
      }

      /**
       * Callback for future sections that don't have descriptions.
       *
       * @since    1.0.0
       */
      public function display_section() {
         // The default echos nothing for the description...
      }

      /**
       * Initialize the sections and their settings.
       *
       * @since    1.0.0
       */
      public function admin_init() {

         register_setting( 'PREFIX_options', 'PREFIX_options', array( &$this, 'validate_settings' ) );

         foreach ( $this->sections as $slug => $title ) {
            if ( $slug == 'general' ) {
               add_settings_section( $slug, $title, array( &$this, 'display_general_section' ), 'PREFIX-options' );
            } elseif ( $slug == 'extra' ) {
               add_settings_section( $slug, $title, array( &$this, 'display_extra_section' ), 'PREFIX-options' );
            } else {
               add_settings_section( $slug, $title, array( &$this, 'display_section' ), 'PREFIX-options' );
            }
         }

         $this->get_settings();

         foreach ( $this->settings as $id => $setting ) {
            $setting['id'] = $id;
            $this->create_setting( $setting );

         }
      }

      /**
       * Add the submenu page.
       *
       * @since    1.0.0
       */
      public function add_submenu() {
         add_options_page(
            __( 'PLUGIN NAME Settings', $this->domain ),
            __( 'PLUGIN NAME', $this->domain ),
            'manage_options',
            'PREFIX-options',
            array( $this, 'plugin_settings_page' )
         );
      }

      /**
       * Display the plugin settings page if the user has sufficient privileges.
       *
       * @since    1.0.0
       */
      public function plugin_settings_page() {
         if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( __( 'Sorry! You don\'t have sufficient permissions to access this page.', $this->domain ) );
         }

         include( sprintf( "%s/partials/plugin-admin-display.php", dirname( __FILE__ ) ) );
      }

      /**
       * Perform custom validation on the settings prior to saving.
       *
       * @param    array    $input    The array of settings to be saved.
       * @since    1.0.0
       */
      public function validate_settings( $input ) {

         // Create array for storing the validated options
         $output = array();

         // Loop through each of the incoming options
         foreach( $input as $key => $value ) {

            // Check to see if the current option has a value and then process it
            if( isset( $input[$key] ) ) {
               $output[$key] = strip_tags( stripslashes( $input[ $key ] ) );
            }

         }

         return apply_filters( 'validate_settings', $output, $input );
      }

   } // end class PLUGIN_NAME_Settings

} // end if class_exists

/**
 * Get a plugin options by its key (to be used in other plugin files).
 */

function PREFIX_option( $option ) {
   $options = get_option( 'PREFIX_options' );

   if ( isset( $options[$option] ) ) {
      return $options[$option];
   } else {
      return false;
   }
}
