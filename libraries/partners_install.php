<?php
/**
 * Performs install/uninstall methods for the Partners Plugin
 *
 * @package    Partners
 * @author     Ushahidi Team
 * @copyright  (c) 2008 Ushahidi Team
 * @license    http://www.ushahidi.com/license.html
 */
class Partners_Install {

	/**
	 * Constructor to load the shared database library
	 */
	public function __construct()
	{
		$this->db =  new Database();
	}

	/**
	 * Creates the required database tables for the partners module
	 */
	public function run_install()
	{
		// Add dummy role for ELOG
		$this->db->query("
			INSERT INTO `".Kohana::config('database.default.table_prefix')."roles`
			VALUES
			(2001,'ELOG','ELOG',0);
		");
		// Set ELOG permissions
		$this->db->query("
			INSERT INTO `".Kohana::config('database.default.table_prefix')."permissions_roles`
			VALUES
			(2009,1),
			(2009,2),
			(2009,4),
			(2009,16),
			(2009,17),
			(2009,18)
			;
		");
		
		// Set initial setting for partner roles
		Settings_Model::save_setting('partners_roles', '2009');
	}

	/**
	 * Deletes the database tables for the partners module
	 */
	public function uninstall()
	{

	}
}
