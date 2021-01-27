

<h3 class="col-xs-12 col-lg-12 text-center">Top 10 Incomes</h3>
<hr class="col-xs-12 col-lg-12">


<div class="topten_div col-xs-12 col-lg-12">

    <div class=" col-xs-12 col-lg-7 ">
       <div class="btn-group titles titles-dashboard" role="group" aria-label="...">
       <input class="btn btn-default" type='button' name="doughnut" id="chart_pie_income" value="Doughnut"/>
       <input class="btn btn-default" type='button' name="bar" id="chart_bar_income" value="Bar"/>
       </div>
       <div id="chart_div_income">
           <canvas id="chart_canvas_income"></canvas>
       </div>
       <p type="hidden" id="no_data_income" value="No Data to Display">No Data to Display</p>
       <input type="hidden" id="stat_lables_income" value="{{ implode(',', $user->stat_categories_info_income[0] )}}"/>
       <input type="hidden" id="stat_data_income" value="{{ implode(',', $user->stat_categories_info_income[1] )}}"/>
    </div>

    <div class="transactions col-xs-12 col-lg-5">
         <p class="col-xs-12 col-lg-5 text-info">Incomes:</p>
         @foreach(($user->income_transactions) as $income)
             <a href="{{config('app.url')}}/edit/transaction/{{$income->id}}">
                <div class="col-xs-12 col-lg-12 transaction_card">
                    <div class="card-counter primary">
                        <span class="col-xs-5 col-lg-6 count-name">{{$income->title}}</span>
                        <span class="col-xs-2 col-lg-2 logo {{$income->category->logo->class_name}}"></span>
                        <span class="col-xs-5 col-lg-4 count-numbers">{{$income->currency->code}} {{$income->amount}}</span>
                    </div>
                </div>
            </a>
         @endforeach
     </div>
     

    
</div>