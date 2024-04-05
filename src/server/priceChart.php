<!--Find Documentation at : https://www.chartjs.org/docs/2.9.4/charts/line.html -->
<?php
echo "<p> " . $item_ID['ITEM_NAME'] . " Chart</p>";
echo "<canvas id=\"chart-" . $item_ID['ITEM_ID'] . "\" style=\"width:100%;max-width:600px\"></canvas>";
?>
<script>
	<?php $chartData = Item_info::parsed_GetAllPrices($item_ID['ITEM_ID'], $item_id) ?>;
	var xValues = <?php echo json_encode($chartData[0]); ?>;
	var yValues = <?php echo json_encode($chartData[1]); ?>;
    console.log(xValues);
    console.log(yValues);
	var chartId = "chart-" + "<?php echo $item_id['ITEM_ID']; ?>";
	var minValue = Math.min(...yValues);
	var maxValue = Math.max(...yValues);
	var padding = (maxValue - minValue) * 0.1; // Adds 10% padding on each side
	new Chart(chartId, {
		type: "line",
		data: {
			labels: xValues,
			datasets: [{
				fill: false,
				lineTension: 0,
				backgroundColor: "rgba(0,0,255,1.0)",
				borderColor: "rgba(0,0,255,0.1)",
				data: yValues
			}]
		},
		options: {
			legend: {
				display: false
			},
			scales: {
				x: {
					type: 'time',
					time: {
						parser: 'DD MM YYYY', // specify your input format here
						displayFormats: {
							day: 'DD MMM YY' // set this to your desired output format
						},
						tooltipFormat: 'DD MMM YY'
					},
					ticks: {
						autoSkip: true,
					},
					title: {
						display: true,
						text: 'Date'
					}
				},
				y: {
					ticks: {
						autoSkip: true,
						stepSize: 200,
						min: minValue - padding,
						max: maxValue + padding,
					},
					title: {
						display: true,
						text: '$'
					}
				},
			}
		}
	});
</script>