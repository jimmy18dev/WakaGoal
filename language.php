<?php
include_once 'autoload.php';

if (!$user_online) {
	header("Location: index.php");
	exit();
}
$activity = new Activity();
$dataset = $activity->languageOfMonth($user->id);
$current_page = 'language';
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

<title>Leaderboards | Hour of Code</title>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="stylesheet" type="text/css" href="plugin/font-awesome/css/font-awesome.min.css"/>
</head>
<body>
<?php include 'header.php'; ?>

<div class="container">
    <?php foreach ($dataset as $var) {?>
    <div class="items">
        <div class="name"><?php echo $var['language'];?></div>
        <div class="time"><?php echo $var['text'];?></div>
    </div>
    <?php } ?>
</div>
<body>