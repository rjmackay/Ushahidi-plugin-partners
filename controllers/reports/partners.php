<?php defined('SYSPATH') or die('No direct script access.');

class Partners_Controller extends Tools_Controller
{
	
	public $auto_render = FALSE;
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index($partner)
	{
		$this->template->this_page = 'reports';
		
		// Push partner id into the URL params
		$_GET['partner'] = $partner;
		
		// ugly hack to reuse admin/reports controller
		require_once(APPPATH.'controllers/reports.php');
		$report_controller = new Reports_Controller;
		$report_controller->index();
		$report_controller->template->content->this_sub_page = 'partner_'.$partner;
		
		// Kohana handles auto rendering the reports controller - no action needed
	}
}