/* basic radialbar chart */
	var options = {
		series: [85],
		options: {
			colors: ['var(--primary-bg-color)'],
			states: {
				normal: {
				filter: {
					type: 'none',
				}
				},
				hover: {
					filter: {
						type: 'none',
					}
				},
				active: {
				filter: {
					type: 'none',
				}
				},
			},
			plotOptions: {
				radialBar: {
				offsetY: 0,
				startAngle: 0,
				hollow: {
					margin: 20,
					size: "50%",
					background: "#fff",
					stroke: {
						width: 5, // Adjust this value to set the desired stroke width
					  }
					},
					dataLabels: {
					name: {
						show:false,
						fontSize: '16px',
						color: undefined,
						offsetY: 5
					},
					value: {
						show: false,
						offsetY: 76,
						fontSize: '22px',
						color: undefined,
					}
				}
				},
			},
			},
		chart: {
			height: 170,
			width: 170,
			type: 'radialBar',
		},
		stroke: {
			lineCap: 'round'
		},
		colors: ["#38cab3"],
		labels: [""],
	};
	var chart = new ApexCharts(document.querySelector("#radialbar-basic1"), options);
	chart.render();
	function radialbarBasic() {
		chart.updateOptions({
			colors: ["rgb(" + myVarVal + ")"],
		});
	}



// Project Budget chart //
	var options1 = {
		series: [{
			name: 'Total Orders',
			data: [44, 42, 57, 86, 58, 55, 70, 43, 23, 54, 77, 34],
		}, {
			name: 'Total Sales',
			data: [34, 22, 37, 56, 21, 35, 60, 34, 56, 78, 89, 53],
		}],
		chart: {
			type: 'bar',
			height: 280
		},
		grid: {
			borderColor: '#f2f6f7',
		},
		colors: ["#38cab3", "#e4e7ed"],
		plotOptions: {
			bar: {
				colors: {
					ranges: [{
						from: -100,
						to: -46,
						color: '#ebeff5'
					}, {
						from: -45,
						to: 0,
						color: '#ebeff5'
					}]
				},
				columnWidth: '40%',
			}
		},
		dataLabels: {
			enabled: false,
		},
		stroke: {
			show: true,
			width: 4,
			colors: ['transparent']
		},
		legend: {
			show: true,
			position: 'top',
		},
		yaxis: {
			title: {
				text: 'Growth',
				style: {
					color: '#adb5be',
					fontSize: '14px',
					fontFamily: 'poppins, sans-serif',
					fontWeight: 600,
					cssClass: 'apexcharts-yaxis-label',
				},
			},
			labels: {
				formatter: function (y) {
					return y.toFixed(0) + "";
				}
			}
		},
		xaxis: {
			type: 'month',
			categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'sep', 'oct', 'nov', 'dec'],
			axisBorder: {
				show: true,
				color: 'rgba(119, 119, 142, 0.05)',
				offsetX: 0,
				offsetY: 0,
			},
			axisTicks: {
				show: true,
				borderType: 'solid',
				color: 'rgba(119, 119, 142, 0.05)',
				width: 6,
				offsetX: 0,
				offsetY: 0
			},
			labels: {
				rotate: -90
			}
		}
	};
	document.getElementById('statistics1').innerHTML = '';
	var chart1 = new ApexCharts(document.querySelector("#statistics1"), options1);
	chart1.render();
	function statistics1() {
		chart1.updateOptions({
			colors: ["rgb(" + myVarVal + ")", "#e4e7ed"],
		});
	}


//Visitors chart
	var options2 = {
		series: [{
			name: 'Male',
			data: [51, 44, 55, 42, 58, 50, 62],
		}, {
			name: 'Female',
			data: [56, 58, 38, 50, 64, 45, 55]
		}],
		chart: {
			height: 310,
			type: 'line',
			toolbar: {
				show: false,
			},
			background: 'none',
			fill: "#fff",
		},
		grid: {
			borderColor: '#f2f6f7',
		},
		colors: ["#38cab3", "#e4e7ed"],
		background: 'transparent',
		dataLabels: {
			enabled: false
		},
		stroke: {
			curve: 'smooth',
			width: 2
		},
		xaxis: {
			type: 'day',
			categories: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"]
		},
		dataLabels: {
			enabled: false,
		},
		legend: {
			show: true,
			position: 'top',
		},
		xaxis: {
			show: false,
			axisBorder: {
				show: false,
				color: 'rgba(119, 119, 142, 0.05)',
				offsetX: 0,
				offsetY: 0,
			},
			axisTicks: {
				show: false,
				borderType: 'solid',
				color: 'rgba(119, 119, 142, 0.05)',
				width: 6,
				offsetX: 0,
				offsetY: 0
			},
			labels: {
				rotate: -90,
			}
		},
		yaxis: {
			show: false,
			axisBorder: {
				show: false,
			},
			axisTicks: {
				show: false,
			}
		},
		tooltip: {
			x: {
				format: 'dd/MM/yy HH:mm'
			},
		},
	};

	document.getElementById('Viewers').innerHTML = ''
	var chart2 = new ApexCharts(document.querySelector("#Viewers"), options2);
	chart2.render();

	function Viewers() {
		chart2.updateOptions({
			colors: ["rgb(" + myVarVal + ")", "#e4e7ed"],
		});
	}

