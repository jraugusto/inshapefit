var GSF_TemplateVc = GSF_TemplateVc || {};
(function ($) {
	"use strict";
	GSF_TemplateVc = {
		init : function(){
			GSF_TemplateVc.VC.init();
		}
	};

	GSF_TemplateVc.VC = {
		init: function() {
			GSF_TemplateVc.VC.tab();
		},
		tab: function() {
			$('.vc_ui-category-box a','#vc-panel-popup-default-template').on('click',function(event) {
				event.preventDefault();
				if ($(this).hasClass('active')) return;
				$('.vc_ui-category-box a','#vc-panel-popup-default-template').removeClass('active');
				$(this).addClass('active');
				var filter = $(this).data('filter');
				$(filter,'#vc_template-default').fadeIn();
				$('.vc_ui-panel-template-item:not('+ filter+')','#vc_template-default').fadeOut();

			});
		}
	};

	$(document).ready(GSF_TemplateVc.init);
})(jQuery);
