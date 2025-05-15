
$(function (){

'use strick';
//triger the select box
$("select").selectBoxIt();
//Hide Plase Holder 
$("input").on('focus',function () {
    $place = $(this).attr("placeholder");
   $(this).attr("placeholder","");
  }).on("blur",function () {
    $(this).attr("placeholder",$place);
  });

$("input").each(function (){

if(($this).attr('required') === ('required')){

($this).after('<span class="asterisk">*</span>')

}


});

//confrmation button 


$('.confirm').click(function (){
return confirm('Are You Sure ?');

});


});
