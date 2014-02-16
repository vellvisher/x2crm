(function() {
	//more button
	function step_1() {
		if (endsWith(window.location.pathname, "index.php/site/whatsNew")) {
			console.log("trying step 1");
			$("#more-menu").popover({
				placement: "bottom",
				trigger: "manual",
				title: "Step 1",
				content: "Click here to change your calendar permssions"
			});

			//hide popover
			$($("#more-menu").children()[0]).click(function() {
				$('#more-menu').popover("hide");
				step_2();
			});

			//check if calendar is visible..then show immediately
			//using setTimeout for now..later onclick
			setTimeout(function() {
				$('#more-menu').popover("show");
			}, 1000);
		}
	}
	//calendar button
	function step_2() {
		if (endsWith(window.location.pathname, "index.php/site/whatsNew")) {
			console.log("trying step 2");
			var $item = $("#more-menu").find("[data-title='calendar']");
			var $link = $($item.children()[0]);
			var linkName = $link.attr("href");
			$link.attr("href", linkName + "?tour=true");
			$item.popover({
				placement: "right",
				trigger: "manual",
				title: "Step 2",
				content: "Click here to change your calendar permssions"
			});
			$item.popover("show");
		}
	}

	function step_3() {
		if (endsWith(window.location.pathname, "index.php/calendar/index")) {
			if (getParameterByName("tour") == "true") {
				console.log("trying step 3");
				var $elem = $('#actions').find('a[href$="index.php/calendar/myCalendarPermissions"]');
				var linkName = $elem.attr("href");
				$elem.attr("href", linkName + "?tour=true");
				$elem.popover({
					placement: "right",
					trigger: "manual",
					title: "Step 3",
					content: "Click here to change your calendar permssions"
				});
				$elem.popover("show");
			}
		}
	}

	function step_4() {
		if (endsWith(window.location.pathname, "index.php/calendar/myCalendarPermissions")) {
			if (getParameterByName("tour") == "true") {
				console.log("trying step 4");
				var $elem = $("#save-button");
				console.log($elem);
				$elem.popover({
					placement: "right",
					trigger: "manual",
					title: "Step 4",
					content: "Click here to save your calendar permssions"
				});
				$elem.popover("show");
			}
		}
	}
	$(document).ready(function() {
		step_1();
		step_3();
		setTimeout(step_4, 100);
	});



	//utility functions
	function getParameterByName(name) {
		name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
		var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
			results = regex.exec(location.search);
		return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	}

	function endsWith(str, suffix) {
		return str.indexOf(suffix, str.length - suffix.length) !== -1;
	}

})();