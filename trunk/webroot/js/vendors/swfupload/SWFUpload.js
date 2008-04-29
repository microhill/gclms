function SWFUpload(settings){
    try {
        document.execCommand('BackgroundImageCache', false, true);
    } 
    catch (e) {
    }
    this.movieName = "SWFUpload_" + SWFUpload.movieCount++;
    this.init(settings);
    this.loadFlash();
    if (this.debug) 
        this.debugSettings();
}

SWFUpload.movieCount = 0;
SWFUpload.handleErrors = function(errcode, file, msg){
    switch (errcode) {
        case -10:
            alert("Error Code: HTTP Error, File name: " + file.name + ", Message: " + msg);
            break;
        case -20:
            alert("Error Code: No upload script, File name: " + file.name + ", Message: " + msg);
            break;
        case -30:
            alert("Error Code: IO Error, File name: " + file.name + ", Message: " + msg);
            break;
        case -40:
            alert("Error Code: Security Error, File name: " + file.name + ", Message: " + msg);
            break;
        case -50:
            alert("Error Code: Filesize exceeds limit, File name: " + file.name + ", File size: " + file.size + ", Message: " + msg);
            break;
    }
};
SWFUpload.prototype.init = function(settings){
    this.settings = [];
    this.addSetting("debug", settings["debug"], false);
    this.addSetting("target", settings["target"], "");
    this.addSetting("create_ui", settings["create_ui"], false);
    this.addSetting("browse_link_class", settings["browse_link_class"], "SWFBrowseLink");
    this.addSetting("upload_link_class", settings["upload_link_class"], "SWFUploadLink");
    this.addSetting("browse_link_innerhtml", settings["browse_link_innerhtml"], "<span>Browse...</span>");
    this.addSetting("upload_link_innerhtml", settings["upload_link_innerhtml"], "<span>Upload</span>");
    this.addSetting("flash_loaded_callback", settings["flash_loaded_callback"], "SWFUpload.flashLoaded");
    this.addSetting("upload_file_queued_callback", settings["upload_file_queued_callback"], "");
    this.addSetting("upload_file_start_callback", settings["upload_file_start_callback"], "");
    this.addSetting("upload_file_complete_callback", settings["upload_file_complete_callback"], "");
    this.addSetting("upload_queue_complete_callback", settings["upload_queue_complete_callback"], "");
    this.addSetting("upload_progress_callback", settings["upload_progress_callback"], "");
    this.addSetting("upload_dialog_cancel_callback", settings["upload_dialog_cancel_callback"], "");
    this.addSetting("upload_file_error_callback", settings["upload_file_error_callback"], "SWFUpload.handleErrors");
    this.addSetting("upload_file_cancel_callback", settings["upload_file_cancel_callback"], "");
    this.addSetting("upload_queue_cancel_callback", settings["upload_queue_cancel_callback"], "");
	this.addSetting("upload_script", settings["upload_script"], ""); //escape()
    this.addSetting("auto_upload", settings["auto_upload"], false);
    this.addSetting("allowed_filetypes", settings["allowed_filetypes"], "*.*");
    this.addSetting("allowed_filetypes_description", settings["allowed_filetypes_description"], "All files");
    this.addSetting("allowed_filesize", settings["allowed_filesize"], 1024);
    this.addSetting("flash_path", settings["flash_path"], "jscripts/SWFUpload/SWFUpload.swf");
    this.addSetting("flash_target", settings["flash_target"], "");
    this.addSetting("flash_width", settings["flash_width"], "1px");
    this.addSetting("flash_height", settings["flash_height"], "1px");
    this.addSetting("flash_color", settings["flash_color"], "#000000");
    this.debug = this.getSetting("debug");
};
SWFUpload.prototype.loadFlash = function(){
    var html = "";
    var sb = new stringBuilder();
    if (navigator.plugins && navigator.mimeTypes && navigator.mimeTypes.length) {
        sb.append('<embed type="application/x-shockwave-flash" src="' + this.getSetting("flash_path") + '" width="' + this.getSetting("flash_width") + '" height="' + this.getSetting("flash_height") + '"');
        sb.append(' id="' + this.movieName + '" name="' + this.movieName + '" ');
        sb.append('bgcolor="' + this.getSetting["flash_color"] + '" quality="high" wmode="transparent" menu="false" flashvars="');
        sb.append(this._getFlashVars());
        sb.append('" />');
    }
    else {
        sb.append('<object id="' + this.movieName + '" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="' + this.getSetting("flash_width") + '" height="' + this.getSetting("flash_height") + '">');
        sb.append('<param name="movie" value="' + this.getSetting("flash_path") + '" />');
        sb.append('<param name="bgcolor" value="#000000" />');
        sb.append('<param name="quality" value="high" />');
        sb.append('<param name="wmode" value="transparent" />');
        sb.append('<param name="menu" value="false" />');
        sb.append('<param name="flashvars" value="' + this._getFlashVars() + '" />');
        sb.append('</object>');
    }
    var container = document.createElement("div");
    container.style.width = "0px";
    container.style.height = "0px";
    container.style.position = "absolute";
    container.style.top = "0px";
    container.style.left = "0px";
    var target_element = document.getElementsByTagName("body")[0];
    if (typeof(target_element) == "undefined" || target_element == null) 
        return false;
    var html = sb.toString();
    target_element.appendChild(container);
    container.innerHTML = html;
    this.movieElement = document.getElementById(this.movieName);
};
SWFUpload.prototype._getFlashVars = function(){
    var sb = new stringBuilder();
    sb.append("uploadScript=" + this.getSetting("upload_script"));
    sb.append("&allowedFiletypesDescription=" + this.getSetting("allowed_filetypes_description"))
    sb.append("&flashLoadedCallback=" + this.getSetting("flash_loaded_callback"));
    sb.append("&uploadFileQueuedCallback=" + this.getSetting("upload_file_queued_callback"));
    sb.append("&uploadFileStartCallback=" + this.getSetting("upload_file_start_callback"));
    sb.append("&uploadProgressCallback=" + this.getSetting("upload_progress_callback"));
    sb.append("&uploadFileCompleteCallback=" + this.getSetting("upload_file_complete_callback"));
    sb.append("&uploadQueueCompleteCallback=" + this.getSetting("upload_queue_complete_callback"));
    sb.append("&uploadDialogCancelCallback=" + this.getSetting("upload_dialog_cancel_callback"));
    sb.append("&uploadFileErrorCallback=" + this.getSetting("upload_file_error_callback"));
    sb.append("&uploadFileCancelCallback=" + this.getSetting("upload_file_cancel_callback"));
    sb.append("&uploadQueueCompleteCallback=" + this.getSetting("upload_queue_complete_callback"));
    sb.append("&autoUpload=" + this.getSetting("auto_upload"));
    sb.append("&allowedFiletypes=" + this.getSetting("allowed_filetypes"));
    sb.append("&maximumFilesize=" + this.getSetting("allowed_filesize"));
    return sb.toString();
}
SWFUpload.prototype.flashLoaded = function(bool){
    this.loadUI();
    if (this.debug) 
        SWFUpload.debug("Flash called home and is ready.");
};
SWFUpload.prototype.loadUI = function(){
    if (this.getSetting("target") != "" && this.getSetting("target") != "fileinputs") {
        var instance = this;
        var target = document.getElementById(this.getSetting("target"));
        var browselink = document.createElement("a");
        browselink.className = this.getSetting("browse_link_class");
        browselink.id = this.movieName + "BrowseBtn";
        browselink.href = "javascript:void(0);";
        browselink.onclick = function(){
            instance.browse();
            return false;
        }
        browselink.innerHTML = this.getSetting("browse_link_innerhtml");
        target.innerHTML = "";
        target.appendChild(browselink);
        if (this.getSetting("auto_upload") == false) {
            var uploadlink = document.createElement("a");
            uploadlink.className = this.getSetting("upload_link_class");
            uploadlink.id = this.movieName + "UploadBtn";
            uploadlink.href = "#";
            uploadlink.onclick = function(){
                instance.upload();
                return false;
            }
            uploadlink.innerHTML = this.getSetting("upload_link_innerhtml");
            target.appendChild(uploadlink);
        }
    }
};
SWFUpload.debug = function(value){
    if (window.console) 
        console.log(value);
    else 
        alert(value);
}
SWFUpload.prototype.addSetting = function(name, value, default_value){
    return this.settings[name] = (typeof(value) == "undefined" || value == null) ? default_value : value;
};
SWFUpload.prototype.getSetting = function(name){
    return (typeof(this.settings[name]) == "undefined") ? null : this.settings[name];
};
SWFUpload.prototype.browse = function(){
    this.movieElement.browse();
};
SWFUpload.prototype.upload = function(){
    this.movieElement.upload();
}
SWFUpload.prototype.cancelFile = function(file_id){
    this.movieElement.cancelFile(file_id);
};
SWFUpload.prototype.cancelQueue = function(){
    this.movieElement.cancelQueue();
};
SWFUpload.prototype.debugSettings = function(){
    var sb = new stringBuilder();
    sb.append("----- DEBUG SETTINGS START ----\n");
    sb.append("ID: " + this.movieElement.id + "\n");
    for (var key in this.settings) 
        sb.append(key + ": " + this.settings[key] + "\n");
    sb.append("----- DEBUG SETTINGS END ----\n");
    sb.append("\n");
    var res = sb.toString();
    SWFUpload.debug(res);
};
function stringBuilder(join){
    this._strings = new Array;
    this._join = (typeof join == "undefined") ? "" : join;
    stringBuilder.prototype.append = function(str){
        this._strings.push(str);
    };
    stringBuilder.prototype.toString = function(){
        return this._strings.join(this._join);
    };
};
