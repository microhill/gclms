GCLMS.UploadFilesController = {
	selectFiles: function() {
		GCLMS.swfu.selectFiles();
	},
	
	fileQueued: function (file, queuelength) {
		var listingfiles = $('SWFUploadFileListingFiles');
		
		if(!listingfiles.getElementsByTagName("ul")[0]) {
			var ul = document.createElement("ul");
			listingfiles.appendChild(ul);
		}
		
		listingfiles = listingfiles.getElementsByTagName("ul")[0];
		
		var li = document.createElement("li");
		li.id = file.id;
		li.className = "SWFUploadFileItem gclms-queued";
		li.innerHTML = "<span class='gclms-progress-bar' id='" + file.id + "progress'><a id='" + file.id + "deletebtn' class='cancelbtn' gclms:file-id='" + file.id + "'><!-- IE --></a>" + file.name + "</span>";
		
		li = listingfiles.appendChild(li);
		li.observeRules(GCLMS.Triggers.get('li'));
		
		$("cancelQueueButton").style.display = "inline";
	},
	
	cancelFile: function() {
		var fileId = this.getAttribute('gclms:file-id');
		GCLMS.swfu.cancelUpload(fileId);
		var li = this.up('li');
		li.insert({bottom: ' - cancelled'})
		li.className = "SWFUploadFileItem uploadCancelled";
	},

	startUpload: function() {
		this.startUpload();
	},
	
	uploadComplete: function(file) {
		var li = $(file.id);
		li.className = "SWFUploadFileItem gclms-upload-completed";
		
		if ($$('#SWFUploadFileListingFiles li.gclms-queued').length) {
			this.startUpload();
		} else {
			$("SWFUploadFileListingFiles").innerHTML = '';
			$("cancelQueueButton").hide();
			window.location.reload();
		} 
	},
	
	uploadProgress: function(file, bytesLoaded) {
		var progress = $(file.id + "progress");
		var percent = Math.ceil((bytesLoaded / file.size) * progress.getWidth());
		progress.style.backgroundPosition = percent + "px 0";
	}
}

GCLMS.Triggers.update({
	'#browseButton:click': GCLMS.UploadFilesController.selectFiles,
	'li': {
		'span.gclms-progress-bar a:click': GCLMS.UploadFilesController.cancelFile		
	}
});

if(swfobject.getFlashPlayerVersion().major < 9) {
	$$('.gclms-upgrade-flash').first().removeClassName('gclms-hidden');
}

Event.observe(window,'load',function() {	
	var settings = {
		upload_url : $('SWFUploadTarget').getAttribute('swfupload:uploadScript'),
		flash_url: '/js/vendors/swfupload2.1.0/swfupload_f9.swf',
		file_queued_handler: GCLMS.UploadFilesController.fileQueued,
		upload_complete_handler: GCLMS.UploadFilesController.uploadFileComplete,
		file_dialog_complete_handler: GCLMS.UploadFilesController.startUpload,
		upload_complete_handler: GCLMS.UploadFilesController.uploadComplete,
		upload_progress_handler: GCLMS.UploadFilesController.uploadProgress
	};
	
	GCLMS.swfu = new SWFUpload(settings);
});

/*
var swfu;

Event.observe(window,'load',function() {
	swfu = new SWFUpload({
		upload_script : $('SWFUploadTarget').getAttribute('swfupload:uploadScript'),
		target : "SWFUploadTarget",
		flash_path : "/js/vendors/swfupload/SWFUpload.swf",
		allowed_filesize : 16720,	// 30 MB
		allowed_filetypes : "*.*",
		allowed_filetypes_description : "All files...",
		browse_link_innerhtml : "Browse",
		upload_link_innerhtml : "Upload queue",
		browse_link_class : "uploadBrowseButton",
		upload_link_class : "swfuploadbtn uploadbtn",
		flash_loaded_callback : 'swfu.flashLoaded',
		upload_file_queued_callback : "fileQueued",
		upload_file_start_callback : 'uploadFileStart',
		upload_progress_callback : 'uploadProgress',
		upload_file_complete_callback : 'uploadFileComplete',
		upload_file_cancel_callback : 'uploadFileCancelled',
		upload_queue_complete_callback : 'uploadQueueComplete',
		upload_error_callback : 'uploadError',
		upload_cancel_callback : 'uploadCancel'
	});
});

function uploadFileStart(file, position, queuelength) {
	var li = $(file.id);
	$("cancelQueueButton").style.display = 'inline';
}

function cancelQueue() {
	swfu.cancelQueue();
	$(swfu.movieName + "UploadBtn").style.display = "none";
	$("cancelQueueButton").style.display = "none";
}

SWFUpload.prototype.loadUI = function() {
	alert(1);
	
	var instance = this;

	Event.observe('browseButton', 'click', function() { instance.browse(); return false; });
	$('browseButton').style.display = 'inline';
	$('browseButton').id = this.movieName + "BrowseBtn";

	Event.observe('cancelQueueButton', 'click', function() { cancelQueue(); return false; });

	resizeWrapper();
};
*/