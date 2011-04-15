<?
	@session_start();
	
	///////////////////////////////////////////////////////
	// Connection /////////////////////////////////////////
	///////////////////////////////////////////////////////
	
	$connection = mysql_pconnect("localhost", "root", "") or trigger_error(mysql_error(),E_USER_ERROR);	
	$connection_db = "tip";
	
	///////////////////////////////////////////////////////
	
	$baseURL = "/theinternetpresents.com/";

	function query($query,$debug=false) {
		if($debug) {
			echo "<pre>$query</pre>";	
		}
		
		global $connection,$connection_db;
		$return = array();
		
		mysql_select_db($connection_db, $connection);
		$thisQuery = mysql_query($query, $connection) or die(mysql_error());
		$return['total'] = mysql_num_rows($thisQuery);
		$return['data'] = mysql_fetch_assoc($thisQuery);
		$return['object'] = $thisQuery;
		
		return $return;
	}