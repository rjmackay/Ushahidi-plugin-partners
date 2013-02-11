			// 
			// Get the sharing site
			// 
			var partners = [];
			$.each($(".fl-partners li a.selected"), function(i, item){
				partnerId = item.id.substring("filter_partners_".length);
				partners.push(partnerId);
			});
			
			if (partners.length > 0)
			{
				urlParameters["partner"] = partners;
			}