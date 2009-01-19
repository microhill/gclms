gclms.UploadFilesController = {
	loadPage: function() {		
		var swfu;

		var settings = {
			flash_url : "http://ibsdev.s3.amazonaws.com/swfupload.swf",
			upload_url: "/",	// Relative to the SWF file
			//post_params: {"PHPSESSID" : ''},
			file_post_name: 'file',
			file_size_limit : "100 MB",
			file_types : "*.*",
			file_types_description : "All Files",
			file_upload_limit : 100,
			file_queue_limit : 0,
			debug: false,

			// Button settings
			button_image_url: "/img/icons/oxygen_refit/48x48/actions/go-up-blue.png",	// Relative to the Flash file
			button_width: "200",
			button_height: "48",
			button_placeholder_id: 'spanButtonPlaceHolder',
			button_window_mode : SWFUpload.WINDOW_MODE.TRANSPARENT,
			button_cursor : SWFUpload.CURSOR.HAND,			
			button_text: '<span class="upload">Upload</span>',
			button_text_style: ".upload { font-size: 24px;font-family:Verdana,Arial; }",
			button_text_left_padding: 52,
			button_text_top_padding: 6,
			
			// The event handler functions are defined in handlers.js

			file_queued_handler : gclms.UploadFilesController.fileQueued,
			file_queue_error_handler : gclms.UploadFilesController.fileQueueError,
			file_dialog_complete_handler : gclms.UploadFilesController.fileDialogComplete,
			upload_start_handler : gclms.UploadFilesController.uploadStart,
			upload_progress_handler : gclms.UploadFilesController.uploadProgress,
			upload_error_handler : gclms.UploadFilesController.uploadError,
			upload_success_handler : gclms.UploadFilesController.uploadSuccess,
			upload_complete_handler : gclms.UploadFilesController.uploadComplete,
			queue_complete_handler : gclms.UploadFilesController.queueComplete,	// Queue plugin event
			
			post_params: {
				key: $F('s3key'),
				AWSAccessKeyId: $F('s3awsaccesskeyid'),
				acl: $F('s3acl'),
				policy: $F('s3policy'),
				signature: $F('s3signature'),
				'Content-Type': $F('s3contenttype'),
				//success_action_redirect: $F('s3successactionredirect'),
				success_action_status: $F('s3successactionstatus')
			}
		};
		swfu = new SWFUpload(settings);
	},
	
	fileQueued: function() {
		
	},
	
	fileQueueError: function() {
		alert('fileQueueError');
	},
	
	fileDialogComplete: function(numFilesSelected, numFilesQueued) {
		try {
			if (numFilesSelected > 0) {
				//document.getElementById(this.customSettings.cancelButtonId).disabled = false;
			}
			
			/* I want auto start the upload and I can do that here */
			this.startUpload();
		} catch (ex)  {
	        this.debug(ex);
		}
	},
	
	uploadStart: function(file) {
		var extension = file.type.split('.')[1];
		if(gclms.mime_types[extension]) {
			this.addFileParam(file.id,'Content-Type',gclms.mime_types[extension])
		}

		$('gclms-files').down('tbody').insert({bottom: gclms.Views.get('file').interpolate({
			name: file.name,
			size: file.size
		})});
		return true;
	},
	
	uploadProgress: function() {
		
	},
	
	uploadError: function(file, errorCode, message) {
		alert('uploadError');
	},
	
	uploadSuccess: function(file, serverData) {
		//$('divServerData').replace(serverData.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/\t/g, "    ").replace(/  /g, " &nbsp;"));
		window.location.reload();
	},
	
	uploadComplete: function() {
		if(this.getStats().files_queued) {
			this.startUpload();
		}
	},
	
	queueComplete: function() {
		alert('queueComplete');
	},
	
	selectAll: function () {
		if(this.checked) {
			$$('input.gclms-file-select').each(function(input) { //:not(:checked)
				input.checked = true;
				input.up('tr').addClassName('gclms-selected');
			});		
		} else {
			$$('input.gclms-file-select:checked').each(function(input) {
				input.checked = false;				
				input.up('tr').removeClassName('gclms-selected');
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
		gclms.UploadFilesController.updateSelectAllCheckbox();
		gclms.UploadFilesController.updateFileRowClass.bind(this)();
	},
	
	updateFileRowClass: function(event){
		if (this.checked) {
			this.up('tr').addClassName('gclms-selected');
		}
		else {
			this.up('tr').removeClassName('gclms-selected');
		}
	},
	
	confirmDeleteFiles: function(event) {
		event.stop();
		var popup = new gclms.confirm({
			text: 'Are you sure?',
			callback: gclms.UploadFilesController.deleteFiles.bind(this)
		});
	},
	
	deleteFiles: function() {
		var form = this.up('form');
		form.setAttribute('action',form.getAttribute('action') + 'delete')
		form.submit();
	}
};

gclms.File = {
	ajaxUrl: '/' + document.body.getAttribute('gclms-group') + '/' + document.body.getAttribute('gclms-course') + '/files/',
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

gclms.Views.update({
	file: '<tr class="gclms-file"><td><input type="checkbox" class="gclms-file-select" disabled="disabled"/></td><td>#{name}</td><td style="white-space: nowrap;">#{size}</td></tr>'
});

gclms.Triggers.update({
	'#gclms-select-all:loaded': gclms.UploadFilesController.loadPage,
	'.gclms-delete-files:click': gclms.UploadFilesController.confirmDeleteFiles,
	'#gclms-select-all:change': gclms.UploadFilesController.selectAll,
	'input.gclms-file-select': {
		':loaded': gclms.UploadFilesController.updateFileRowClass,
		//':click': gclms.UploadFilesController.updateFileSelection,
		':change': gclms.UploadFilesController.updateFileSelection
	},

	/*
	'#SWFUploadFileListingFiles': gclms.UploadFilesController.loadSwfObject,
	'#gclms-upload-files:click': gclms.UploadFilesController.selectFiles,
	'#gclms-cancel-queue-button:click': gclms.UploadFilesController.cancelUpload,


	*/
	//'#gclms-files tr.gclms-file:click': gclms.UploadFilesController.selectRow,

	'li': {
		'span.gclms-progress-bar a:click': gclms.UploadFilesController.cancelFile		
	}
	/*
	'input[type="file"]:change': function() {
		if($F(this).empty()) {
			var mime_type = 'application/octet-stream';
			return false;			
		} else {
			var parts = $F(this).split('.');
			var mime_type = gclms.mime_types[parts[parts.length - 1]];
			if(mime_type == undefined) {
				mime_type = 'application/octet-stream';
			}			
		}
		
		//$$('.gclms-content form input[name="Content-Type"]').first().setAttribute('value',mime_type);
	}
	*/
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

/*

	loadSwfObject: function() {
		if(swfobject.getFlashPlayerVersion().major < 9) {
			$$('.gclms-upgrade-flash').first().removeClassName('gclms-hidden');
			return false;
		}

		gclms.swfu = new SWFUpload({
			upload_url : $$('.gclms-content form').first().getAttribute('action'),
			flash_url: 'http://test2008-07-30.s3.amazonaws.com/swfupload_f9.swf',
			file_size_limit: '30 MB',
			file_post_name: 'file',
			post_params: {
				'key': $$('.gclms-content form input[name="key"]').first().getValue(),
				'AWSAccessKeyId': $$('.gclms-content form input[name="AWSAccessKeyId"]').first().getValue(),
				'policy': $$('.gclms-content form input[name="policy"]').first().getValue(),
				'signature': $$('.gclms-content form input[name="signature"]').first().getValue()
			},
			file_queued_handler: gclms.UploadFilesController.fileQueued,
			upload_complete_handler: gclms.UploadFilesController.uploadFileComplete,
			file_dialog_complete_handler: gclms.UploadFilesController.startUpload,
			upload_complete_handler: gclms.UploadFilesController.uploadComplete,
			upload_progress_handler: gclms.UploadFilesController.uploadProgress,
			swfupload_loaded_handler: gclms.UploadFilesController.showAddButton
		});		
	},
	
	showAddButton: function() {
		//$('gclms-upload-files').displayAsInline();
	},
	
	selectFiles: function() {
		gclms.swfu.selectFiles();
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
		li.observeRules(gclms.Triggers.get('li'));
		
		$("gclms-cancel-queue-button").style.display = "inline";
	},
	
	cancelFile: function() {
		var fileId = this.getAttribute('gclms:file-id');
		gclms.swfu.cancelUpload(fileId);
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
			//window.location.reload();
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
			gclms.swfu.stopUpload();			
		});
		$('gclms-cancel-queue-button').hide();
	},
		
	deleteFiles: function () {
		var files = [];
		$$('input.gclms-file-select:checked').each(function(input){
			files.push(input.value);
		});
		this.up('form').submit();
		return false;
		gclms.File.remove({
			files: files.join(),
			callback: function(transport) {
				var files = transport.responseText.evalJSON();
				files.each(function(file){
					$$('td > input[value="' + file + '"]').first().up('tr').remove();
				});
				gclms.UploadFilesController.updateSelectAllCheckbox();
			}
		});	
	}
	
*/