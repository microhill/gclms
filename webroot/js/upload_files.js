GCLMS.UploadFilesController = {
	loadSwfObject: function() {
			if(swfobject.getFlashPlayerVersion().major < 9) {
				$$('.gclms-upgrade-flash').first().removeClassName('gclms-hidden');
				return false;
			}

		GCLMS.swfu = new SWFUpload({
			upload_url : $('SWFUploadTarget').getAttribute('swfupload:uploadScript'),
			flash_url: '/js/vendors/swfupload2.1.0/swfupload_f9.swf',
			file_queued_handler: GCLMS.UploadFilesController.fileQueued,
			upload_complete_handler: GCLMS.UploadFilesController.uploadFileComplete,
			file_dialog_complete_handler: GCLMS.UploadFilesController.startUpload,
			upload_complete_handler: GCLMS.UploadFilesController.uploadComplete,
			upload_progress_handler: GCLMS.UploadFilesController.uploadProgress,
			swfupload_loaded_handler: GCLMS.UploadFilesController.showAddButton
		});		
	},
	
	showAddButton: function() {
		//$('gclms-upload-files').displayAsInline();
	},
	
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
		
		$("gclms-cancel-queue-button").style.display = "inline";
	},
	
	cancelFile: function() {
		var fileId = this.getAttribute('gclms:file-id');
		GCLMS.swfu.cancelUpload(fileId);
		var li = this.up('li');
		li.insert({bottom: ' - cancelled'})
		li.className = "SWFUploadFileItem uploadCancelled";
	},

	startUpload: function() { // This looks weird, I know...
		if ($$('#SWFUploadFileListingFiles li.gclms-queued').length) {
			$('gclms-cancel-queue-button').displayAsInline();
			this.startUpload();
		}
	},
	
	uploadComplete: function(file) {
		var li = $(file.id);
		li.className = 'SWFUploadFileItem gclms-upload-completed';
		
		if ($$('#SWFUploadFileListingFiles li.gclms-queued').length) {
			this.startUpload();
		} else {
			$('SWFUploadFileListingFiles').innerHTML = '';
			$("gclms-cancel-queue-button").hide();
			window.location.reload();
		} 
	},
	
	uploadProgress: function(file, bytesLoaded) {
		var progress = $(file.id + "progress");
		var percent = Math.ceil((bytesLoaded / file.size) * progress.getWidth());
		progress.style.backgroundPosition = percent + "px 0";
	},
	
	cancelUpload: function () {
		$$('#SWFUploadFileListingFiles li.gclms-queued').each(function(li){
			li.className = "SWFUploadFileItem uploadCancelled";
			GCLMS.swfu.stopUpload();			
		});
		$('gclms-cancel-queue-button').hide();
	},
	
	confirmDeleteFiles: function(event) {
		event.stop();
		GCLMS.popup.create({
			text: 'Are you sure?',
			confirmButtonText: __('Yes'),
			cancelButtonText: __('No'),
			type: 'confirm',
			callback: GCLMS.UploadFilesController.deleteFiles
		});
	},
	
	deleteFiles: function () {
		var files = [];
		$$('input.gclms-file-select:checked').each(function(input){
			files.push(input.value);
		});
		GCLMS.File.remove({
			files: files.join(),
			callback: function(transport) {
				var files = transport.responseText.evalJSON();
				files.each(function(file){
					$$('td > input[value="' + file + '"]').first().up('tr').remove();
				});
				GCLMS.UploadFilesController.updateSelectAllCheckbox();
			}
		});	
	},
	
	selectAll: function () {
		if(this.checked) {
			$$('input.gclms-file-select:not(:checked)').each(function(input) {
				input.checked = true;
				GCLMS.UploadFilesController.updateFileRowClass.bind(input)();
			});		
		} else {
			$$('input.gclms-file-select:checked').each(function(input) {
				input.checked = false;				
				GCLMS.UploadFilesController.updateFileRowClass.bind(input)();
			});		
		}

	},
	
	updateSelectAllCheckbox: function () {
		if(!$$('input.gclms-file-select').length) {
			$('gclms-files').hide();
			$('gclms-select-all').checked = false;
		} else if ($$('input.gclms-file-select:not(:checked)').length) {
			$('gclms-select-all').checked = false;
		} else {
			$('gclms-select-all').checked = true;			
		}
	},
	
	updateFileSelection: function(event) {
		GCLMS.UploadFilesController.updateSelectAllCheckbox();
		GCLMS.UploadFilesController.updateFileRowClass.bind(this)();
	},
	
	updateFileRowClass: function(event) {
		if(this.checked) {
			this.up('tr').addClassName('gclms-selected');
		} else {
			this.up('tr').removeClassName('gclms-selected');			
		}
	}
};

GCLMS.File = {
	ajaxUrl: '/' + document.body.getAttribute('gclms:group') + '/' + document.body.getAttribute('gclms:course') + '/files/',
	remove: function(options){
		var request = new Ajax.Request(this.ajaxUrl + 'delete', {
			method: 'post',
			parameters: {
				'data[files]': options.files
			},
			onComplete: options.callback
		});
	}
};

GCLMS.Triggers.update({
	'#SWFUploadFileListingFiles': GCLMS.UploadFilesController.loadSwfObject,
	'#gclms-upload-files:click': GCLMS.UploadFilesController.selectFiles,
	'#gclms-cancel-queue-button:click': GCLMS.UploadFilesController.cancelUpload,
	'#gclms-delete:click': GCLMS.UploadFilesController.confirmDeleteFiles,
	'#gclms-select-all:change': GCLMS.UploadFilesController.selectAll,
	'input.gclms-file-select': {
		':loaded': GCLMS.UploadFilesController.updateFileRowClass,
		//':click': GCLMS.UploadFilesController.updateFileSelection,
		':change': GCLMS.UploadFilesController.updateFileSelection
	},
	//'#gclms-files tr.gclms-file:click': GCLMS.UploadFilesController.selectRow,
	'li': {
		'span.gclms-progress-bar a:click': GCLMS.UploadFilesController.cancelFile		
	}
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
	$("gclms-cancel-queue-button").style.display = 'inline';
}

SWFUpload.prototype.loadUI = function() {
	alert(1);
	
	var instance = this;

	Event.observe('browseButton', 'click', function() { instance.browse(); return false; });
	$('browseButton').style.display = 'inline';
	$('browseButton').id = this.movieName + "BrowseBtn";

	Event.observe('gclms-cancel-queue-button', 'click', function() { cancelQueue(); return false; });

	resizeWrapper();
};
*/