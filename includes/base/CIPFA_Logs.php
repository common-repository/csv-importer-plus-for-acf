<?php

/**
 * @package CsvImporterPlusforACF
 */

namespace CIPFA\base;

// make sure we don't expose any info if called directly
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class CIPFA_Logs
{
   // Property to store error logs
   public static $view_logs = array();

   // Method to log errors
   public static function cipfa_Log($message)
   {
      self::$view_logs[] = $message;
   }
}
