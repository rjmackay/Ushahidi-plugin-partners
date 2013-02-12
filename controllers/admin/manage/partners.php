<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Partners Controller.
 * This controller manages selecting roles to treat as partners
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
 
class Partners_Controller extends Tools_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$this->template->this_page = 'partners';
		$form_saved = FALSE;
		$form_error = FALSE;
		
		if ($_POST)
		{
			$this->_post();
		}
		
		// Standard Settings View
		$this->template->content = new View("admin/manage/partners");
		$this->template->content->title = "Partners Settings";
		$this->template->content->roles = ORM::factory('role')->notin('name', array('login','admin','superadmin','member'))->find_all();
		$this->template->content->total_items = count($this->template->content->roles);
		
		$partners_roles = Settings_Model::get_setting('partners_roles');
		$partners_roles = explode(',', $partners_roles);
		
		$form = array(
			'role_id' => $partners_roles,
		);
		
		$this->template->content->form = $form;
		$this->template->content->form_error = $form_error;
		$this->template->content->form_saved = $form_saved;
	}

	private function _post()
	{
		$post = new Validation($_POST);
		$post->pre_filter('trim');
		
		if ($post->validate(FALSE))
		{
			// Prepare role_id
			if (!isset($post->role_id)) $post->role_id = array();
			if (!is_array($post->role_id)) $post->role_id = array($post->role_id);
			$post->role_id = array_map('intval', $post->role_id);
			// Save role_id as comma separated list
			Settings_Model::save_setting('partners_roles', implode(',',$post->role_id));
		}
	}
}
