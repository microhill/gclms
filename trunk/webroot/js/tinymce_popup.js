var FileBrowserDialogue = {
    init : function () {
		var allLinks = document.getElementsByTagName("link");
		allLinks[allLinks.length-1].parentNode.removeChild(allLinks[allLinks.length-1]);
    },
    chooseImage: function (obj) {
		URL = obj.getAttribute('href');
		var win = tinyMCEPopup.getWindowArg("window");
		win.document.getElementById(tinyMCEPopup.getWindowArg("input")).value = URL;
		win.document.getElementById('width').value = obj.getAttribute('image:width');
		win.document.getElementById('height').value = obj.getAttribute('image:height');		
		if (win.getImageData) win.getImageData();
		tinyMCEPopup.close();

		return false;
    },
    chooseMediaFile: function (obj) {
		URL = obj.getAttribute('href');
		var win = tinyMCEPopup.getWindowArg("window");
		win.document.getElementById(tinyMCEPopup.getWindowArg("input")).value = URL;
		if (win.getImageData) win.getImageData();
		tinyMCEPopup.close();

		return false;
    }
}

tinyMCEPopup.onInit.add(FileBrowserDialogue.init, FileBrowserDialogue);