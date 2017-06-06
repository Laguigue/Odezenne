<?php
/**
 * Plugin Name: O2N Soundcloud
 * Plugin URI:
 * Description: Activate or disable Souncloud tracks users will be able to listen to on the website.
 * Version: 0.0.1
 * Author: Bram van Osta
 * Author URI: http://ecvdigital.fr/
 * License: GPL2
 */
require_once 'soundcloud.php';
require_once 'o2n_api.php';

class O2nSoundcloudSettings
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    private $tracks;

    private $o2nApi;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_plugin_page'));
        add_action('admin_init', array($this, 'page_init'));
        add_action('update_option_soundcloud_tracks', array($this, 'update_track_list'), 10, 2);
        add_action('update_option_soundcloud_options', array($this, 'update_client_id'), 10, 2);
        $this->o2nApi = new O2nApi();
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        add_menu_page(
            'Soundcloud',
            'Soundcloud',
            'administrator',
            'soundcloud-settings',
            array($this, 'create_admin_page'),
            'dashicons-controls-play'
        );
    }

    public function update_track_list($old_value, $new_value)
    {
        // Call Lumen API to update its database
        $this->o2nApi->setTracksList($new_value);
    }

    public function update_client_id($old_value, $new_value)
    {
        // Call Lumen API to update its database
        $this->o2nApi->setClientId($new_value['client_id']);
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {

        if (defined('WP_DEBUG_LOG'))
            $GLOBALS['wp_log']['woocommerce soundcloud'][] = 'test 3';

        // Set class property
        $this->options = get_option('soundcloud_options');
        $this->tracks = get_option('soundcloud_tracks');
        ?>
        <div class="wrap">
            <h1>Soundcloud Settings</h1>
            <form method="post" action="options.php">
                <?php
                // This prints out all hidden setting fields
                settings_fields('o2n_soundcloud_settings_group');
                do_settings_sections('soundcloud-settings');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {
        register_setting(
            'o2n_soundcloud_settings_group', // Option group
            'soundcloud_options', // Option name
            array($this, 'sanitize') // Sanitize
        );

        register_setting(
            'o2n_soundcloud_settings_group', // Option group
            'soundcloud_tracks' // Option name
        );

        // Options section
        add_settings_section(
            'setting_section_soundcloud_options', // ID
            'Options', // Title
            array($this, 'print_options_section_info'), // Callback
            'soundcloud-settings' // Page
        );

        add_settings_field(
            'client_id', // ID
            'Soundcloud Client ID', // Title
            array($this, 'client_id_callback'), // Callback
            'soundcloud-settings', // Page
            'setting_section_soundcloud_options' // Section
        );

        // Tracks section
        add_settings_section(
            'setting_section_soundcloud_tracks', // ID
            'Tracks', // Title
            array($this, 'print_tracks_section_info'), // Callback
            'soundcloud-settings' // Page
        );

        if (!empty(get_option('soundcloud_options')['client_id'])) {
            $soundcloud = new Soundcloud();
            // userId for Odezenne
            $tracks = $soundcloud->getAllTracks('2074352');
            // userId for Smokey Joe & The Kids
            // $tracks = $soundcloud->getAllTracks('1794844');

            foreach ($tracks as $track) {
                add_settings_field(
                    $track['id'], // ID
                    $track['title'], // Title
                    array($this, 'track_callback'), // Callback
                    'soundcloud-settings', // Page
                    'setting_section_soundcloud_tracks', // Section
                    $track
                );
            }
        }

    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     * @return array $new_input
     */
    public function sanitize($input)
    {
        $new_input = array();
        if (isset($input['client_id']))
            $new_input['client_id'] = sanitize_text_field($input['client_id']);
        if (isset($input['enable_all_tracks']))
            $new_input['enable_all_tracks'] = $input['enable_all_tracks'];
        if (isset($input['305230910']))
            $new_input['305230910'] = $input['305230910'];

        return $new_input;
    }

    /**
     * Print the Options Section text
     */
    public function print_options_section_info()
    {
        print 'Soundcloud options';
    }

    /**
     * Print the Tracks Section text
     */
    public function print_tracks_section_info()
    {
        print 'Choose the tracks to enable';
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function client_id_callback()
    {
        printf(
            '<input type="text" id="client_id" name="soundcloud_options[client_id]" value="%s" />',
            isset($this->options['client_id']) ? esc_attr($this->options['client_id']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function track_callback($track)
    {
        printf(
            '<input type="checkbox" name="soundcloud_tracks[%s]" value="1" %s />',
            $track['id'],
            checked(1 == $this->tracks[$track['id']], true, false)
        );
    }
}

if (is_admin())
    $my_settings_page = new O2nSoundcloudSettings();
