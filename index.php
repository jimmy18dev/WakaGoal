<?php
include_once 'autoload.php';

if($user_online){
    $activity = new Activity();
    $yesterday = $activity->Yesterday($user->id);
    $thisweek = $activity->ThisWeek($user->id);
    $thismonth = $activity->ThisMonth($user->id);
}
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

<?php include'favicon.php';?>

<!-- Meta Tag Main -->
<meta name="description" content="<?php echo TITLE;?>"/>
<meta property="og:title" content="<?php echo TITLE;?>"/>
<meta property="og:description" content="<?php echo DESCRIPTION;?>"/>
<meta property="og:url" content="<?php echo DOMAIN;?>"/>
<meta property="og:image" content="<?php echo DOMAIN.'/image/ogimage.jpg';?>"/>
<meta property="og:type" content="website"/>
<meta property="og:site_name" content="<?php echo SITENAME;?>"/>

<meta itemprop="name" content="<?php echo TITLE;?>">
<meta itemprop="description" content="<?php echo DESCRIPTION;?>">
<meta itemprop="image" content="<?php echo DOMAIN.'/image/ogimage.jpg';?>">

<title><?php echo TITLE;?></title>

<base href="<?php echo DOMAIN;?>">
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="stylesheet" type="text/css" href="plugin/font-awesome/css/font-awesome.min.css"/>
</head>
<body>
<?php include 'header.php'; ?>

<?php if(!$user_online){?>
<div class="login">
    <p>How much time do you spend coding ?</p>
    <a href="https://wakatime.com/oauth/authorize?client_id=<?php echo AppID;?>&redirect_uri=<?php echo RedirectURI;?>&response_type=code&scope=email,read_logged_time">Connect Your Wakatime<i class="fa fa-plug" aria-hidden="true"></i></a>
</div>
<?php }else{?>
<div class="stat">
    <div class="items">
        <div class="v"><?php echo (!empty($yesterday['text'])?$yesterday['text']:'<span>Calm Down :)</span>');?></div>
        <div class="c">Yesterday</div>
    </div>
    <div class="items">
        <div class="v"><?php echo (!empty($thisweek['text'])?$thisweek['text']:'<span>Wait Tomorrow...</span>');?></div>
        <div class="c">This Week</div>
    </div>
    <div class="items">
        <div class="v"><?php echo (!empty($thismonth['text'])?$thismonth['text']:'<span>Wait Tomorrow...</span>');?></div>
        <div class="c">This Month</div>
    </div>
</div>
<div class="chart">
	<canvas id="chart"></canvas>
</div>
<?php }?>

<script type="text/javascript" src="js/lib/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="js/lib/chart.min.js"></script>
<script type="text/javascript" src="js/lib/Chart.roundedBarCharts.min.js"></script>
<script type="text/javascript">
Chart.defaults.global.defaultFontColor = '#999999';
Chart.defaults.global.defaultFontSize = '16';
Chart.defaults.global.defaultFontFamily = 'Barlow';

$(function(){
	$.ajax({
            url         :'api/activity.php',
            cache       :false,
            dataType    :"json",
            type        :"GET",
            data:{ request : 'activities' },
            error: function (request, status, error){
                console.log(request.responseText);
            }
        }).done(function(data){

            var date = []
            var total_seconds = []

            $.each(data.activities, function(k,v) {
                date.push(v.date_text)
                total_seconds.push(v.total_seconds)
            });

            var ctx = document.getElementById('chart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: date,
                    datasets: [{
                        data: total_seconds,
                        backgroundColor: '#13BF4C',
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cornerRadius: 10,
                	legend: { display: false },
                	tooltips: {
	                    mode: 'index',
	                    intersect: false,
	                    callbacks: {
	                    	title: function(){
	                    		return false
	                    	},
	                    	label: function(tooltipItems){
	                    		return toHour(tooltipItems.yLabel);
	                    	}
	                    }
	                },
                    scales: {
                        xAxes: [{
                            gridLines: {
                            	display: false,
                            	drawBorder: false
                            }
                        }],
                        yAxes: [{
                        	gridLines: {
                            	display: false,
                            	drawBorder: false
                            },
                            ticks: {
                            	stepSize: 3600,
                            	beginAtZero: true,
                            	callback: function(value, index, values) {
                            		var lastv = (values.length)-1
                            		if(index != lastv)
                            			return Math.floor(value / 3600)+' hr'
                            		else
                            			return '';
                            	}
                            }
                        }]
                    }
                }
            });
        });
});

function toHour(sec_num){
    var hours   = Math.floor(sec_num / 3600)
    var minutes = Math.floor((sec_num - (hours * 3600)) / 60)

    return (hours > 0 ? hours+' hrs ':'') + (minutes > 0 ? minutes+' minutes':'')
}
</script>
<body>