
var ELEMENTS_REPEAT = {
    repeat_select : document.getElementById('repeat_select'),
    end_date_div : document.getElementById('end_date_div'),
}

var REPEAT = {

    displayEndDate : function(repeat_select){
        
        if(repeat_select.value != 1){
            console.log(ELEMENTS_REPEAT.end_date_div);
            ELEMENTS_REPEAT.end_date_div.style.display = "block";
        }else{
            ELEMENTS_REPEAT.end_date_div.style.display = "none";
        }  
    },
    init : function (){
        ELEMENTS_REPEAT.repeat_select.addEventListener('change',this.displayEndDate.bind(this,ELEMENTS_REPEAT.repeat_select));
    }
}

window.addEventListener('load',function(){
    repeat = Object.create(REPEAT);
    repeat.init(); 
 
});