<?php

/**
 * @package CsvImporterPlusforACF
 */

namespace CIPFA\base;

// make sure we don't expose any info if called directly
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class CIPFA_Activate
{
    public static function cipfa_activate()
    {
        if (get_option('cipfa_total_imported_so_far') === false) {
            add_option('cipfa_total_imported_so_far', 0);
        }

        if (get_option('cipfa_import_completed') === false) {
            add_option('cipfa_import_completed', false);
        }
    }
}
