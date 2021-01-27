var ELEMENTS_CAT = {
    category_divs : document.getElementsByName('category_div'),
    category_chosen_div : document.getElementById('category_chosen_div'),
}

var CATEGORY = {
    choosingCategory : function(category_div_clicked){
        category_id = category_div_clicked.id;
        ELEMENTS_CAT.category_chosen_div.innerHTML = category_div_clicked.innerHTML;
    },
    init : function (){
        ELEMENTS_CAT.category_divs.forEach(category_div => {
            category_div.addEventListener('click',this.choosingCategory.bind(this,category_div));
        });  
    }
}

window.addEventListener('load',function(){
    category = Object.create(CATEGORY);
    category.init(); 
 
});