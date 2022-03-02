@extends('layouts.app')

@section('content')
<h2 class="mx-auto text-center under mt-4 mb-5" style="width:10em">記録</h2>

<div class="container-calendar" hidden>
    <h4 id="monthAndYear"></h4>
    <table class="table-calendar" id="calendar" data-lang="ja">
        <thead id="thead-month"></thead>
        <tbody id="calendar-body"></tbody>
    </table>
</div>

<!--表示する月の記録を選択-->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-3 text-right">
            <form method="POST" action="/records">
                @csrf
                <button id="previous" class="diet-button button-container-calendar" type="submit" name="previous" value="previous" style="font-size:25px;">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </form>
        </div>
        <div class="col-6 text-center position-relative" style="bottom:30px;">
            <p class="heading-color">{{$user->filtering_year}}年</p>
            <h2>{{$user->filtering_month}}月</h2>
        </div>
        <div class="col-3 text-left">
            <form method="POST" action="/records">
                @csrf
                @if($user->filtering_month >= $carbon->format('n'))
                    <button id="next" class="diet-button button-container-calendar" type="submit" name="next" value="next" style="font-size:25px;" disabled>
                        <i class="fas fa-chevron-right"></i>
                    </button>
                @else    
                    <button id="next" class="diet-button button-container-calendar" type="submit" name="next" value="next" style="font-size:25px;">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                @endif
            </form>
        </div>
    </div>
</div>
              
<!--セレクトボックスで表示する月の記録を選択-->
<div class=" text-center footer-container-calendar">
    <form method="POST" action="/records">
        @csrf
        <p class="list-arrow-sub">日付指定</p>
        <br>
        <select name="month" id="month" onchange="jump()">
            <option value="0">1</option>
            <option value="1">2</option>
            <option value="2">3</option>
            <option value="3">4</option>
            <option value="4">5</option>
            <option value="5">6</option>
            <option value="6">7</option>
            <option value="7">8</option>
            <option value="8">9</option>
            <option value="9">10</option>
            <option value="10">11</option>
            <option value="11">12</option>
        </select>月
        <select name="year" id="year" onchange="jump()"></select>年
        <button type="submit" name="submit" class="diet-button diet-button-enter">選択</button>
    </form>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        @foreach($records as $record)
            @if($user->filtering_year."年".$user->filtering_month."月" == $record->post_at->format('Y年n月'))
                <p class="list-arrow-sub position-relative" style="left:4vw;">{{$record->post_at->format('n月j日')}}</p>
                <table style="width: 100%;">
                    <tr>
                        <th class="text-center heading-color" style="width: 50%;">体重</th>
                        <th class="text-center heading-color" style="width: 50%;">体脂肪率</th>
                    </tr>
                    <tr>
                        <td class="text-center" style="font-size:clamp(25px,7vw,50px);">{{$record->weight}}<span style="font-size:clamp(18px,3vw,30px);">kg</span></td>
                        <td class="text-center" style="font-size:clamp(25px,7vw,50px);">
                            @if($record->body_fat_percentage !== null)
                                {{$record->body_fat_percentage}}<span style="font-size:clamp(18px,3vw,30px);">%</span>
                            @elseif($record->body_fat_percentage === null)
                                --<span class="unit">%</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('records.show', $record->id) }}">    
                                <i class="fas fa-chevron-right diet-button diet-button-enter" style="width:50px; height:50px; line-height:35px;"></i>
                            </a>
                        </td>
                    </tr>
                </table>
                <div class="mt-4 mb-4" style="border-bottom: 1px solid #ffb900;"></div>
            @endif
        @endforeach
    </div>
</div>

<!--表示したい月の処理-->
<script>
    function generate_year_range(start, end) {
        var years = "";
        for (var year = start; year <= end; year++) {
            years += "<option value='" + year + "'>" + year + "</option>";
        }
        return years;
    }
    
    var today = new Date();
    var currentMonth = today.getMonth();
    var currentYear = today.getFullYear();
    var selectYear = document.getElementById("year");
    var selectMonth = document.getElementById("month");
    
    // セレクトボックスで選択できる年
    var createYear = generate_year_range(1970, 2200);
    
    document.getElementById("year").innerHTML = createYear;
    
    var calendar = document.getElementById("calendar");
    var lang = calendar.getAttribute('data-lang');
    
    var months = ["1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"];
    var days = ["日", "月", "火", "水", "木", "金", "土"];
    
    var dayHeader = "<tr>";
    for (day in days) {
        dayHeader += "<th data-days='" + days[day] + "'>" + days[day] + "</th>";
    }
    dayHeader += "</tr>";
    
    document.getElementById("thead-month").innerHTML = dayHeader;
    
    monthAndYear = document.getElementById("monthAndYear");
    
    showCalendar(currentMonth, currentYear);
    
    // 次の月を表示
    function next() {
        currentYear = (currentMonth === 11) ? currentYear + 1 : currentYear;
        currentMonth = (currentMonth + 1) % 12;
        showCalendar(currentMonth, currentYear);
    }
    
    // 前の月を表示
    function previous() {
        currentYear = (currentMonth === 0) ? currentYear - 1 : currentYear;
        currentMonth = (currentMonth === 0) ? 11 : currentMonth - 1;
        showCalendar(currentMonth, currentYear);
    }
    
    // セレクトボックスで月を表示
    function jump() {
        currentYear = parseInt(selectYear.value);
        currentMonth = parseInt(selectMonth.value);
        showCalendar(currentMonth, currentYear);
    }
    
    // 表示される年月を処理
    function showCalendar(month, year) {
    
        var firstDay = ( new Date( year, month ) ).getDay();
    
        tbl = document.getElementById("calendar-body");
    
        tbl.innerHTML = "";
      
        monthAndYear.innerHTML = year + "年" + " " + months[month];
        selectYear.value = year;
        selectMonth.value = month;
        
        var postAtMonthOnly = @json($postAtMonthOnly);

        fMonthsHtml = postAtMonthOnly.filter(monthHtml => monthHtml == months[month]);
        
        var s = '';
        fMonthsHtml.forEach(postAt => { s += `<p>${postAt}</p>`; });
        
        document.getElementById("test-head").innerHTML = s;
    }
</script>
@endsection