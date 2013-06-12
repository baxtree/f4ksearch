$(document).ready(function () {
	$("#tabs").tabs();
		$("#startday").datepicker({ 
			"dateFormat" : "dd/mm/yy",
			"defaultDate": new Date(Date.parse("10/01/2010")),
			"position" : {
	 			"collision" : "flip"
 			}

		});
		$("#stopday").datepicker({ 
			"dateFormat" : "dd/mm/yy",
			"defaultDate": new Date(Date.parse("07/31/2013")),
			"position" : {
	 			"collision" : "flip"
 			}

		});
		$("#fulldate").datepicker({ 
			"dateFormat" : "dd/mm/yy",
			"position" : {
	 			"collision" : "flip"
 			}

		});
		$(".multiselect").multiselect({
 			"noneSelectedText" : "Select sites and cameras",
 			"classes" : "checkbox",
 			"selectedList" : 3,
 			"position" : {
	 			"collision" : "flip"
 			}
		});
		$(".singleselect").multiselect({
			"multiple" : false,
			"classes" : "radio",
			"header" : "Hour : Min",
			"noneSelectedText" : "Select a time",
			"selectedList" : 3,
			"position" : {
				"collision" : "flip"
			}

		});
		$(".filename:odd").addClass("odd");
});