Chart.defaults.global.defaultFontColor = '#999999';
Chart.defaults.global.defaultFontFamily = 'maledpan';

//Constructor
var BPM = function (){
    var self = this;

    this.admitIPD = function(target){
        $.ajax({
            url         :'http://172.16.0.4/hdc/admit/ipd',
            cache       :false,
            dataType    :"json",
            type        :"GET",
            data:{ request : null },
            error: function (request, status, error){
                console.log(request.responseText);
            }
        }).done(function(data){
            var clinicdescribe = []
            var num = []

            $.each(data.data, function(k,v) {
                clinicdescribe.push(v.clinicdescribe)
                num.push(v.num)
            });

            var ctx = document.getElementById(target).getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: clinicdescribe,
                    datasets: [{
                        label: 'CMI',
                        data: num,
                        backgroundColor: '#004d40',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                        maintainAspectRatio: false,
                    scales: {
                        yAxes: [{
                            stacked: true,
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });
        });
    }

    this.topDiag = function(target,type){

        if(type == 'opd')
            var url = 'http://172.16.0.4/hdc/top/opd';
        else if(type == 'ipd')
            var url = 'http://172.16.0.4/hdc/top/ipd';
        else
            return false

        $.ajax({
            url         :url,
            cache       :false,
            dataType    :"json",
            type        :"GET",
            data:{ request : null },
            error: function (request, status, error){
                console.log(request.responseText);
            }
        }).done(function(data){
            var diseasethai = []
            var num = []

            $.each(data.data, function(k,v) {
                diseasethai.push('('+v.diseasecode+') '+v.diseasethai)
                num.push(v.num)
            });

            console.log(data)

            var ctx = document.getElementById(target).getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    datasets: [{
                        data: num,
                        backgroundColor: ['#004D40','#f39c12','#27ae60','#2980b9','#8e44ad'],
                    }],
                    labels: diseasethai,
                },
                options: {
                    responsive: true,
                    legend: {
                        position: 'right',
                        labels: {
                            fontColor: '#444444',
                            fontSize: 14
                        }
                    }
                }
            });
        });
    }

    // Case Mix Index
    this.cmi = function(target){
        $.ajax({
            url         :'http://172.16.0.4/hdc/cmi',
            cache       :false,
            dataType    :"json",
            type        :"GET",
            data:{ request : null },
            error: function (request, status, error){
                console.log(request.responseText);
            }
        }).done(function(data){
            var month = []
            var cmi = []
            var current_cmi;

            $.each(data.data, function(k,v) {
                month.push(self.toMonth(v.MONTH-1))
                cmi.push(v.cmi)
            });

            current_cmi = cmi[cmi.length - 1];
            $('#current_cmi').html(current_cmi);

            var ctx = document.getElementById(target).getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: month,
                    datasets: [{
                        data: cmi,
                        backgroundColor: 'rgba(0,77,64,0.5)',
                        borderColor: '#004D40',
                        borderWidth: 3
                    }]
                },
                options: {
                    // responsive: true,
                    // maintainAspectRatio: false,
                    legend: { position: false,},
                    scales: {
                        xAxes: [{
                            gridLines: { drawBorder: false }
                        }],
                        yAxes: [{
                            gridLines: { drawBorder: false }
                        }]
                    }
                }
            });
        });
    }

    this.deathRate = function(target){
        $.ajax({
            url         :'http://172.16.0.4/hdc/deathrate',
            cache       :false,
            dataType    :"json",
            type        :"GET",
            data:{ request : null },
            error: function (request, status, error){
                console.log(request.responseText);
            }
        }).done(function(data){
            console.log(data)

            var month = []
            var total = []
            var death = []
            var deathrate = []

            $.each(data.data, function(k,v) {
                month.push(v.month)
                total.push(v.total)
                death.push(v.death)
                deathrate.push(v.deathrate)
            });

            var ctx = document.getElementById(target).getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: month,
                    datasets: [{
                        label: 'Death',
                        data: death,
                        backgroundColor: '#d35400',
                        borderWidth: 1
                    },{
                        label: 'Total',
                        data: total,
                        backgroundColor: '#004D40',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                        maintainAspectRatio: false,
                    scales: {
                        xAxes: [{
                            stacked: true,
                        }],
                        yAxes: [{
                            stacked: true
                        }]
                    }
                }
            });
        });
    }

    // Visit Counter
    this.visitCounter = function(target,type){

        if(type == 'year')
            var url = 'http://172.16.0.4/hdc/opd/visit/1/year';
        else if(type == 'month')
            var url = 'http://172.16.0.4/hdc/opd/visit/1/month';
        else if(type == 'day')
            var url = 'http://172.16.0.4/hdc/opd/visit/7/day';
        else
            return false

    	$.ajax({
            url         :url,
            cache       :false,
            dataType    :"json",
            type        :"GET",
            data:{ request : null },
            error: function (request, status, error){
                console.log(request.responseText);
            }
        }).done(function(data){

            var labels = []
            var counter = []

            $.each(data.data, function(k,v) {
                if(type == 'year')
                    labels.push(v.MONTH)
                else if(type == 'month')
                    labels.push(v.date)
                else if(type == 'day')
                    labels.push(v.date)

                counter.push(v.num)
            });

            var ctx = document.getElementById(target).getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        backgroundColor: 'rgba(0,77,64,0.5)',
                        borderColor: '#004D40',
                        borderWidth: 3,
                        data: counter
                    }]
                },
                options: {
                    legend: { position: false,},
                    scales: {
                        yAxes: [{
                        }]
                    }
                }
            });
        });
    }

    this.toMonth = function(month){
        var monthNames = ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];
        return monthNames[month];
    }
}