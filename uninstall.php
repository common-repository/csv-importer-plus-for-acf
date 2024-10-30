<?php

/**
 * @package CsvImporterPlusforACF
 *
 * Triger this file to uninstall plugin
 *
 */

// make sure this file called by wordpress only
if (!defined('WP_UNINSTALL_PLUGIN')) {
	die;
}

if (get_option('cipfa_total_imported_so_far') !== false) {
	delete_option('cipfa_total_imported_so_far');
}

if (get_option('cipfa_import_completed') !== false) {
	delete_option('cipfa_import_completed');
}
