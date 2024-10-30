<?php

/**
 * @package CsvImporterPlusforACF
 */

namespace CIPFA\base;

// make sure we don't expose any info if called directly
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class CIPFA_BaseController
{
   //plugin path,url & name
   public static $plugin_path;
   public static $plugin_url;
   public static $plugin_name;

   public function __construct()
   {
      //setting plugin path,url & name
      self::$plugin_path = plugin_dir_path(dirname(__FILE__, 2));
      self::$plugin_url  = plugin_dir_url(dirname(__FILE__, 2));
      self::$plugin_name = plugin_basename(self::$plugin_path . 'csv-importer-plus-for-acf.php');
   }
}
