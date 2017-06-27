<?php
/**
 * Plugin Name: O2N Guests
 * Plugin URI:
 * Description: Export guests list in csv format
 * Version: 0.0.1
 * Author: Laguigue & Clems
 * Author URI: http://ecvdigital.fr/
 * License: GPL2
 */

class O2nGuests
{
    /**
     * Start up
     */
    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_plugin_page'));
        add_action( 'admin_enqueue_scripts', array($this, 'enqueue_Scripts'));
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        add_menu_page(
            'Guests',
            'Export Guests',
            'administrator',
            'export-guests',
            array($this, 'create_admin_page'),
            'dashicons-admin-generic'
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option('settings_options');

        ?>
        <div class="wrap guests-page">
            <h1>Bienvenue dans le Guests-Generator !</h1>
            <p>En cliquant sur le bouton ci dessous, vous téléchargerez la liste des emails rentrés sur le site au format csv.</p>

            <div>
                <a id="guestGenerator" >Télécharger les adresses mail</a>
            </div>
        </div>
        <?php
    }

    public function enqueue_Scripts($hook) {
        wp_enqueue_script( 'generateGuestsCsv', plugin_dir_url( __FILE__) . 'js/main.js' );
        wp_enqueue_style( 'generateGuestsCsv', plugin_dir_url( __FILE__) . 'css/main.css' );
    }

}

if (is_admin())
    $my_settings_page = new O2nGuests();
