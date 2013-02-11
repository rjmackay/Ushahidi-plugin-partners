
				<h3>
					<a href="#" class="small-link-button f-clear reset" onclick="removeParameterKey('partner', 'fl-partners');"><?php echo Kohana::lang('ui_main.clear')?></a>
					<a class="f-title" href="#"><?php echo Kohana::lang('partners.partners');?></a>
				</h3>
				<div class="f-partners-box">
					<p><?php echo Kohana::lang('partners.filter_reports_partners'); ?>&hellip;</p>
					<ul class="filter-list fl-partners">
						<?php foreach ($partners as $partner)
						{ ?>
						<li>
							<a href="#" id="filter_partners_<?php echo $partner->id ?>">
								<span class="item-title"><?php echo $partner->name; ?></span>
							</a>
						</li>
						<? } ?>
					</ul>
				</div>