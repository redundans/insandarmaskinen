(function($) {

	$('input[type="text"]' ).on('input',function(e){
		$('#signup_username').val( string_to_slug( $(this).val() ) );
	});

	$("#carouselExampleIndicators").on("slide.bs.carousel", function(event) {
		$("#carouselExampleIndicators").carousel('pause');
		if (event.from === 0) {
			if( $('#insandare-subject').val().length < 1 ) {
				alert('Din insändare borde ha en ämnesrad.');
				event.preventDefault();
			} else if( $('#insandare-content').val().length < 10 ) {
				alert('Skriv en lite längre insändare vetja!');
				event.preventDefault();
			} else {
				$("#carouselExampleIndicatorsButton").html("Välj mottagare");
			}
		} else if (event.from === 1) {
			if( $('#insandare-from').val().length < 5 ) {
				alert('Lite för kort avsändare va?');
				event.preventDefault();
			} else {
				$("#carouselExampleIndicatorsButton").html("Välj mottagare");
			}
			$("#carouselExampleIndicatorsButton").html("Skicka!");
		} else if (event.from === 2) {
			if( $('#carouselExampleIndicators input[type=checkbox]:checked').length === 0 ) {
				event.preventDefault();
				alert('Välj minst en mottagare!');
			} else {
				var form_data = $('#insandare-form').serialize();
				jQuery.post(
					insandarmaskinen.ajax_url,
					{ action: "schedule_mails", form_data: form_data },
					function(data) {
						if ( data.error == false ) {
							$('#carousel-footer').remove();
						} else {
							event.preventDefault();
							alert('Oj, något gick fel!');
						}
					}
				).fail(function() {
					event.preventDefault();
					alert('Oj, något gick fel!');
				});
			}
		} else {
			$("#carouselExampleIndicatorsButton").html("Välj avsändare");
		}
	});

	$(".accordion-head input[type=checkbox]").on("click", function(event) {
		if (this.checked) {
			$(this)
				.parents(".accordion")
				.find(".collapse input[type=checkbox]")
				.prop("checked", true);
		} else {
			$(this)
				.parents(".accordion")
				.find(".collapse input[type=checkbox]")
				.prop("checked", false);
		}
	});

	$('.accordion').on('hidden.bs.collapse', function (event) {
	  $(event.currentTarget).removeClass('open');
	});

	$('.accordion').on('show.bs.collapse', function (event) {
	  $(event.currentTarget).addClass('open');
	});

	if (document.getElementById("tags")) {
		$("#tags").on("click", "li:eq(2)", function() {
			$("#tags").addClass("open");
		});
		$("#tags").on("focus", ".taggle_input", function() {
			$("#tags").addClass("open");
		});
		var publications = $("#tags").data("publications");
		var post_id = $("#tags").data("post");
		var tags = new Taggle("tags", {
			placeholder: "Lägg till publicering...",
			allowedTags: insandarmaskinen.papers,
			allowDuplicates: false,
			preserveCase: true,
			clearOnBlur: true,
			tags: publications,
			onTagAdd: function(event, tag) {
				jQuery.post(
					insandarmaskinen.ajax_url,
					{ action: "set_publication", post_id: post_id, name: tag },
					function(data) {
						console.log(data.success);
					}
				);
			},
			onTagRemove: function(event, tag) {
				jQuery.post(
					insandarmaskinen.ajax_url,
					{
						action: "delete_publication",
						post_id: post_id,
						name: tag
					},
					function(data) {
						console.log(data.success);
					}
				);
			}
		});
		var container = tags.getContainer();
		var input = tags.getInput();

		$(input).autocomplete({
			source: insandarmaskinen.papers, // See jQuery UI documentaton for options
			appendTo: container,
			minLength: 3,
			position: { at: "left bottom", of: container },
			select: function(event, data) {
				event.preventDefault();
				//Add the tag if user clicks
				if (event.which === 1) {
					tags.add(data.item.value);
				}
			}
		});
	}

	var data = {
		action: "last_month_stats"
	};

	var chart = document.getElementById("myChart");
	if (chart) {
		// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		$.post(ajaxurl, data, function(response) {
			var last_months = response.slice(1, 7),
				labels = [],
				data = [];
			last_months.reverse();
			last_months.map(function(month) {
				labels.push(month.month + " " + month.year);
				data.push(month.posts);
			});
			initChart(labels, data);
		});

		function initChart(labels, data) {
			var myChart = new Chart(chart, {
				type: "line",
				data: {
					labels: labels,
					datasets: [
						{
							data: data,
							fill: false,
							steppedLine: false,
							borderColor: "#ed6b4e",
							borderWidth: 5,
							pointBorderWidth: 5,
							pointBorderColor: "#ed6b4e",
							pointBackgroundColor: "#ffffff",
							pointRadius: 5,
							lineTension: 0.5,
							cubicInterpolationMode: "default"
						}
					]
				},
				options: {
					layout: {
						padding: 10
					},
					legend: {
						display: false
					},
					tooltips: {
						enabled: true,
						xPadding: 18,
						yPadding: 9,
						titleFontSize: 18,
						titleFontFamily: "Roboto",
						bodyFontSize: 14.4,
						displayColors: false
					},
					scales: {
						xAxes: [
							{
								display: false
							}
						],
						yAxes: [
							{
								display: false
							}
						]
					}
				}
			});
		}
	}
})(jQuery);


var string_to_slug = function (str)
{
	str = str.replace(/^\s+|\s+$/g, ''); // trim
	str = str.toLowerCase();

	// remove accents, swap ñ for n, etc
	var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
	var to   = "aaaaeeeeiiiioooouuuunc------";

	for (var i=0, l=from.length ; i<l ; i++)
	{
		str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
	}

	str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
		.replace(/\s+/g, '-') // collapse whitespace and replace by -
		.replace(/-+/g, '-'); // collapse dashes

	return str;
}
