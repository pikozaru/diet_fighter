@extends('layouts.app')

@section('content')
<div class="card mt-4 mb-1">
    <div class="card-body shadow-sm">
        <div class="container">
            <h4 class="text-center heading-color under mb-3">{{$record->post_at->format('n/d')}}</h4>
            <!--その日の記録-->
            <div class="row justify-content-center d-flex align-items-start">
                <div class="col-3 text-center">
                    <p class="heading-color">BMI</p>
                    <b class="side-number">{{$record->bmi}}</b>
                    <p style="font-size:15px;"></p>
                </div>
                <div class="col-6 text-center">
                    <p class="heading-color">体重</p>
                    <b class="weight-number">{{$record->weight}}</b>
                    <b class="unit">kg</b>
                </div>
                <div class="col-3 text-center">
                    <p class="heading-color">体脂肪率</p>
                    @if($record == null or $record->body_fat_percentage == null)
                        <b class="side-number">--</b>
                    @else
                        <b class="side-number">{{$record->body_fat_percentage}}</b>
                    @endif
                    <b style="font-size:15px;">%</b>
                </div>
            </div>
            
            <!--その日の前日の記録と比較-->
            <div class="text-center">
                <p class="list-arrow-sub mt-4">前回と比較</p>
            </div>
            <div class="row justify-content-center d-flex align-items-start">
                <div class="col-3 text-center">
                    @if($bmiSub > 0)
                        <b class="number-sub" style="color: #EF454A;">+{{$bmiSub}}</b>
                    @elseif($bmiSub == 0)
                        <b class="heading-color number-sub">±0</b>
                    @elseif($bmiSub < 0)
                        <b class="number-sub" style="color: #66cdaa;">{{$bmiSub}}</b>
                    @endif
                </div>
                <div class="col-6 text-center">
                    @if($weightSub > 0)
                        <b class="number-sub" style="color: #EF454A;">+{{$weightSub}}kg</b>
                    @elseif($weightSub == 0)
                        <b class="heading-color number-sub">±0kg</b>
                    @elseif($weightSub < 0)
                        <b class="number-sub" style="color: #66cdaa;">{{$weightSub}}kg</b>
                    @endif
                </div>
                <div class="col-3 text-center">
                    @if($bodyFatPercentageSub > 0)
                        <b class="number-sub" style="color: #EF454A;">+{{$bodyFatPercentageSub}}%</b>
                    @elseif($bodyFatPercentageSub == 0)
                        <b class="heading-color number-sub">±0%</b>
                    @elseif($bodyFatPercentageSub < 0)
                        <b class="number-sub" style="color: #66cdaa;">{{$bodyFatPercentageSub}}%</b>
                    @endif
                </div>
            </div>
            
            <!--本日の記録と比較-->
            <div class="text-center mt-3">
                @if($recordNow->post_at->format('Y/m/d') == $carbonJapaneseNotation)
                    <p class="list-arrow-sub">本日と比較</p>
                @else
                    <p class="list-arrow-sub">{{$recordNow->post_at->format('n/d')}}と比較</p>
                @endif
            </div>
            <div class="row justify-content-center d-flex align-items-start">
                <div class="col-3 text-center">
                    @if($bmiSubNow > 0)
                        <b class="number-sub" style="color: #EF454A;">+{{$bmiSubNow}}</b>
                    @elseif($bmiSubNow == 0)
                        <b class="heading-color number-sub">±0</b>
                    @elseif($bmiSubNow < 0)
                        <b class="number-sub" style="color: #66cdaa;">{{$bmiSubNow}}</b>
                    @endif
                </div>
                <div class="col-6 text-center">
                    @if($weightSubNow > 0)
                        <b class="number-sub" style="color: #EF454A;">+{{$weightSubNow}}kg</b>
                    @elseif($weightSubNow == 0)
                        <b class="heading-color number-sub">±0kg</b>
                    @elseif($weightSubNow < 0)
                        <b class="number-sub" style="color: #66cdaa;">{{$weightSubNow}}kg</b>
                    @endif
                </div>
                <div class="col-3 text-center">
                    @if($bodyFatPercentageSubNow > 0)
                        <b class="number-sub" style="color: #EF454A;">+{{$bodyFatPercentageSubNow}}%</b>
                    @elseif($bodyFatPercentageSubNow == 0)
                        <b class="heading-color number-sub">±0%</b>
                    @elseif($bodyFatPercentageSubNow < 0)
                        <b class="number-sub" style="color: #66cdaa;">{{$bodyFatPercentageSubNow}}%</b>
                    @endif
                </div>
            </div>
            <div class="text-center">
                <a class="btn diet-button diet-button-back w-50 mt-3" href="{{ route('records.index') }}">
                    <b>戻る</b>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection