<?
	require('libs/phpQuery/phpQuery.php');
	
	$url = "http://twitpic.com/4hdmzc";
	$url = "http://twitpic.com/4hf8jk";
	$url = "http://twitpic.com/1qiutb";
	$url = "http://25.media.tumblr.com/tumblr_lhs0ssF9aX1qe1u2co1_500.gif";
	$url = "http://24.media.tumblr.com/tumblr_likcz8hQkN1qfm827o1_500.jpg";
	$url = "http://tenso.blog.br/wp-content/2011/03/enhanced-buzz-25600-1301347176-39.png";	
	$url = "http://t.co/MY9b42o";
	$url = "http://yfrog.com/gzvvsjij";
	$url = "http://t.co/uC8sH1c";
	$url = "http://i.imgur.com/w2aHU.jpg";
	$url = "http://bit.ly/hhj19H";
	$url = "http://plixi.com/p/89897091";
	$url = "http://fb.me/WoObXhIC";
	$url = "http://img.ly/3nww";
	
	if(isset($_GET['url'])) { $url = $_GET['url']; }
	
	// URL SHORTENING SERVICES
	if(strstr($url,"bit.ly")) {
		$headers = get_headers($url);
		$url = str_replace("Location: ","",$headers[7]);
	}
	
	if(strstr($url,"t.co")) {
		$headers = get_headers($url);
		$url = str_replace("Location: ","",$headers[3]);
	}
	
	if(strstr($url,"http://fb.me/")) {
		$headers = get_headers($url);
		$url = str_replace("Location: ","",$headers[1]);
	}
	
	
	// IMAGE SERVICES
	if(strstr($url,"yfrog.com")) {
		$img = $url . ":iphone";
		$output = file_get_contents($img);		
	}
	
	if(strstr($url,"twitpic.com")) {
		$img = str_replace(".com",".com/show/full",$url);
		$output =  file_get_contents($img);	
	}
	
	if(strstr($url,"plixi")) {
		$img = "http://api.plixi.com/api/tpapi.svc/imagefromurl?size=big&url=" . $url;	
		$output =  file_get_contents($img);		
	}
	
	if(strstr($url,"instagr.am")) {
		phpQuery::newDocumentFile($url);
		$img = pq("img.photo")->attr("src");
		$output =  file_get_contents($img);	 	
	}
	
	if(strstr($url,"mobypicture") || strstr($url,"moby.to")) {
		$img = $url . ":full";
		$output = file_get_contents($img);		
	}
	
	if(strstr($url,"twitgoo.com")) {
		$img = str_replace(".com",".com/show/img",$url);
		$output =  file_get_contents($img);	
	}
	
	if(strstr($url,"posterous")) {
		phpQuery::newDocumentFile($url);
		$img = pq("img[width=500]")->attr("src");
		$output =  file_get_contents($img);	 	
	}
	
	if(strstr($url,"img.ly")) {
		phpQuery::newDocumentFile($url);
		$img = pq("#the-image")->attr("src");
		$img = explode("?",$img);		
		$output =  file_get_contents("http://img.ly/" . $img[0]);	 	
	}	
	
	
	// ALL DIRECT IMAGES
	if(strstr($url,".gif") || strstr($url,".jpg") || strstr($url,".png")) {
		$img = $url;
		$output =  file_get_contents($img);			
	}
	
	header("Content-type: image");
	die($output);
	
?>