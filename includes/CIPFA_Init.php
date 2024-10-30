<?php

/**
 * @package CsvImporterPlusforACF
 */

namespace CIPFA;

// make sure we don't expose any info if called directly
if (!defined('ABSPATH')) exit; // Exit if accessed directly

final class CIPFA_Init
{

   //set list of classes in array
   public static function cipfa_getServices()
   {
      return [
         admin\CIPFA_Pages::class,
         base\CIPFA_Enqueue::class,
         base\CIPFA_SettingsLinks::class,
         base\CIPFA_CsvImporter::class,
      ];
   }

   //loop through classes and register if they have register function
   public static function cipfa_registerServices()
   {
      foreach (self::cipfa_getServices() as $class) {
         $service = self::cipfa_instantiate($class);
         if (method_exists($service, 'cipfa_register')) {
            $service->cipfa_register();
         }
      }
   }

   //initializ class instance
   private static function cipfa_instantiate($class)
   {
      return new $class;
   }
}
