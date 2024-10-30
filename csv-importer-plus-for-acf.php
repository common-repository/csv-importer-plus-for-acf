<?php

/**
 * @package CsvImporterPlusforACF
 */

/*
Plugin Name: CSV Importer Plus for ACF
Plugin URI: https://bestropro.com/
Description: CSV Importer Plus for ACF is a powerful and user-friendly plugin that allows you to effortlessly import and map CSV data into your posts, pages, and custom post types. With support for a wide range of standard post/page fields and ACF fields, this plugin provides a seamless solution for managing data in WordPress. Unlock even more with the premium version, offering advanced support for 20+ acf fields, including Repeater, Flexible Content, Gallery, WYSIWYG Editor, and more. CSV Importer Plus for ACF is perfect for developers and content creators looking to streamline their workflow and enhance their ACF and content management capabilities.
Author: mobeenraheem
Requires at least: 5.8
Requires PHP: 5.6.20
Tested up to: 6.6
Version: 1.0.7
License: GPLv2 or later
Text Domain: csv-importer-plus-for-acf
Domain Path: /languages/
*/

// make sure we don't expose any info if called directly
if (!defined('ABSPATH')) exit; // Exit if accessed directly

use CIPFA\base\CIPFA_Deactivate;
use CIPFA\base\CIPFA_Activate;
use CIPFA\base\CIPFA_BaseController;
use CIPFA\CIPFA_Init;

//composer autoload
if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
   require_once dirname(__FILE__) . '/vendor/autoload.php';
}

//load textdomain
load_plugin_textdomain('csv-importer-plus-for-acf', false, CIPFA_BaseController::$plugin_path . 'languages/');

//check if ACF plugin is active
add_action('admin_init', 'cipfa_check_acf_plugin');

function cipfa_check_acf_plugin()
{
   //Check if ACF exists
   if (!class_exists('ACF')) {
      //deactivate the plugin if ACF is not active
      deactivate_plugins(plugin_basename(__FILE__));
      //prevent the 'Plugin activated' notice from appearing
      cipfa_remove_activation_notice();
      //display an admin notice for the missing ACF plugin
      add_action('admin_notices', 'cipfa_acf_notice');
      //stop further execution of the plugin
      return;
   }
}

//remove the default Plugin activated notice
function cipfa_remove_activation_notice()
{
   add_action('admin_notices', function () {
      unset($_GET['activate']);
   }, 15);
}

//ACF plugin requires notice
function cipfa_acf_notice()
{
?>
   <div class="notice notice-error is-dismissible">
      <p><?php esc_html_e('CSV Importer Plus for ACF requires the Advanced Custom Fields (ACF) plugin or Secure Custom Fields (SCF) to be installed and activated. The plugin has been deactivated.', 'csv-importer-plus-for-acf'); ?></p>
   </div>
<?php
}


//plugin activation
register_activation_hook(__FILE__, array(CIPFA_Activate::class, 'cipfa_activate'));
//plugin deactivation
register_deactivation_hook(__FILE__, array(CIPFA_Deactivate::class, 'cipfa_deactivate'));

//initialization of classes
if (class_exists('CIPFA\\CIPFA_Init') && class_exists('ACF')) {
   CIPFA_Init::cipfa_registerServices();
}
