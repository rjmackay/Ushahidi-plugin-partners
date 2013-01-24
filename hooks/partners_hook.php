<?php defined('SYSPATH') or die('No direct script access.');

class partners_hook {
	public function __construct()
	{
		$this->auth = Auth::instance();
		$this->db = Database::instance();
		// Hook into routing
		Event::add('system.pre_controller', array($this, 'add'));
	}
	
	public function add()
	{
		// Only add the events if we are on that controller
		if (stripos(Router::$current_uri, "admin/manage") === 0)
		{
			Event::add('ushahidi_action.nav_admin_manage', array($this,'_nav_admin_manage'));
		}
		// Only add the events if we are on that controller
		if (stripos(Router::$current_uri, "admin/reports") === 0)
		{
			Event::add('ushahidi_filter.fetch_incidents_set_params', array($this,'_fetch_incidents_set_params'));
		}
	}
	
	public function _nav_admin_manage()
	{
		$this_sub_page = Event::$data;
		echo ($this_sub_page == "partners") ? "<li><a>Partners</a></li>" : "<li><a href=\"".url::site()."admin/manage/partners\">Partners</a></li>";
	}
	
	public function _fetch_incidents_set_params()
	{
		$params = Event::$data;
		
		// Filter by current users partner role
		if ($this->auth->logged_in())
		{
			$user = $this->auth->get_user();
			
			$partners_roles = Settings_Model::get_setting('partners_roles');
			$partners_roles = explode(',', $partners_roles);
			$partners_roles = array_map('intval', $partners_roles);
			
			$users_roles = $this->db->query('SELECT * FROM roles_users WHERE role_id IN ('.implode(',',$partners_roles).') AND user_id = ?', $user->id);
			
			// if user has partner role then filter to just their reports
			if(count($users_roles))
			{
				$user_role = $users_roles->current();
				$role_id = intval($user_role->role_id);
				$params[] = "user_id IN (SELECT user_id from roles_users WHERE role_id = $role_id) ";
			}
		}
		
		// Filter from partner query param
		if (isset($_GET['partner']))
		{
			$role_id = intval($_GET['partner']);
			$params[] = "user_id IN (SELECT user_id from roles_users WHERE role_id = $role_id) ";
		}
		
		Event::$data = $params;
	}
	
}
new partners_hook;

