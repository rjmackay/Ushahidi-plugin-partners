<?php 
/**
 * Sharing view page.
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com> 
 * @package    Ushahidi - http://source.ushahididev.com
 * @module     Sharing view
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */
?>
<div id="tools-content">
   	<div class="pageheader">
		<h1 class="pagetitle"><?php echo Kohana::lang('uchaguzi.tools'); ?></h1>

		<nav id="tools-menu">
			<ul class="second-level-menu">
				<?php admin::manage_subtabs("sharing"); ?>
			</ul>
		</nav>
	</div>
	
	<div class="page-content cf">
				<?php
				if ($form_error) {
				?>
					<!-- red-box -->
					<div class="red-box">
						<h3><?php echo Kohana::lang('ui_main.error');?></h3>
						<ul>
						<?php
						foreach ($errors as $error_item => $error_description)
						{
							// print "<li>" . $error_description . "</li>";
							print (!$error_description) ? '' : "<li>" . $error_description . "</li>";
						}
						?>
						</ul>
					</div>
				<?php
				}

				if ($form_saved) {
				?>
					<!-- green-box -->
					<div class="green-box">
						<h3><?php echo $form_action; ?>!</h3>
					</div>
				<?php
				}
				?>
				
				
				<!-- report-table -->
				<div class="table-tabs">
				<h3></h3>
					<?php print form::open(NULL,array('id' => 'sharingListing', 'name' => 'sharingListing')); ?>
						<div class="table-holder">
							<table class="table">
								<thead>
									<tr>
										<th class="col-1" colspan="2"><?php echo Kohana::lang('partners.select_partners'); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php
									if ($total_items == 0)
									{
									?>
										<tr>
											<td colspan="2" class="col">
												<h3><?php echo Kohana::lang('ui_main.no_results');?></h3>
											</td>
										</tr>
									<?php	
									}
									foreach ($roles as $role)
									{
										?>
										<tr>
											<td class="col-1" style="width: 30px;"><input name="role_id[]" type="checkbox" value="<?php echo $role->id; ?>" <?php echo in_array($role->id, $form['role_id']) ? ' checked="checked"': ''; ?>></td>
											<td class="col-2"><?php echo $role->name; ?>
											</td>
										</tr>
										<?php
									}
									?>
								</tbody>
							</table>
						</div>
						<input type="submit" name="submit" value="Save" />
					<?php print form::close(); ?>
				</div>
			</div>
