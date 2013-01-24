<?php defined('SYSPATH') or die('No direct script access.');

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
