function init_select(group){
    var selections = [];
    $('select[ref="'+group+'"] option:selected').each(function(){
        if($(this).val() && $(this).val() != 0)
            selections.push($(this).val());
    });
     //alert(selections );
     $('select[ref="'+group+'"] option').each(function() {
         $(this).attr('disabled', $.inArray($(this).val(),selections)>-1 && !$(this).is(":selected"));
      });
	  //console.log(group);
}

$(function(){
	
	
$('select').change(function() {
	var group = $(this).attr('ref');
    init_select(group);
});
$("span.required").remove();



});