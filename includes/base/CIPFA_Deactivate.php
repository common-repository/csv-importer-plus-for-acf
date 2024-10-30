<?php

/**
 * @package CsvImporterPlusforACF
 */

namespace CIPFA\base;

// make sure we don't expose any info if called directly
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class CIPFA_Deactivate
{
   public static function cipfa_deactivate()
   {
      if (get_option('cipfa_total_imported_so_far') !== false) {
         delete_option('cipfa_total_imported_so_far');
      }

      if (get_option('cipfa_import_completed') !== false) {
         delete_option('cipfa_import_completed');
      }
   }
}
