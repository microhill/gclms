var GCLMS = {};

GCLMS.PopupController = {
    init : function () {
		var allLinks = document.getElementsByTagName("link");
		allLinks[allLinks.length-1].parentNode.removeChild(allLinks[allLinks.length-1]);
		$(document.body).observeRules(GCLMS.Triggers);		
    },
    chooseImage: function () {
		URL = this.getAttribute('href');
		var win = tinyMCEPopup.getWindowArg("window");
		win.document.getElementById(tinyMCEPopup.getWindowArg("input")).value = URL;
		win.document.getElementById('width').value = this.getAttribute('image:width');
		win.document.getElementById('height').value = this.getAttribute('image:height');	
		tinyMCEPopup.close();

		return false;
    },
    chooseLink: function () {
		URL = this.getAttribute('href');
		var win = tinyMCEPopup.getWindowArg("window");
		win.document.getElementById(tinyMCEPopup.getWindowArg("input")).value = URL;
		tinyMCEPopup.close();

		return false;
    }
}

tinyMCEPopup.onInit.add(GCLMS.PopupController.init, GCLMS.PopupController);

GCLMS.Triggers = $H({
	'div.gclms-images a:click': GCLMS.PopupController.chooseImage,
	'div.gclms-files a:click,div.gclms-links a:click': GCLMS.PopupController.chooseLink
});