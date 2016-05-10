
$(document).ready(function() {
		$('[placeholder]').placeholder();
		
		//$("ul.sf-menu").superfish();
        $("nav.main_menu ul").superfish(); 
		
		
		Nav_H = $("ul.footer_menu").parent().width();
		
		UL_H = $("ul.footer_menu").width();
		UL_ML = (Nav_H - UL_H)/2
		$("ul.footer_menu").css("margin-left", UL_ML)
	
	
		 $(".dropdown dt a").click(function() {
                $(".dropdown dd ul").toggle();
            });
                        
            $(".dropdown dd ul li a").click(function() {
                var text = $(this).html();
                $(".dropdown dt a span").html(text);
                $(".dropdown dd ul").hide();
                $("#result").html("Selected value is: " + getSelectedValue("sample"));
            });
                        
            function getSelectedValue(id) {
                return $("#" + id).find("dt a span.value").html();
            }

            $(document).bind('click', function(e) {
                var $clicked = $(e.target);
                if (! $clicked.parents().hasClass("dropdown"))
                    $(".dropdown dd ul").hide();
            });
			
			$(".dropdown_2 dt a").click(function() {
                $(".dropdown_2 dd ul").toggle();
            });
			
			$(".dropdown_2 dd ul li a").click(function() {
                var text = $(this).html();
                $(".dropdown_2 dt a span").html(text);
                $(".dropdown_2 dd ul").hide();
                $("#result").html("Selected value is: " + getSelectedValue("sample_2"));
            });
                        
            function getSelectedValue(id) {
                return $("#" + id).find("dt a span.value").html();
            }

            $(document).bind('click', function(e) {
                var $clicked = $(e.target);
                if (! $clicked.parents().hasClass("dropdown_2"))
                    $(".dropdown_2 dd ul").hide();
            });
		
	
}); 

