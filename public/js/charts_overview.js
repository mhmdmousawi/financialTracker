var COLORS = {
    colors : [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)'
    ],
    border_colors : [
        'rgba(255,99,132,1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
    ],
}

var ELEMENTS = {
    //for income
    no_data_income : document.getElementById('no_data_income'),
    chart_canvas_income : document.getElementById('chart_canvas_income'),
    stat_lables_income : document.getElementById('stat_lables_income'),
    stat_data_income : document.getElementById('stat_data_income'),
    chart_type_income : document.getElementById('chart_type_income'),
    chart_pie_income : document.getElementById('chart_pie_income'),
    chart_bar_income : document.getElementById('chart_bar_income'),
    chart_div_income : document.getElementById('chart_div_income'),
    //for expense
    no_data_expense : document.getElementById('no_data_expense'),
    chart_canvas_expense : document.getElementById('chart_canvas_expense'),
    stat_lables_expense : document.getElementById('stat_lables_expense'),
    stat_data_expense : document.getElementById('stat_data_expense'),
    chart_type_expense : document.getElementById('chart_type_expense'),
    chart_pie_expense : document.getElementById('chart_pie_expense'),
    chart_bar_expense : document.getElementById('chart_bar_expense'),
    chart_div_expense : document.getElementById('chart_div_expense'),
    //for expense
    no_data_saving : document.getElementById('no_data_saving'),
    chart_canvas_saving : document.getElementById('chart_canvas_saving'),
    stat_lables_saving : document.getElementById('stat_lables_saving'),
    stat_data_saving : document.getElementById('stat_data_saving'),
    chart_type_saving : document.getElementById('chart_type_saving'),
    chart_pie_saving : document.getElementById('chart_pie_saving'),
    chart_bar_saving : document.getElementById('chart_bar_saving'),
    chart_div_saving : document.getElementById('chart_div_saving'),
}


