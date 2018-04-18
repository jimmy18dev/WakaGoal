Chart.defaults.global.defaultFontColor = '#999999';
Chart.defaults.global.defaultFontSize = '12';
Chart.defaults.global.defaultFontFamily = 'Barlow';

$(function(){
    var profile_id = $('#profile_id').val();
	$.ajax({
            url         :'api/activity.php',
            cache       :false,
            dataType    :"json",
            type        :"GET",
            data:{
                request : 'activities',
                profile_id: profile_id
            },
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

            var gradientFill = ctx.createLinearGradient(500, 0, 100, 0);

            gradientFill.addColorStop(0, "#13BF4C");
            gradientFill.addColorStop(1, "#1abc9c");

            // How To Make Gradient Line Chart
            // https://blog.vanila.io/chart-js-tutorial-how-to-make-gradient-line-chart-af145e5c92f9

            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: date,
                    datasets: [{
                        data: total_seconds,
                        backgroundColor: "#333333",
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cornerRadius: 5,
                	legend: { display: false },
                	tooltips: { display: false },
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

    $('#btn_goal_form_toggle').click(function(event) {
        $('#goal_form').slideToggle(300);
    });

    $('#btn_save_goal').click(function(event) {
        var goal_month = $('#goal_month').val();

        $.ajax({
            url         :'api/user.php',
            cache       :false,
            dataType    :"json",
            type        :"POST",
            data:{
                request  :'edit_goal',
                goal_month  :goal_month
            },
            error: function (request, status, error){
                console.log(request.responseText);
            }
        }).done(function(data){
            location.reload();
        });
    });
});

function toHour(sec_num){
    var hours   = Math.floor(sec_num / 3600)
    var minutes = Math.floor((sec_num - (hours * 3600)) / 60)

    return (hours > 0 ? hours+' hrs ':'') + (minutes > 0 ? minutes+' minutes':'')
}