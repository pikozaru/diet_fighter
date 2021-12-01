@extends('layouts.app')

@section('content')
<h2 class="mx-auto text-center under mt-4 mb-5" style="width:10em">アイテム一覧</h2>

<div class="ml-3 mr-3">
    @foreach($possessionItems as $possessionItem)
        <div class="card card-body mb-1 shadow-sm">
            <div class="text-center">
                <h3 class="mb-4">{{$possessionItem->item->name}}</h3>
            </div>
            <div class="container pt-4" style="border-top:solid 2px #ffcb42;">
                <div class="text-center">
                    <p class="list-arrow-sub">{{$possessionItem->item->description}}</p>
                    <p>所持数：{{$possessionItem->possession_number}}/ {{$possessionItem->item->max_possession_number}}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection