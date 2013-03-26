<?php

/**
 * Deployment Controller
 * 
 * PHP version 5
 * 
 * @category   AMS
 * @package    CI
 * @subpackage Controller
 * @author     Nouman Tayyab <nouman@geekschicago.com>
 * @license    AMS http://ams.avpreserve.com
 * @version    GIT: <$Id>
 * @link       http://ams.avpreserve.com
 */

/**
 * Deployment Class
 *
 * @category   Class
 * @package    CI
 * @subpackage Controller
 * @author     Nouman Tayyab <nouman@geekschicago.com>
 * @license    AMS http://ams.avpreserve.com
 * @link       http://ams.avpreserve.com
 */
class Deployment extends CI_Controller
{

	var $display_error = array();

	function __construct()
	{
		parent::__construct();
		$this->layout = 'deployment.php';
	}

	/**
	 *  After deployment on PRODUCTION check everything works fine.
	 * 
	 * @return 
	 */
	public function check()
	{



		/** Connect & Check status of Sphnix  */
		$data['sphnix'] = $this->sphnix_connect();
		/** Connect & Check status of Memcached  */
		$data['memcached'] = $this->memcached_connect();
		/** Check DB Name and BASE URL */
		$data['values'] = $this->check_values();
		/** Check Error Reporting  */
		$data['reporting'] = $this->check_reporting();
		debug($data);
		$this->load->view('deploy_view', $data);
	}

	/**
	 * Connect and test the sphnix server.
	 * 
	 */
	function sphnix_connect()
	{
		$display['waiting'] = deployment_display("Connecting to Sphnix", '...');
//		sleep(3);
		$sphnix_server = $this->config->item('server');
		$fp = @fsockopen($sphnix_server[0], $sphnix_server[1], $errno, $errstr, $this->config->item('connect_timeout'));
		if ( ! $fp)
		{
			$display['msg'] = deployment_display("$errstr ($errno)");
		}
		else
		{
			$display['msg'] = deployment_display('Sphnix is running.', 'OK');
		}
		return $display;
	}

	/**
	 * Connect and test the memcached server.
	 * 
	 */
	function memcached_connect()
	{
		$display['waiting'] = deployment_display("Connecting to Memcached", '...');
//		sleep(3);
		$this->config->load('memcached');
		$memcached_server = $this->config->item('memcached');

		$fp = @fsockopen($memcached_server['servers']['default']['host'], $memcached_server['servers']['default']['port'], $errno, $errstr, 300);
		if ( ! $fp)
		{
			$display['msg'] = deployment_display("$errstr ($errno)");
		}
		else
		{
			$display['msg'] = deployment_display('Memcached is running.', 'OK');
		}
		return $display;
	}

	/**
	 * Check DB names
	 * 
	 */
	function check_values()
	{
		$display['waiting'] = deployment_display("Checking Server values", '...');
//		sleep(3);
		if (ENVIRONMENT === 'production')
		{
			if ($this->db->database === 'ams_live')
				$display['db_name'] = deployment_display('Database name is correct.', 'OK');
			else
				$display['db_name'] = deployment_display('Database name is incorrect.');
			if ($this->config->item('base_url') === 'http://ams.avpreserve.com/')
				$display['url'] = deployment_display('Base URL is correct.', 'OK');
			else
				$display['url'] = deployment_display('Base URL is incorrect.');
		}
		else if (ENVIRONMENT === 'qatesting')
		{
			if ($this->db->database === 'ams_qa')
				$display['db_name'] = deployment_display('Database name is correct.', 'OK');
			else
				$display['db_name'] = deployment_display('Database name is incorrect.');
			if ($this->config->item('base_url') === 'http://amsqa.avpreserve.com/')
				$display['url'] = deployment_display('Base URL is correct.', 'OK');
			else
				$display['url'] = deployment_display('Base URL is incorrect.');
		}
		return $display;
	}

	/**
	 * Check the error reporting status.
	 * 
	 */
	function check_reporting()
	{
		$display['waiting'] = deployment_display("Checking Error Reporting", '...');
//		sleep(3);
		if (ini_get('display_errors') == 0)
			$display['errors'] = deployment_display('Display Errors. ', 'OFF');
		else
			$display['errors'] = deployment_display('Display Errors. ', 'ON');
		if (ini_get('error_reporting') == 0)
			$display['reporting'] = deployment_display('Display Reporting. ', 'OFF');
		else
			$display['reporting'] = deployment_display('Display Reporting. ', ini_get('error_reporting'));
		return $display;
	}

}

// END Deployment Controller

// End of file deployment.php 
/* Location: ./application/controllers/deployment.php */