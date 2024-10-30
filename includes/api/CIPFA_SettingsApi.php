<?php

/**
 * @package CsvImporterPlusforACF
 */

namespace CIPFA\api;

// make sure we don't expose any info if called directly
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class CIPFA_SettingsApi
{

   public $admin_pages = array();
   public $admin_subpages = array();

   //add menu page
   public function cipfa_register()
   {
      if (!empty($this->admin_pages)) {
         add_action('admin_menu', array($this, 'cipfa_addMenuPages'));
      }
   }

   //array of menu pages
   public function cipfa_addPages(array $pages)
   {
      $this->admin_pages = $pages;
      return $this;
   }

   //For first sub page
   public function cipfa_withSubPages(string $title = null)
   {
      if (empty($this->admin_pages)) {
         return $this;
      }

      $admin_page = $this->admin_pages[0];
      $subpage = [
         [
            'parent_slug'  => $admin_page['menu_slug'],
            'page_title'   => $admin_page['page_title'],
            'menu_title'   => $title ?: $admin_page['menu_title'],
            'capability'   => $admin_page['capability'],
            'menu_slug'    => $admin_page['menu_slug'],
            'callback'     => $admin_page['callback']
         ]
      ];

      $this->admin_subpages = $subpage;
      return $this;
   }

   //array of menu subpages
   public function cipfa_addSubPages(array $pages)
   {
      $this->admin_subpages = array_merge($this->admin_subpages, $pages);
      return $this;
   }

   //loop through pages add pages
   public function cipfa_addMenuPages()
   {
      //add page
      foreach ($this->admin_pages as $page) {
         add_menu_page($page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'], $page['callback'], $page['icon_url'], $page['position']);
      }
      //add subpages
      foreach ($this->admin_subpages as $page) {
         add_submenu_page($page['parent_slug'], $page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'], $page['callback']);
      }
   }
}
