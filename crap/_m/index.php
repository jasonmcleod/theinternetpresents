<?
	if(isset($_GET['term'])) {
		$term = addslashes($_GET['term']);
	} else {
		$term = "html5";	
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"/>
<title>THEINTERNETPRESENTS</title>
<style>
	* {
		margin:0px;
		padding:0px;
		font-family:"Helvetica LT Std","Helvetica",Arial, sans-serif;
	}
	body {
		background:#454545;
	}
	.current {
		padding:10px;	
	}
	.current img {
		max-height:40%;
		max-width:100%;
		margin-right:20px;
		margin-bottom:20px;	
		border:1px solid #333;
		
	}
	.current .user {
		font-size:20px;
		color:#fff;
	}
	.current span {
		background:#FF3399;
		color:#fff;
		padding-right:1px;
	}
</style>
</head>
<body>
<div class="current"></div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script>
	var term = "<?=$term?>";
	var fontSize = 20;
</script>
<script type="text/javascript" src="../_js/main.js"></script>
<script>
	var sentOn = false;
	setInterval(function() {
		var now = new Date();
//		console.log(now.getHours());
		console.log(now.getMinutes());	
//		console.log(now.getSeconds());
		if(now.getHours()==23 && now.getMinutes()==59 && !sentOn) {

			window.location = "/2011/index.html";
			sentOn = true;			
		}
		
	
	},1000);
</script>
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