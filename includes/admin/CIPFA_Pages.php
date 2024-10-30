<?php

/**
 * @package CsvImporterPlusforACF
 */

namespace CIPFA\admin;

// make sure we don't expose any info if called directly
if (!defined('ABSPATH')) exit; // Exit if accessed directly

use CIPFA\api\CIPFA_SettingsApi;
use CIPFA\api\callbacks\CIPFA_PagesCallBacks;

class CIPFA_Pages
{
    public $settings;
    public $callbacks;
    public $pages = [];
    public $sub_pages = [];

    public function __construct()
    {
        $this->settings = new CIPFA_SettingsApi();
        $this->callbacks = new CIPFA_PagesCallBacks();
    }

    public function cipfa_register()
    {
        $this->cipfa_setPages();
        $this->cipfa_setSubPages();
        $this->settings->cipfa_addPages($this->pages)->cipfa_withSubPages('CSV Importer Plus for ACF')->cipfa_addSubPages($this->sub_pages)->cipfa_register();
    }

    public function cipfa_setPages()
    {
        $this->pages = [
            [
                'page_title'   => 'CSV Importer Plus for ACF',
                'menu_title'   => 'CSV Importer Plus for ACF',
                'capability'   => 'manage_options',
                'menu_slug'    => 'csv_importer_plus_for_acf',
                'callback'     => array($this->callbacks, 'cipfa_csvAcfImporterForm'),
                'icon_url'     => 'dashicons-database-import',
                'position'     => 110
            ]
        ];
    }

    // upgrade sub page
    public function cipfa_setSubPages($var = null)
    {
        $this->sub_pages = [
            [
                'parent_slug'  => 'csv_importer_plus_for_acf',
                'page_title'   => 'CSV Importer Plus for ACF Upgrade',
                'menu_title'   => 'Upgrade',
                'capability'   => 'manage_options',
                'menu_slug'    => 'csv_importer_plus_for_acf_upgrade',
                'callback'     => array($this->callbacks, 'cipfa_upgradePageCallback')
            ]
        ];
    }
}
