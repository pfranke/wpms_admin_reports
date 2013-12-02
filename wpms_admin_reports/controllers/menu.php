<?php
/**
 * Plugin Name: WordPress Multisite Admin Tools
 * Plugin URI: http://put in wordpress page
 * Description: This plugin is the combination of various multi-site plugins under a loose MVC framework with some features I wanted added in.
 * Version: 0.2
 * Author: Joe Motacek
 * Author URI: http://www.joemotacek.com
 * License: GPL2
 * 
 * @package wpms_admin_tools
 * @since 0.2
 *
 * Menu Controller
 * Purpose:
 *  - create menu in constructor  
 *  - subsequent callbacks make calls to the respective models and views
 */

if ( $_SERVER['SCRIPT_FILENAME'] == __FILE__ )
	die( 'Access denied.' );
	
require_once( MCMVC_PLUGIN_DIR . '/moto_core_mvc/controller.php');

if( !class_exists( 'wpmsar_menu_controller' ) ):

	class wpmsar_menu_controller extends mcmvc_controller {
		
		public function __construct() {
			$menu = add_menu_page(
				__('Admin Reports Dashboard'), 
				__('Admin Reports'), 
				'manage_network', 
				'wpms_admin_reports', 
				array(__CLASS__, 'dashboard') 
			);
			
			$site_report = add_submenu_page(
				'wpms_admin_reports', 
				__('Site Report'), 
				__('Site Report'), 
				'manage_network', 
				'wpmsar_site_report', 
				array(__CLASS__, 'site_report') 
			);
			
			$user_report = add_submenu_page(
				'wpms_admin_reports', 
				__('User Report'), 
				__('User Report'), 
				'manage_network', 
				'wpmsar_user_report', 
				array(__CLASS__, 'user_report') 
			);
			
			$plugin_report = add_submenu_page(
				'wpms_admin_reports', 
				__('Plugin Report'), 
				__('Plugin Report'), 
				'manage_network', 
				'wpmsar_plugin_report', 
				array(__CLASS__, 'plugin_report') 
			);
			
			add_action("load-" . $menu, array( __CLASS__, 'help_tabs'));
			add_action("load-" . $plugin_report, array( __CLASS__, 'help_tabs'));
			add_action("load-" . $site_report, array( __CLASS__, 'help_tabs'));
			add_action("load-" . $user_report, array( __CLASS__, 'help_tabs'));
			add_action('admin_enqueue_scripts', array( __CLASS__, 'load_common_resources'));
		}
		
		//Callbacks
		public function dashboard() {
			self::__get_controller('dashboard')->load_view();;
		}
		
		public function plugin_report() {
			self::__get_controller('plugin_report')->load_view();
		}
		
		public function site_report() {
			self::__get_controller('site_report')->load_view();
		}
		
		public function user_report() {
			self::__get_controller('user_report')->load_view();
		}
		
		public function help_tabs() {
			self::__get_controller('help_tabs');		     
		}
		
		public function load_common_resources($hook){
			self::__get_helper('resources')->load_scripts($hook);
		}
		
	}
endif;