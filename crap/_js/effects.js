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
				} else {
					//console.log("Effect " + name + " not found");
					// effect not found	
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
		var textSize = 60;
		var text = message.text;
		for(var t = 0;t<text.length+1;t++) {
			setTimeout(function(text,t) {
				if(t<text.length) {
					$(".current").append("<span class='chr_" + t + "' style='font-size:1px'>" + text[t] + "</span>");
				}
				$(".current .chr_" + (t-1)).animate({fontSize:textSize},200);
			},t*rate,text,t);
		}	
	});
	effects.add("scaleWords",function(message) {
		var rate = 100;
		var textSize = 60;
		var text = message.text;
		words = text.split(" ");
		for(var w = 0;w<words.length+1;w++) {
			setTimeout(function(word,w) {
				if(w<words.length) {
					$(".current").append("<span class='word_" + w + "' style='font-size:1px'>" + word + " </span>");
				}
				$(".current .word_" + (w-1)).animate({fontSize:textSize},200);
			},w*rate,words[w],w);
		}	
	});	
	effects.add("fadeWords", function(message) {
		var rate = 100;
		var textSize = 60;
		var text = message.text;
		
		words = text.split(" ");
		for(var w = 0;w<words.length+1;w++) {
			setTimeout(function(word,w) {
				if(w<words.length) {
					$(".current").append("<span class='word_" + w + "' style='font-size:40px; display:none'>" + word + " </span>");
				}
				$(".current .word_" + (w-1)).fadeOut(0).fadeIn(500)
			},w*rate,words[w],w);
		}	
	});