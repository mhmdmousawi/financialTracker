
<h3 class="col-xs-12 col-lg-12 text-center">Top 10 Savings</h3>
<hr class="col-xs-12 col-lg-12">
<div class="topten_div col-xs-12">
    
    <div class="col-xs-12 col-lg-7">
        <div class="btn-group titles titles-dashboard" role="group" aria-label="...">
        <input class="btn btn-default" type='button' name="doughnut" id="chart_pie_saving" value="Doughnut"/>
        <input class="btn btn-default" type='button' name="bar" id="chart_bar_saving" value="Bar"/>
        </div>
        <div id="chart_div_saving">
            <canvas id="chart_canvas_saving"></canvas>
        </div>
        <p type="hidden" id="no_data_saving" value="No Data to Display">No Data to Display</p>
        <input type="hidden" id="stat_lables_saving" value="{{ implode(',', $user->stat_categories_info_saving[0] )}}"/>
        <input type="hidden" id="stat_data_saving" value="{{ implode(',', $user->stat_categories_info_saving[1] )}}"/>
    </div>

     <div class="transactions col-xs-12 col-lg-5">
         <p class="col-xs-12 col-lg-5 text-info">Savings:</p>
         @foreach(($user->saving_transactions) as $saving)
                <div class="col-xs-12 col-lg-12 transaction_card">
                    <div class="card-counter primary">
                        <span class="col-xs-5 col-lg-6 count-name">{{$saving->title}}</span>
                        <span class="col-xs-2 col-lg-2 logo {{$saving->category->logo->class_name}}"></span>
                        <span class="col-xs-5 col-lg-4 count-numbers">{{$saving->currency->code}} {{$saving->amount}}</span>
                    </div>
                </div>
         @endforeach
     </div>
</div>
