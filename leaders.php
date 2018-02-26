<?php
include_once 'autoload.php';

if (!$user_online) {
    header("Location: index.php");
    exit();
}

$activity = new Activity();
$leaderboards = $activity->leaderboards();
$current_page = 'leaderboards';
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
    <?php foreach ($leaderboards as $var) {?>
    <div class="leader-items">
        <div class="date"><?php echo $var['date_text'];?></div>
        <?php
        $i = 0;
        uasort($var['activity'], function ($a, $b) { return $b['total_seconds'] - $a['total_seconds']; });
        foreach ($var['activity'] as $items){
        ?>
            <div class="user-items">
                <div class="photo">
                    <img src="<?php echo (!empty($items['photo'])?$items['photo']:'image/avatar.png');?>">
                    <?php if($i==0){?><i class="fa fa-trophy" aria-hidden="true"></i><?php }?>
                </div>
                <div class="name"><?php echo $items['username'];?></div>
                <div class="time"><?php echo $items['text'];?></div>
            </div>
        <?php $i++;} ?>
    </div>
    <?php } ?>
</div>
<body>