var rpp = 5;
var mostRecent = 0;

var messages = {
	stack:[],
	showRate:5000,
	fetchRate:10000,
	current:0,
	playing:false,
	queue:function(msg) {
		if(msg.image) {
			msg.preloader = new Image;
			msg.preloader.src = msg.image;	
			msg.preloader.onload = function() {
				//console.log("done loading " + this.src + " (" + this.width + "," + this.height + ")");	
			}
		}
		messages.stack.push(msg);
	},
	fetch:function() {
		method = "search";
		// call straight from twitter
		//console.log("http://search.twitter.com/search.json?q=" + term + "&rpp=" + rpp + "&since_id=" + mostRecent + "&callback=?");
		if(method=="search") {
			fetchURL = "http://search.twitter.com/search.json?q=" + term + "&rpp=" + rpp + "&since_id=" + mostRecent + "&callback=?";	
		}
		if(method=="timeline") {
			fetchURL = "http://api.twitter.com/version/statuses/home_timeline.json&callback=?";
		}
		
		$.getJSON(fetchURL,function(data) {			
		//console.log(data);	
			for(var i=0;i<data.results.length;i++) {
				mostRecent = data.results[i].id;
				/*
				if(findLink(data.results[i].text)){
					//console.log(findImage(findLink(data.results[i].text)));
					$.get("http://localhost:8887/get/" + findLink(data.results[i].text),function(msg) {
						messages.queue({
							text:data.results[i].text,
							user:data.results[i].from_user,
							image:findImage(findLink(data.results[i].text))
						});	
					});
				} else {
					*/
					messages.queue({
						text:data.results[i].text,
						user:data.results[i].from_user,
						image:false
					});	
				
				//}
			}
			if(!messages.playing) {
				messages.show();
				messages.playing = setInterval(messages.show,messages.showRate);
			}
		});	
		
		// call from cached version
		// TODO
	},
	show:function() {
		var current = messages.stack[messages.current]
		$(".current").fadeOut(100,function() {
			$(this).empty();
			$(".current").fadeIn();
			if(current.image) {
				$(".current").append("<img align='left' src='" + current.image + "'>");					
			}
			$(".current").append("<div class='user'>@" + current.user + "</div>");
			//effects.rand(current);
			effects.use("fadeWords",current);
		});
		messages.current = messages.current < messages.stack.length-1 ? messages.current+1 : messages.current;
	}
}	


// extractors
function findLink(msg) {
	if(msg.indexOf("http://")>-1) {
		url = msg.split("http://");
		url = "http://" + url[1].split(" ")[0];
		return url;
	} else {
		return false;
	}		
}

function findImage(url) {
	
	ret = false;
	
	// is it twitpic?
	if(url.indexOf("twitpic.com/")>-1) {
		imgurl = url.split(".com/");
		imgurl = imgurl[0] + ".com/show/full/" + imgurl[1];
		ret = imgurl;
	}
	
	// is it yfrog?
	if(url.indexOf("yfrog.com/")>-1) {
		imgurl = url + ".th.jpg";
		ret = imgurl;
	}
	
	// is it plixi?
	if(url.indexOf("plixi.com/")>-1) {
		imgurl = "http://api.plixi.com/api/tpapi.svc/imagefromurl?size=full&url=" + url;
		ret = imgurl;
	}
	
	// is it imgur?
	if(url.indexOf("imgur.com/")>-1) {
		imgurl = url;
		ret = imgurl;
	}			
	
	return ret;
}

effects = {	
		stack:[],
		add:function(name,func) {
			effects.stack.push({name:name,func:func});
		},
		use:function(name,message) {
			//console.log(message);
			for(var i=0;i<effects.stack.length;i++) {
				if(effects.stack[i].name == name) {
					effects.stack[i].func.call(this,message);
				}
			}
		},
		rand:function(message) {
			var r = Math.floor(Math.random()*effects.stack.length);		
			effects.use(effects.stack[r].name,message);
		}
	}
	
	effects.add("scaleCharacters", function(message) {
		var rate = 20;
		var text = message.text;
		for(var t = 0;t<text.length;t++) {
			$(".current").append("<span class='chr_" + t + "' style='font-size:1px'>" + text[t] + "</span>");
			$(".chr_" + t).animate({fontSize:fontSize},t*rate);
		}	
	});
	effects.add("scaleWords",function(message) {
		var rate = 100;
		var text = message.text;
		words = text.split(" ");
		for(var w = 0;w<words.length;w++) {
			$(".current").append("<span class='word_" + w + "' style='font-size:1px'>" + words[w] + " </span>");
			$(".word_" + w).animate({fontSize:fontSize},w*rate);
		}
	});	
	effects.add("fadeWords", function(message) {
		var rate = 100;
		var text = message.text;
		words = text.split(" ");
		for(var w = 0;w<words.length;w++) {
			$(".current").append("<span class='word_" + w + "' style='font-size:" + fontSize + "px'>" + words[w] + " </span>");
			$(".current .word_" + w).fadeOut(0).fadeIn(w*rate)
		}
	});
		
	$(function() {
		$(".term").html(term);
		messages.fetch();
		setInterval(messages.fetch,messages.fetchRate);
	});
