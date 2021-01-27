var ELEMENTS_TYPE = {
    title_income : document.getElementById('title_income'),
    title_expense : document.getElementById('title_expense'),
    type_input : document.getElementById('type_input'),
}

var TYPE = {

    showOnly: function(type){
        
        ELEMENTS_CAT.category_divs.forEach(category_div => {
            if(category_div.dataset.categoryType == type){
                category_div.style.display = "block";
            }else{
                category_div.style.display = "none";
            }
        });
    },
    resetChosenCategory : function(){
        ELEMENTS_CAT.category_chosen_div.innerHTML = ''
        +'<div class="col-xs-4">'
        +'    <p class="col-xs-10" id="category_chosen_id">Click to choose your category  &nbsp;&nbsp;</p>'
        +'    <span class="col-xs-2 glyphicon glyphicon-piggy-bank" style="font-size:30px"></span>'
        +'    <input type="hidden" name="category_id" value=""/>'
        +'</div>';
    },
    changeToIncome : function(title_income){

        title_income.className += " active";
        ELEMENTS_TYPE.title_expense.classList.remove("active");
        ELEMENTS_TYPE.type_input.value = "income";
        this.showOnly("income");
        this.resetChosenCategory();

    },
    changeToExpense :function(title_expense){

        title_expense.className += " active";
        ELEMENTS_TYPE.title_income.classList.remove("active");
        ELEMENTS_TYPE.type_input.value = "expense";
        this.showOnly("expense");
        this.resetChosenCategory();

    },
    addEvents : function(){

    },
    init : function (){
        ELEMENTS_TYPE.title_income.addEventListener('click',this.changeToIncome.bind(this,ELEMENTS_TYPE.title_income));
        ELEMENTS_TYPE.title_expense.addEventListener('click',this.changeToExpense.bind(this,ELEMENTS_TYPE.title_expense));
    }
}

window.addEventListener('load',function(){
    type = Object.create(TYPE);
    type.init(); 
 
});