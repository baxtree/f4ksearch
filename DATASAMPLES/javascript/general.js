$(document).ready(function () {
	$("#tabs").tabs();
		$("#startday").datepicker({ 
			"dateFormat" : "dd/mm/yy",
			"defaultDate": new Date(Date.parse("10/01/2010"))
		});
		$("#stopday").datepicker({ 
			"dateFormat" : "dd/mm/yy",
			"defaultDate": new Date(Date.parse("07/31/2013"))
		});
		$("#fulldate").datepicker({ 
			"dateFormat" : "dd/mm/yy"
		});
		$(".multiselect").multiselect({
 			"noneSelectedText" : "Select sites and cameras",
 			"classes" : "checkbox",
 			"selectedList" : 3
		});
		$(".singleselect").multiselect({
			"multiple" : false,
			"classes" : "radio",
			"header" : "Hour : Min",
			"noneSelectedText" : "Select a time",
			"selectedList" : 3

		});
		$(".filename:odd").addClass("odd");
});