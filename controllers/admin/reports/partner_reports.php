<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Partner Reports Controller.
 * This controller handles partner reports admin
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author	   Ushahidi Team <team@ushahidi.com>
 * @package	   Partners
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license	   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */
 
class Partner_Reports_Controller extends Tools_Controller
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
		require_once(APPPATH.'controllers/admin/reports.php');
		$report_controller = new Reports_Controller;
		$report_controller->index();
		$report_controller->template->content->this_sub_page = 'partner_'.$partner;
		
		// Kohana handles auto rendering the reports controller - no action needed
	}
}