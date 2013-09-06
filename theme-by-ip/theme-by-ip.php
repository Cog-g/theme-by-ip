<?php
/*
Plugin Name: Theme by IP
Plugin URI: http://const.fr/wordpress-plugin-theme-ip
Description: This plugin will serve another theme, regarding IP. useful to test a theme only visible by you.
Author: Constantin Guay
Author URI: http://const.fr
Version: 1.0
*/

if(!class_exists('CG_Theme_by_ip'))
{
    class CG_Theme_by_ip {

        public function CG_Theme_by_ip() {
            $this->__construct();
        }

        public function __construct() {

            if( is_admin() ) {
                add_action('admin_init', array(&$this, 'admin_init'));
                add_action('admin_menu', array(&$this, 'add_menu'));
            }

            if( get_option('cg_theme_to_serve') != "" ) {

                $cg_list_IP_to_serve = explode( "\n", get_option('cg_list_IP_to_serve') );
                if( in_array($_SERVER['REMOTE_ADDR'], $cg_list_IP_to_serve) )
                {
                    add_filter('template', array( $this, 'serve_theme_by_ip'));
                    add_filter('option_template', array( $this, 'serve_theme_by_ip'));
                    add_filter('option_stylesheet', array( $this, 'serve_theme_by_ip'));
                }

            }

        }

        public function serve_theme_by_ip() {
            $theme = get_option('cg_theme_to_serve');
            return( $theme );
        }


        /** ==============================================================
         *  ADMIN SECTION
         *  =========================================================== */

        /**
         * What to do on inition
         */
        public function admin_init()
        {
        }

        /**
         * add a menu
         */
        public function add_menu()
        {
            /** ==============================================================
             *  Check if main CG menu exists
             *  =========================================================== */           
            global $menu;
            $menuExist = false;
            $cg_menu_slug = "options-general.php"; // default value: under Settings

            foreach($menu as $item) {
                if(strtolower($item[0]) == strtolower('CG Plugins')) {
                    $menuExist = true;
                }
            }
            if($menuExist) $cg_menu_slug = "CG-plugins-menu";
            /** =========================================================== */

            // Add a page to manage this plugin's settings
            add_submenu_page(
                $cg_menu_slug,
                'CG Theme by IP Settings',
                'CG Theme by IP',
                'manage_options',
                'plugin_name',
                array(&$this, 'cg_plugin_settings_page')
            );
        }

        public function cg_plugin_settings_page()
        {

            ?>
            <h1>Serve a theme, depending on IP</h1>
            <small style="display:block;">by <a href="http://const.fr" target="_blank">Constantin Guay</a></small>
            <?php
            // Render the settings template
            include( dirname( __FILE__ ) . "/templates/admin/settings.php" );
        }

    }

}

if(class_exists('CG_Theme_by_ip'))
{
    $CG_Theme_by_ip = new CG_Theme_by_ip();
}
?>