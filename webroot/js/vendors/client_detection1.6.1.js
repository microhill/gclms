/**
 * @author Ryan Johnson <ryan@livepipe.net>
 * @copyright 2007 LivePipe LLC
 * @package Prototype.Tidbits
 * @license MIT
 * @url http://livepipe.net/projects/prototype_tidbits/
 * @version 1.6.1
 */
 
var Client = {
	browser: false,
	OS: false,
	version: false,
	current_place: 0,
	current_string: '',
	detect: navigator.userAgent.toLowerCase(),
	load: function(){
		if(Client.check("konqueror")){
			Client.browser = "Konqueror";
			Client.OS = "Linux";
		}else{
			$H({
				safari: "Safari",
				omniweb: "OmniWeb",
				opera: "Opera",
				webtv: "WebTV",
				icab: "iCab",
				msie: "Internet Explorer"
			}).each(function(browser){
				if(!Client.browser && Client.check(browser[0]))
					Client.browser = browser[1];
			});
		}
		if(!Client.browser && !Client.check('compatible')){
			Client.browser = "Netscape Navigator"
			Client.version = Client.detect.charAt(8);
		}
		if(!Client.version)
			Client.version = Client.detect.charAt(Client.current_place + Client.current_string.length);
		if(!Client.OS){
			$H({
				linux: "Linux",
				x11: "Unix",
				mac: "Mac",
				win: "Windows"
			}).each(function(OS){
				if(!Client.OS && Client.check(OS[0]))
					Client.OS = OS[1];
			});
			if(!Client.OS)
				Client.OS = "unknown";
		}
	},
	check: function(string){
		Client.current_string = string;
		Client.current_place = Client.detect.indexOf(string) + 1;
		return Client.current_place;
	}	
};
Client.load();