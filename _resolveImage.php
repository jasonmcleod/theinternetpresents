<?
	$settings = array(
		"cache"=>false
	);

	require('libs/phpQuery/phpQuery.php');
	require("inc.init.php");
	
	$url = "http://twitpic.com/4hdmzc";
	$url = "http://twitpic.com/4hf8jk";
	//$url = "http://twitpic.com/1qiutb";
	$url = "http://25.media.tumblr.com/tumblr_lhs0ssF9aX1qe1u2co1_500.gif";
	$url = "http://24.media.tumblr.com/tumblr_likcz8hQkN1qfm827o1_500.jpg";
	//$url = "http://tenso.blog.br/wp-content/2011/03/enhanced-buzz-25600-1301347176-39.png";	
	//$url = "http://t.co/MY9b42o";
	//$url = "http://yfrog.com/gzvvsjij";
	//$url = "http://t.co/uC8sH1c";
	//$url = "http://bit.ly/hhj19H";
	//$url = "http://plixi.com/p/89897091";
	
	if(isset($_GET['url'])) { $url = $_GET['url']; }
	
	/*
	if($settings['cache']=="database") {
		$cachecheck = query("SELECT url,id FROM imagecache WHERE url = '" . $url . "' OR url301='" . $url . "'");
		if($cachecheck['total']!=0) {
			// fetch data
			$cachecopy = query("SELECT data,hits FROM imagecache WHERE id = '" . $cachecheck['data']['id'] . "'");
			$output = base64_decode($cachecopy['data']['data']);	
			
			// increment hit counter
			$update = "UPDATE imagecache SET hits=" . ($cachecopy['data']['hits']+1) . " WHERE id = '" . $cachecheck['data']['id'] . "'";
			mysql_select_db($connection_db);
			mysql_query($update) or die(mysql_error());			
		}
	}
	
	
	if($settings['cache']=="file") {
		$filename = md5($url);
		if(file_exists("cache/" . $filename)) {
			$output = file_get_contents("cache/" . $filename);	
		}
	}
	*/
	
	if(!isset($output)) {

		///////////////////////////////////////////////////////////////////////////////
		// URL SHORTENING SERVICES
		///////////////////////////////////////////////////////////////////////////////
		if(strstr($url,"bit.ly")) {
			$url301 = $url;
			$headers = get_headers($url);
			$url = str_replace("Location: ","",$headers[7]);
		}
		
		if(strstr($url,"t.co")) {
			$url301 = $url;			
			$headers = get_headers($url);
			$url = $url301 = str_replace("Location: ","",$headers[3]);
		}
		
		///////////////////////////////////////////////////////////////////////////////
		// IMAGE SERVICES
		///////////////////////////////////////////////////////////////////////////////		
		if(strstr($url,"yfrog.com")) {
			$img = $url . ":iphone";
			$output = file_get_contents($img);		
		}
		
		if(strstr($url,"twitpic.com")) {
			$img = str_replace(".com",".com/show/full",$url);
			$output = file_get_contents($img);	
		}
		
		if(strstr($url,"plixi")) {
			$img = "http://api.plixi.com/api/tpapi.svc/imagefromurl?size=big&url=" . $url;	
			$output = file_get_contents($img);		
		}
		
		if(strstr($url,"instagr.am")) {
			phpQuery::newDocumentFile($url);
			$img = pq("img.photo")->attr("src");
			$output = file_get_contents($img);	 	
		}
		
		///////////////////////////////////////////////////////////////////////////////
		// ALL DIRECT IMAGES
		///////////////////////////////////////////////////////////////////////////////		
		if(strstr($url,".gif") || strstr($url,".jpg") || strstr($url,".png")) {
			$img = $url;			
			$output = file_get_contents($img);			
		}
		
		
		///////////////////////////////////////////////////////////////////////////////
		// CACHE
		///////////////////////////////////////////////////////////////////////////////	
		/*		
		if($settings['cache']=="database") {
			$insert = "INSERT INTO imagecache (`url`,`url301`,`added`,`data`,`hits`) VALUES('" . $url . "','" . (isset($url301)?$url301:"") . "',',now(),'" . base64_encode(mysql_real_escape_string($output)). "',1)";
			mysql_select_db($connection_db);
			mysql_query($insert) or die(mysql_error());
		}
				
		if($settings['cache']=="file") {
			$filename = md5(isset($url301)?$url301:$url);
			file_put_contents("cache/" . $filename,$output);
			//die("put");
		}
		*/
				
	}
	
	header("Content-type: image");
	die($output);

?>