var CHART_INCOME = {
    ctx : ELEMENTS.chart_canvas_income.getContext('2d'),
    my_labels_income : ELEMENTS.stat_lables_income.value,
    my_data_income : ELEMENTS.stat_data_income.value,
    my_labels_array_income : [],
    my_data_array_income : [],
    my_chart_type_income : "doughnut",
    my_chart_data_income : {},
    my_char_options_income: {},
    my_chart_attr_income : {},
    my_chart_income : {},

    setUp : function (){
        this.my_labels_array_income = this.my_labels_income.split(",");
        this.my_data_array_income = this.my_data_income.split(",");
        this.my_chart_data_income = {
            labels: this.my_labels_array_income,
            datasets: [{
                label: 'Amount per Category',
                data: this.my_data_array_income,
                backgroundColor: COLORS.colors,
                borderColor: COLORS.border_colors,
                borderWidth: 1
            }]
        };
        if(this.my_chart_type_income == "bar"){
            this.my_char_options_income = {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            };
        }else{
            this.my_char_options_income = {};
        }
    },
    changeTo : function(type){
        ELEMENTS.chart_div_income.innerHTML = "";
        let new_canvas = document.createElement("canvas");
        new_canvas.setAttribute('id', "chart_canvas_income");
        ELEMENTS.chart_div_income.appendChild(new_canvas);
        this.ctx = new_canvas.getContext('2d');
        this.my_chart_type_income = type;
        this.init();
    },
    changeType : function(btn){
        if(btn.name == "bar"){
            this.changeTo("bar");
        }else if(btn.name == "doughnut"){
            this.changeTo("doughnut");
        }else{
            console.log("Don't mess with html elements..");
        }
    },
    addEvents(){
        ELEMENTS.chart_bar_income.addEventListener('click',this.changeType.bind(this,ELEMENTS.chart_bar_income));
        ELEMENTS.chart_pie_income.addEventListener('click',this.changeType.bind(this,ELEMENTS.chart_pie_income));
    },
    init : function(){
        this.setUp();
        
        if(this.my_labels_array_income === undefined || this.my_labels_array_income.length == 0){
            ELEMENTS.chart_canvas_income.style.display="none";
        }else{

            ELEMENTS.no_data_income.style.display="none";
            this.my_chart_attr_income = {
                type: this.my_chart_type_income,
                data: this.my_chart_data_income,
                options: this.my_char_options_income,
            };
            this.my_chart_income = new Chart(this.ctx, this.my_chart_attr_income);
            
        }
    }
}
var CHART_EXPENSE = {
    ctx : ELEMENTS.chart_canvas_expense.getContext('2d'),
    my_labels_expense : ELEMENTS.stat_lables_expense.value,
    my_data_expense : ELEMENTS.stat_data_expense.value,
    my_labels_array_expense : [],
    my_data_array_expense : [],
    my_chart_type_expense : "doughnut",
    my_chart_data_expense : {},
    my_char_options_expense: {},
    my_chart_attr_expense : {},
    my_chart_expense : {},

    setUp : function (){
        this.my_labels_array_expense = this.my_labels_expense.split(",");
        this.my_data_array_expense = this.my_data_expense.split(",");
        this.my_chart_data_expense = {
            labels: this.my_labels_array_expense,
            datasets: [{
                label: 'Amount per Category',
                data: this.my_data_array_expense,
                backgroundColor: COLORS.colors,
                borderColor: COLORS.border_colors,
                borderWidth: 1
            }]
        };
        if(this.my_chart_type_expense == "bar"){
            this.my_char_options_expense = {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            };
        }else{
            this.my_char_options_expense = {};
        }
    },
    changeTo : function(type){
        ELEMENTS.chart_div_expense.innerHTML = "";
        let new_canvas = document.createElement("canvas");
        new_canvas.setAttribute('id', "chart_canvas_expense");
        ELEMENTS.chart_div_expense.appendChild(new_canvas);
        this.ctx = new_canvas.getContext('2d');
        this.my_chart_type_expense = type;
        this.init();
    },
    changeType : function(btn){
        if(btn.name == "bar"){
            this.changeTo("bar");
        }else if(btn.name == "doughnut"){
            this.changeTo("doughnut");
        }else{
            console.log("Don't mess with html elements..");
        }
    },
    addEvents(){
        ELEMENTS.chart_bar_expense.addEventListener('click',this.changeType.bind(this,ELEMENTS.chart_bar_expense));
        ELEMENTS.chart_pie_expense.addEventListener('click',this.changeType.bind(this,ELEMENTS.chart_pie_expense));
    },
    init : function(){
        this.setUp();
        
        if(this.my_labels_array_expense === undefined || this.my_labels_array_expense.length == 0){
            ELEMENTS.chart_canvas_expense.style.display="none";
        }else{

            ELEMENTS.no_data_expense.style.display="none";
            this.my_chart_attr_expense = {
                type: this.my_chart_type_expense,
                data: this.my_chart_data_expense,
                options: this.my_char_options_expense,
            };
            this.my_chart_expense = new Chart(this.ctx, this.my_chart_attr_expense);
            
        }
    }
}
var CHART_SAVING = {
    ctx : ELEMENTS.chart_canvas_saving.getContext('2d'),
    my_labels_saving : ELEMENTS.stat_lables_saving.value,
    my_data_saving : ELEMENTS.stat_data_saving.value,
    my_labels_array_saving : [],
    my_data_array_saving : [],
    my_chart_type_saving : "doughnut",
    my_chart_data_saving : {},
    my_char_options_saving: {},
    my_chart_attr_saving : {},
    my_chart_saving : {},

    setUp : function (){
        this.my_labels_array_saving = this.my_labels_saving.split(",");
        this.my_data_array_saving = this.my_data_saving.split(",");
        this.my_chart_data_saving = {
            labels: this.my_labels_array_saving,
            datasets: [{
                label: 'Amount per Category',
                data: this.my_data_array_saving,
                backgroundColor: COLORS.colors,
                borderColor: COLORS.border_colors,
                borderWidth: 1
            }]
        };
        if(this.my_chart_type_saving == "bar"){
            this.my_char_options_saving = {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            };
        }else{
            this.my_char_options_saving = {};
        }
    },
    changeTo : function(type){
        ELEMENTS.chart_div_saving.innerHTML = "";
        let new_canvas = document.createElement("canvas");
        new_canvas.setAttribute('id', "chart_canvas_saving");
        ELEMENTS.chart_div_saving.appendChild(new_canvas);
        this.ctx = new_canvas.getContext('2d');
        this.my_chart_type_saving = type;
        this.init();
    },
    changeType : function(btn){
        if(btn.name == "bar"){
            this.changeTo("bar");
        }else if(btn.name == "doughnut"){
            this.changeTo("doughnut");
        }else{
            console.log("Don't mess with html elements..");
        }
    },
    addEvents(){
        ELEMENTS.chart_bar_saving.addEventListener('click',this.changeType.bind(this,ELEMENTS.chart_bar_saving));
        ELEMENTS.chart_pie_saving.addEventListener('click',this.changeType.bind(this,ELEMENTS.chart_pie_saving));
    },
    init : function(){
        this.setUp();
        
        if(this.my_labels_array_saving === undefined || this.my_labels_array_saving.length == 0){
            ELEMENTS.chart_canvas_saving.style.display="none";
        }else{

            ELEMENTS.no_data_saving.style.display="none";
            this.my_chart_attr_saving = {
                type: this.my_chart_type_saving,
                data: this.my_chart_data_saving,
                options: this.my_char_options_saving,
            };
            this.my_chart_saving = new Chart(this.ctx, this.my_chart_attr_saving);
            
        }
    }
}
window.addEventListener('load',function(){

    chart_income = Object.create(CHART_INCOME);
    chart_income.addEvents();
    chart_income.init();  

    chart_expense = Object.create(CHART_EXPENSE);
    chart_expense.addEvents();
    chart_expense.init();  

    chart_saving = Object.create(CHART_SAVING);
    chart_saving.addEvents();
    chart_saving.init();  
 
});