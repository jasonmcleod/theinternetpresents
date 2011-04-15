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
<title>Theinternetpresents.com</title>
<link rel="stylesheet" href="styles.css" />
</head>
<body>
<div id="header">
	<div id="headerText">
		<span class="white">theinternetpresents.com/</span>
		<span class="black term"><?=$term?></span>
	</div>
</div>
<div id="middle">
	<div id="content">
		<table width="800" height="380" align="center"><tr><td>
		<div class="current"></div>
		</td></tr></table>
	</div>
</div>
<div id="footer">
	<div id="footerText"><span style="float:left">© 2010 theinternetpresents.com</span><span style="float:right"><a href="http://twitter.com/jasonmcleod" target="_blank" style="color:black; text-decoration:none;">@jasonmcleod</a></span></div>
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script>
	var term = "<?=$term?>";
	var fontSize = 40;
</script>
<script type="text/javascript" src="_js/main.js"></script>

<script>
/*
	var sentOn = false;
	setInterval(function() {
		var now = new Date();
		if(now.getHours()==23 && now.getMinutes()==59 && !sentOn) {

			window.location = "/2011/index.html";
			sentOn = true;			
		}
		
	
	},1000);
	*/
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