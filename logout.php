<?php
include'autoload.php';

// Unset all session values
$_SESSION = array();

// Destroy session
unset($_COOKIE['login_string']);
unset($_SESSION['login_string']);
setcookie('login_string','');
session_destroy();
?>
<!doctype html>
<html lang="en-US" itemscope itemtype="http://schema.org/Blog" prefix="og: http://ogp.me/ns#">
<head>

<!--[if lt IE 9]>
<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
<![endif]-->

<!-- Meta Tag -->
<meta charset="utf-8">

<!-- Viewport (Responsive) -->
<meta name="viewport" content="width=device-width">
<meta name="viewport" content="user-scalable=no">
<meta name="viewport" content="initial-scale=1,maximum-scale=1">

<title>Logout...</title>
<link rel="stylesheet" href="css/style.css" type="text/css"/>
<link rel="stylesheet" type="text/css" href="plugin/font-awesome/css/font-awesome.min.css"/>

</head>
<body>
<div class="announce">
	<h2>You have successfully logged out!</h2>
</div>

<script type="text/javascript" src="js/lib/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
$(function(){
	setTimeout(function(){
		window.location = 'index.php';
	},1000);
});
</script>
</body>
</html>
