<?php

/**
 * @package CsvImporterPlusforACF
 */

namespace CIPFA\base;

// make sure we don't expose any info if called directly
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class CIPFA_SettingsLinks extends CIPFA_BaseController
{
   //register plugin upgarde link
   public static function cipfa_register()
   {
      add_filter('plugin_action_links_' . parent::$plugin_name, array(__CLASS__, 'cipfa_settingLinks'));
      add_filter('plugin_row_meta', array(__CLASS__, 'cipfa_plugin_meta_links'), 10, 2);
      add_filter('admin_footer_text', array(__CLASS__, 'cipfa_admin_footer_text'));
   }

   //add upgrade link
   public static function cipfa_settingLinks($links)
   {
      //add dashboard link
      $upgardeLink = '<a href="' . esc_url('https://bestropro.com/') . '" target="_blank">' . esc_html__('CSV Importer Plus Pro for ACF', 'csv-importer-plus-for-acf') . '</a>';

      array_push($links, $upgardeLink);
      return $links;
   }

   //add links to plugin's description
   public static function cipfa_plugin_meta_links($links, $file)
   {
      // Ensure that we're only modifying this plugin's links
      if (strpos($file, 'csv-importer-plus-for-acf') !== false) {
         $support_link = '<a href="' . esc_url('https://wordpress.org/support/plugin/csv-importer-plus-for-acf') . '" target="_blank" title="' . esc_html__('Get help', 'csv-importer-plus-for-acf') . '">' . esc_html__('Support', 'csv-importer-plus-for-acf') . '</a>';
         $home_link = '<a href="' . esc_url('https://bestropro.com/') . '" target="_blank" title="' . esc_html__('Plugin Homepage', 'csv-importer-plus-for-acf') . '">' . esc_html__('Plugin Homepage', 'csv-importer-plus-for-acf') . '</a>';
         $rate_link = '<a href="' . esc_url('https://wordpress.org/support/plugin/csv-importer-plus-for-acf/reviews/#new-post') . '" target="_blank" title="' . esc_html__('Rate the plugin', 'csv-importer-plus-for-acf') . '">' . esc_html__('Rate the plugin ★★★★★', 'csv-importer-plus-for-acf') . '</a>';

         // Add the custom links to the existing ones
         $links[] = $support_link;
         $links[] = $home_link;
         $links[] = $rate_link;
      }
      return $links;
   }

   //test if we're on plugin page
   public static function cipfa_is_plugin_page()
   {
      $current_screen = get_current_screen();

      if (!empty($current_screen->id) && ($current_screen->id == 'toplevel_page_csv_importer_plus_for_acf' || $current_screen->id == 'csv-importer-plus-for-acf_page_csv_importer_plus_for_acf_upgrade')) {
         return true;
      } else {
         return false;
      }
   }

   //add review link to plugin footer page
   public static function cipfa_admin_footer_text($text)
   {
      if (!self::cipfa_is_plugin_page()) {
         return $text;
      }

      $text = 'Please <a href="' . esc_url('https://wordpress.org/support/plugin/csv-importer-plus-for-acf/reviews/#new-post') . '" target="_blank" title="' . esc_html__('Rate the plugin', 'csv-importer-plus-for-acf') . '">' . esc_html__('Rate the plugin', 'csv-importer-plus-for-acf') . ' <span class="rate-star">★★★★★</span></a> ' . esc_html__('to help us spread the word. Thank you from the CSV Importer Plus for ACF team!', 'csv-importer-plus-for-acf');

      return $text;
   }
}
