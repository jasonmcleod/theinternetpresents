<? include("../inc.init.php"); ?>
<pre>
<?
	// query the db for info about this channel
	$channel = query("SELECT * FROM channels_channels WHERE id = " . intval($_GET['channel']));
	
	// store the most recent tweet
	if(!isset($_SESSION['tip_mostRecent'])) { $_SESSION['tip_mostRecent'] = 0; }
	
	// poll twitter
	$json = file_get_contents("http://search.twitter.com/search.json?q=" . $channel['data']['term'] . "&rpp=" . $channel['data']['rpp'] . "&since_id=" . $_SESSION['tip_mostRecent']);
	
	// turn it into an object;
	$parsed = json_decode($json);
	
	// query the db for the rules for this channel
	$rules = query("SELECT * FROM channels_rules WHERE channel = " . $channel['data']['id']);
	
	// iterate over the tweets and automatically approve/reject based on the rules
	foreach($parsed->results as $tweet) {
		$link = findLink($tweet->text);
		echo ($link?$link:"No link") . "\n";
		$_SESSION['tip_mostRecent'] = $tweet->id_str;
	}





	// functions ///////////////////////////////////////////////////////////////////////////
	
	function findLink($msg) {
		if(strstr($msg,"http://")) {			// does $msg even have a link?
			$url = explode("http://",$msg);		// split $msg on the start of the link
			$url = explode(" ",$url[1]);		// split $msg on the end of the link
			return "http://" . $url[0];			// return the link
		} else {
			return false;
		}		
	}
	
	////////////////////////////////////////////////////////////////////////////////////////

?>
</pre>