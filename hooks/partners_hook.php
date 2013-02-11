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
			Event::add('ushahidi_action.nav_admin_manage', array($this,'nav_admin_manage'));
		}
		// Only add the events if we are on that controller
		if (stripos(Router::$current_uri, "admin/reports") === 0)
		{
			Event::add('ushahidi_action.nav_admin_reports', array($this, 'nav_admin_reports'));
			Event::add('ushahidi_filter.fetch_incidents_set_params', array($this,'filter_admin_reports'));
		}
		// Only add the events if we are on that controller
		if (stripos(Router::$current_uri, "reports") === 0)
		{
			Event::add('ushahidi_filter.fetch_incidents_set_params', array($this,'filter_reports'));
			if (stripos(Router::$current_uri, "reports/partners") === FALSE)
			{
				Event::add('ushahidi_action.report_filters_ui', array($this, 'report_filter_ui'));
				Event::add('ushahidi_action.report_js_filterReportsAction', array($this, 'report_js_filterReportsAction'));
			}
		}
	}
	
	private function _get_partners()
	{
		$partners_roles = Settings_Model::get_setting('partners_roles');
		$partners_roles = explode(',', $partners_roles);
		$partners = ORM::factory('role')->in('id', $partners_roles)->find_all();
		return $partners;
	}
	
	public function nav_admin_manage()
	{
		$this_sub_page = Event::$data;
		echo ($this_sub_page == "partners") ? "<li><a>".Kohana::lang('partners.partners')."</a></li>" : "<li><a href=\"".url::site()."admin/manage/partners\">".Kohana::lang('partners.partners')."</a></li>";
	}
	
	public function nav_admin_reports()
	{
		$this_sub_page = Event::$data;
		
		$partners = $this->_get_partners();
		foreach($partners as $partner)
		{
			$name = $partner->name;
			$id = $partner->id;
			echo ($this_sub_page == "partner_".$id)
				? "<li class=\"active\"><a>".Kohana::lang('partners.partner_reports', $name)."</a></li>"
				: "<li><a href=\"".url::site()."admin/reports/partner_reports/index/$id\">".Kohana::lang('partners.partner_reports', $name)."</a></li>";
		}
	}
	
	public function filter_admin_reports()
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
				$params[] = " ( i.user_id IN (SELECT user_id from roles_users WHERE role_id = $role_id) "
					. " OR i.id IN (SELECT incident_id FROM message m LEFT JOIN reporter r ON (r.id = m.reporter_id) LEFT JOIN roles_users ru ON (r.user_id = ru.user_id) WHERE role_id = $role_id) )";
			}
		}
		
		// Filter from partner query param
		if (isset($_GET['partner']))
		{
			$role_id = intval($_GET['partner']);
			$params[] = " ( i.user_id IN (SELECT user_id from roles_users WHERE role_id = $role_id) "
					. " OR i.id IN (SELECT incident_id FROM message m LEFT JOIN reporter r ON (r.id = m.reporter_id) LEFT JOIN roles_users ru ON (r.user_id = ru.user_id) WHERE role_id = $role_id) )";
		}
		
		Event::$data = $params;
	}
	
	public function filter_reports()
	{
		$params = Event::$data;
		
		// Filter from partner query param
		if (isset($_GET['partner']))
		{
			// Prepare role_id
			$role_id = $_GET['partner'];
			if (empty($role_id)) $role_id = array(0);
			if (!is_array($role_id)) $role_id = array($role_id);
			$role_id = implode(',',array_map('intval', $role_id));
			
			$params[] = " ( i.user_id IN (SELECT user_id from roles_users WHERE role_id IN ($role_id) ) "
					. " OR i.id IN (SELECT incident_id FROM message m LEFT JOIN reporter r ON (r.id = m.reporter_id) LEFT JOIN roles_users ru ON (r.user_id = ru.user_id) WHERE role_id IN ($role_id) ) )";
			
		}
		
		Event::$data = $params;
	}
	
	public function report_filter_ui()
	{
		$filter = new View('partners_filter_ui');
		
		$filter->partners = $this->_get_partners();
		
		echo $filter;
	}
	
	public function report_js_filterReportsAction()
	{
		View::factory('partners_filter_js')->render(TRUE);
	}
	
}
new partners_hook;

