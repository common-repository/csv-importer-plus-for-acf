<?php

/**
 * @package CsvImporterPlusforACF
 */

namespace CIPFA\base;

// make sure we don't expose any info if called directly
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class CIPFA_Enqueue extends CIPFA_BaseController
{
   //register admin scripts and styles
   public static function cipfa_register()
   {
      add_action('admin_enqueue_scripts', array(__CLASS__, 'cipfa_adminEnqueue'));
   }

   //enqueue admin styles and scripts
   public static function cipfa_adminEnqueue()
   {
      wp_enqueue_style('csv-importer-plus-for-acf-styles', plugins_url('includes/admin/assets/css/csv-importer-plus-for-acf.css', self::$plugin_name), array(), '1.0.0');
      wp_enqueue_script('jquery');
      wp_enqueue_script('csv-importer-plus-for-acf-plugin-script', plugins_url('includes/admin/assets/js/csv-importer-plus-for-acf.js', self::$plugin_name), array('jquery'), '1.0.0', true);
   }
}
