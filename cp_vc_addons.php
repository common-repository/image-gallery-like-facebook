<?php
    /*
    Plugin Name: Image Gallery Like Facebook
    Description: Image Gallery Like Facebook for WPBakery Page Builder (formerly Visual Composer)
    Author: Cristian IOSUB
    Version: 1.0
    Author URI: https://www.cristianiosub.com
    */
	class imagegallery_VC_Addons{
		var $paths = array();
		var $module_dir;
		var $params_dir;
		var $assets_js;
		var $assets_css;
		var $admin_js;
		var $admin_css;
		var $vc_template_dir;
		var $vc_dest_dir;
		function __construct()
		{
			$this->module_dir = plugin_dir_path( __FILE__ ).'modules/';
			add_action( 'admin_menu', array($this,'register_imagegallery_addons_menu'));
			add_action('after_setup_theme',array($this,'aio_init'));
		}
		function register_imagegallery_addons_menu(){
			if(!current_user_can( 'manage_options' ))
				return false;
			global $submenu;
		}
		function aio_init(){
			$ultimate_modules = get_option('ultimate_modules');
			$ultimate_modules[] = 'fb_gallery';
			if(get_option('ultimate_row') == "enable")
				$ultimate_modules[] = 'ultimate_parallax';
			foreach(glob($this->module_dir."/*.php") as $module)
			{
				$ultimate_file = basename($module);
				$ultimate_fileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $ultimate_file);
				if(is_array($ultimate_modules) && !empty($ultimate_modules)){ 
					if(in_array(strtolower($ultimate_fileName),$ultimate_modules) ){
						require_once($module);
					}
				}
			}
		}
	}
	new imagegallery_VC_Addons;