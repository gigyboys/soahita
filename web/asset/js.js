$(function () {
	/*
	$('#date, #birthdate, #positiondate, #cindate').datepicker({
		format: 'dd/mm/yyyy',
		autoclose: true  
	});
	*/
	$('.date, #date, #birthdate, #positiondate, #cindate').datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: 'dd/mm/yy'
    });
	
	$('#datebegin, #dateend').datetimepicker({
		dateFormat: 'dd/mm/yy',
		addSliderAccess: true,
		sliderAccessArgs: { touchonly: false }
	});
	
	$('.datatooltip_close').click( function(e) {
		$(this).closest('.datatooltip').fadeOut(500);
    });


	$('.datatable, #table, #tablestockin, #tablestockout ').DataTable({
		'paging'      : true,
		'lengthChange': true,
		'searching'   : true,
		'ordering'    : true,
		'info'        : true,
		'autoWidth'   : true,
		'language' : {
			'url': urlLangDataTableFR
		}
	});

	'use strict';

	var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
	var pieChart       = new Chart(pieChartCanvas);


	var pieOptions     = {
		// Boolean - Whether we should show a stroke on each segment
		segmentShowStroke    : true,
		// String - The colour of each segment stroke
		segmentStrokeColor   : '#fff',
		// Number - The width of each segment stroke
		segmentStrokeWidth   : 1,
		// Number - The percentage of the chart that we cut out of the middle
		percentageInnerCutout: 50, // This is 0 for Pie charts
		// Number - Amount of animation steps
		animationSteps       : 100,
		// String - Animation easing effect
		animationEasing      : 'easeOutBounce',
		// Boolean - Whether we animate the rotation of the Doughnut
		animateRotate        : true,
		// Boolean - Whether we animate scaling the Doughnut from the centre
		animateScale         : false,
		// Boolean - whether to make the chart responsive to window resizing
		responsive           : true,
		// Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
		maintainAspectRatio  : false,
		// String - A legend template
		legendTemplate       : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<segments.length; i++){%><li><span style=\'background-color:<%=segments[i].fillColor%>\'></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
		// String - A tooltip template
		tooltipTemplate      : '<%=label%> : <%=value %> Ar'
	};


	pieChart.Doughnut(PieData, pieOptions);
	
	//saleschart
	
  // Get context with jQuery - using jQuery's .get() method.
  var salesChartCanvas = $('#salesChart').get(0).getContext('2d');
  // This will get the first returned node in the jQuery collection.
  var salesChart       = new Chart(salesChartCanvas);

  var salesChartOptions = {
    // Boolean - If we should show the scale at all
    showScale               : true,
    // Boolean - Whether grid lines are shown across the chart
    scaleShowGridLines      : false,
    // String - Colour of the grid lines
    scaleGridLineColor      : 'rgba(0,0,0,.05)',
    // Number - Width of the grid lines
    scaleGridLineWidth      : 1,
    // Boolean - Whether to show horizontal lines (except X axis)
    scaleShowHorizontalLines: true,
    // Boolean - Whether to show vertical lines (except Y axis)
    scaleShowVerticalLines  : true,
    // Boolean - Whether the line is curved between points
    bezierCurve             : true,
    // Number - Tension of the bezier curve between points
    bezierCurveTension      : 0.3,
    // Boolean - Whether to show a dot for each point
    pointDot                : false,
    // Number - Radius of each point dot in pixels
    pointDotRadius          : 4,
    // Number - Pixel width of point dot stroke
    pointDotStrokeWidth     : 1,
    // Number - amount extra to add to the radius to cater for hit detection outside the drawn point
    pointHitDetectionRadius : 20,
    // Boolean - Whether to show a stroke for datasets
    datasetStroke           : true,
    // Number - Pixel width of dataset stroke
    datasetStrokeWidth      : 2,
    // Boolean - Whether to fill the dataset with a color
    datasetFill             : true,
    // String - A legend template
    legendTemplate          : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<datasets.length; i++){%><li><span style=\'background-color:<%=datasets[i].lineColor%>\'></span><%=datasets[i].label%></li><%}%></ul>',
    // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
    maintainAspectRatio     : true,
    // Boolean - whether to make the chart responsive to window resizing
    responsive              : true
  };

  // Create the line chart
  salesChart.Line(chartData, salesChartOptions);
  
});