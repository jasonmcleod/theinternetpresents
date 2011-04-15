<?
	if(isset($_GET['term'])) {
		$term = addslashes($_GET['term']);
	} else {
		$term = "instagr";	
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Theinternetpresents.com - a twitter slideshow by @jasonmcleod</title>
    <style>
        * {
            font-family:Arial, Helvetica, sans-serif;		
        }
        body,html {
            margin:0px;
            padding:0px;
            background:black;
        }
        #caption {
            background:rgba(255,255,255,.2);
            color:#fff;
            font-size:20px;
            position:absolute;
            bottom:0px;
            left:0px;
            padding:20px;
            text-shadow: 2px 2px 2px #000;
        }
    </style>
</head>
<body>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script> 
<script>

	var rpp = 5;
	var mostRecent = 0;
	var term = "<?=$term?>";
	var tweets = [];
	var cycleRunning = false;

	$(function() {
		$(window).resize(function() {
			fit(document.getElementById("fullscreen"));
		});		
	});
	
	function firehose() {
		$.getJSON("http://search.twitter.com/search.json?q=" + term + "&rpp=" + rpp + "&since_id=" + mostRecent + "&callback=?",function(msg) {
			for(var r=0;r<msg.results.length;r++) {
				mostRecent = msg.results[r].id;
				var url = findLink(msg.results[r].text);
				var img = url?"resolveImage.php?url=" + url:false;				
				tweets.push({
					user:msg.results[r].from_user,
					image:img,
					text:msg.results[r].text
				});
				if(img) {
					tweets[tweets.length-1].loaded = new Image();
					if(!cycleRunning) {
						tweets[tweets.length-1].loaded.onload = function() {
							//fit(this);					
							cycle();
						}
					}
					tweets[tweets.length-1].loaded.src = img;
				}
			}
		});
	}
		
	function cycle() {
		cycleRunning = true;
		if(tweets.length>0) {
			var thisTweet = tweets.shift();	
			if(thisTweet.image) {			
				var preload = new Image();				
				preload.onload = function() { 
					$("#fullscreen").fadeOut(500,function() {
						$("#fullscreen").attr("src",thisTweet.image);
						fit(this); 
						$("#caption").html("<strong>@" + thisTweet.user + "</strong>: " + thisTweet.text);
						$("#fullscreen").fadeIn();					
					});
				}
				preload.src = thisTweet.image;	
			} else {
				$("#fullscreen").fadeOut();
				$("#caption").html("<strong>@" + thisTweet.user + "</strong>: " + thisTweet.text);	
			}			
		}
	}
	
	setInterval(firehose,10000); firehose();
	setInterval(cycle,5000); 
	
	function findLink(msg) {
		if(msg.indexOf("http://")>-1) {
			url = msg.split("http://");
			url = "http://" + url[1].split(" ")[0];
			return url;
		} else {
			return false;
		}		
	}
		
	function fit(which) {				
		var winWidth=$(window).width();
		var winHeight=$(window).height();
		var imageWidth=which.width;
		var imageHeight=which.height;
		var picHeight = imageHeight / imageWidth;
       	var picWidth = imageWidth / imageHeight;
		if ((winHeight / winWidth) > picHeight) {
            $("#fullscreen").css("width",winWidth).css("height",picHeight*winWidth);
	    } else {
            $("#fullscreen").css("height",winHeight).css("width",picWidth*winHeight);
        };
		$("#fullscreen").css({marginLeft: ((winWidth - $("#fullscreen").width())/2) });
		$("#fullscreen").css({marginTop:((winHeight - $("#fullscreen").height())/2) });	
	}

</script>
<img src="clear.gif" id="fullscreen" />
<p id="caption">Downloading some internet...<br />
Add any term at the end of the URL to change the content.</p>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-19109053-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>
</html>