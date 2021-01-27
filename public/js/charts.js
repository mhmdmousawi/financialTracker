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
    no_data : document.getElementById('no_data'),
    chart_canvas : document.getElementById('chart_canvas'),
    stat_lables : document.getElementById('stat_lables'),
    stat_data : document.getElementById('stat_data'),
    chart_type : document.getElementById('chart_type'),
    chart_pie : document.getElementById('chart_pie'),
    chart_bar : document.getElementById('chart_bar'),
    chart_div : document.getElementById('chart_div'),

    //for overview
    chart_canvas_income : document.getElementById('chart_canvas_income'),
    stat_lables_income : document.getElementById('stat_lables_income'),
    stat_data_income : document.getElementById('stat_data_income'),
    chart_type_income : document.getElementById('chart_type_income'),
    chart_pie_income : document.getElementById('chart_pie_income'),
    chart_bar_income : document.getElementById('chart_bar_income'),
    chart_div_income : document.getElementById('chart_div_income'),

    
}

var CHART = {
    ctx : ELEMENTS.chart_canvas.getContext('2d'),
    my_labels : ELEMENTS.stat_lables.value,
    my_data : ELEMENTS.stat_data.value,
    my_labels_array : [],
    my_data_array : [],
    my_chart_type : "bar",
    my_chart_data : {},
    my_char_options: {},
    my_chart_attr : {},
    my_chart : {},

    setUp : function (){
        this.my_labels_array = this.my_labels.split(",");
        this.my_data_array = this.my_data.split(",");
        this.my_chart_data = {
            labels: this.my_labels_array,
            datasets: [{
                label: 'Amount per Category',
                data: this.my_data_array,
                backgroundColor: COLORS.colors,
                borderColor: COLORS.border_colors,
                borderWidth: 1
            }]
        };
        if(this.my_chart_type == "bar"){
            this.my_char_options = {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            };
        }else{
            this.my_char_options = {};
        }
    },
    changeTo : function(type){
        ELEMENTS.chart_div.innerHTML = "";
        let new_canvas = document.createElement("canvas");
        new_canvas.setAttribute('id', "chart_canvas");
        ELEMENTS.chart_div.appendChild(new_canvas);
        this.ctx = new_canvas.getContext('2d');
        this.my_chart_type = type;
        this.init();
    },
    changeType : function(btn){
        if(btn.name == "bar"){
            this.changeTo("bar");
        }else if(btn.name == "pie"){
            this.changeTo("pie");
        }else{
            console.log("Don't mess with html elements..");
        }
    },
    addEvents(){
        ELEMENTS.chart_bar.addEventListener('click',this.changeType.bind(this,ELEMENTS.chart_bar));
        ELEMENTS.chart_pie.addEventListener('click',this.changeType.bind(this,ELEMENTS.chart_pie));
    },
    init : function(){
        this.setUp();
        
        if(this.my_labels_array === undefined || this.my_labels_array.length == 0){
            ELEMENTS.chart_canvas.style.display="none";
        }else{

            ELEMENTS.no_data.style.display="none";
            this.my_chart_attr = {
                type: this.my_chart_type,
                data: this.my_chart_data,
                options: this.my_char_options,
            };
            this.my_chart = new Chart(this.ctx, this.my_chart_attr);
            
        }
    }
}

window.addEventListener('load',function(){
    chart = Object.create(CHART);
    chart.addEvents();
    chart.init(); 
 
});
