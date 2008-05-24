GCLMS.UploadFilesController = {
	test: function() {
		alert(1);
	}
}

GCLMS.Triggers.update({});

Event.observe(window,'load',function() {
	//GCLMS.UploadFilesController.test();
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
		upload_cancel_callback : 'uploadCancel',
		auto_upload : true
	});
});

function fileQueued(file, queuelength) {
	var listingfiles = $("SWFUploadFileListingFiles");

	if(!listingfiles.getElementsByTagName("ul")[0]) {
		var ul = document.createElement("ul");
		listingfiles.appendChild(ul);
	}

	listingfiles = listingfiles.getElementsByTagName("ul")[0];

	var li = document.createElement("li");
	li.id = file.id;
	li.className = "SWFUploadFileItem";
	li.innerHTML = "<span class='progressBar' id='" + file.id + "progress'><a id='" + file.id + "deletebtn' class='cancelbtn' href='javascript:swfu.cancelFile(\"" + file.id + "\");'><!-- IE --></a>" + file.name + "</span>";

	listingfiles.appendChild(li);

	$("cancelQueueButton").style.display = "inline";
}

function uploadFileCancelled(file, queuelength) {
	var li = $(file.id);
	li.innerHTML = file.name + " - cancelled";
	li.className = "SWFUploadFileItem uploadCancelled";
}

function uploadFileStart(file, position, queuelength) {
	var li = $(file.id);
	li.className += " fileUploading";
	$("cancelQueueButton").style.display = 'inline';
}

function uploadProgress(file, bytesLoaded) {
	var progress = $(file.id + "progress");
	var percent = Math.ceil((bytesLoaded / file.size) * progress.getWidth());
	progress.style.backgroundPosition = percent + "px 0";
}

function uploadError(errno) {
	SWFUpload.debug(errno);
}

function uploadFileComplete(file) {
	var li = $(file.id);
	li.className = "SWFUploadFileItem uploadCompleted";
}

function cancelQueue() {
	swfu.cancelQueue();
	$(swfu.movieName + "UploadBtn").style.display = "none";
	$("cancelQueueButton").style.display = "none";
}

function uploadQueueComplete(file) {
	$("SWFUploadFileListingFiles").innerHTML = "";
	$("cancelQueueButton").style.display = "none";
	window.location.reload();
}

SWFUpload.prototype.loadUI = function() {
	alert(1);
	
	var instance = this;

	Event.observe('browseButton', 'click', function() { instance.browse(); return false; });
	$('browseButton').style.display = 'inline';
	$('browseButton').id = this.movieName + "BrowseBtn";

	Event.observe('cancelQueueButton', 'click', function() { cancelQueue(); return false; });

	$('loadingSWFTarget').style.display = 'none';

	resizeWrapper();
};
*/