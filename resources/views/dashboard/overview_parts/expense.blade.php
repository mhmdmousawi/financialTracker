
<h3 class="col-xs-12 col-lg-12 text-center">Top 10 Expenses</h3>
<hr class="col-xs-12 col-lg-12">

<div class="topten_div col-xs-12">

    <div class="col-xs-12 col-lg-7">
        <div class="btn-group titles titles-dashboard" role="group" aria-label="...">
            <input class="btn btn-default" type='button' name="doughnut" id="chart_pie_expense" value="Doughnut"/>
            <input class="btn btn-default" type='button' name="bar" id="chart_bar_expense" value="Bar"/>
        </div>
        <div id="chart_div_expense">
            <canvas id="chart_canvas_expense"></canvas>
        </div>
        <p type="hidden" id="no_data_expense" value="No Data to Display">No Data to Display</p>
        <input type="hidden" id="stat_lables_expense" value="{{ implode(',', $user->stat_categories_info_expense[0] )}}"/>
        <input type="hidden" id="stat_data_expense" value="{{ implode(',', $user->stat_categories_info_expense[1] )}}"/>
    </div>

    <div class="transactions col-xs-12 col-lg-5">
         <p class="col-xs-12 col-lg-5 text-info">Expenses:</p>
         @foreach(($user->expense_transactions) as $expense)
             <a href="{{config('app.url')}}/edit/transaction/{{$expense->id}}">
                <div class="col-xs-12 col-lg-12 transaction_card">
                    <div class="card-counter primary">
                        {{-- <i class="fa fa-code-fork"></i> --}}
                        <span class="col-xs-5 col-lg-6 count-name">{{$expense->title}}</span>
                        <span class="col-xs-2 col-lg-2 logo {{$expense->category->logo->class_name}}"></span>
                        <span class="col-xs-5 col-lg-4 count-numbers">{{$expense->currency->code}} {{$expense->amount}}</span>
                    </div>
                </div>
            </a>
         @endforeach
     </div>
     

    
</div>