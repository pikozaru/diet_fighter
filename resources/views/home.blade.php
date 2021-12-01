@extends('layouts.sign_in_app')

@section('sign_in_content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            
            <div class="text-center">
                <h2 class="mx-auto text-center under mt-5 mb-4" style="width:10em">本会員登録完了</h2>
            </div>
            
            <div class="card card-body">
                <div class="text-center">
                    <h5>ご登録ありがとうございます</h5>
                    <p>早速ホームで記録しましょう！</p>
                    <form method="POST" action="/home">
                        {{ csrf_field() }}
                        <button type="submit" class="btn diet-button diet-button-register w-75">ホームへ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
