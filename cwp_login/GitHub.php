<?php
/**
 * @Author: suifengtec
 * @Date:   2017-01-22 03:54:45
 * @Last Modified by:   suifengtec
 * @Last Modified time: 2017-01-22 03:57:59
 */
namespace cwp_login;

class CWP_Login_Service_GitHub{

	private $app_id = '';
	private $app_key = '';

	public function __construct(){

		$this->app_id = get_option('cwp_login_social_gh_app_id');
		$this->app_key = get_option('cwp_login_social_gh_app_key');
	}



	public static function get_auth_url(){

		
	}

}

