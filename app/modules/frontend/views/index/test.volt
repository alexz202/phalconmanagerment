{% extends 'base.volt' %}
{%block title%}
 test title
{%endblock%}

{%block extrascript%}
   {{javascript_include('js/Highcharts-5.0.14/code/highcharts.js')}}
   {{javascript_include('js/Highcharts-5.0.14/code/modules/exporting.js')}}
{%endblock%}

{%block content%}
<div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
		<script type="text/javascript">

Highcharts.chart('container', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: '{{title}}'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: [{
            name: 'Microsoft Internet Explorer',
            y: 1200
        }, {
            name: 'Chrome',
            y: 8800,
        }, {
            name: 'Firefox',
            y: 3310
        }, {
            name: 'Safari',
            y: 6
        }, {
            name: 'Opera',
            y: 8
        }, {
            name: 'Proprietary or Undetectable',
            y: 10.2
        }]
    }]
});
		</script>




{%endblock%}