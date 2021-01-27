var ELEMENTS_LOGO = {
    logo_divs : document.getElementsByName('logo_div'),
    logo_chosen_div : document.getElementById('logo_chosen_div'),
}

var LOGO = {
    choosingLogo : function(logo_div_clicked){
        ELEMENTS_LOGO.logo_chosen_div.innerHTML = logo_div_clicked.innerHTML;
    },
    init : function (){
        ELEMENTS_LOGO.logo_divs.forEach(logo_div => {
            logo_div.addEventListener('click',this.choosingLogo.bind(this,logo_div));
        });  
    }
}

window.addEventListener('load',function(){
    logo = Object.create(LOGO);
    logo.init(); 
});