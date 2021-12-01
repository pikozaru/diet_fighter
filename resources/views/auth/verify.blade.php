@extends('layouts.sign_in_app')

@section('sign_in_content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h3 class="mx-auto text-center under mt-3 mb-3" style="width:10em">仮登録完了！</h3>

            <div class="card card-body">
                <div class="text-center">    
                    <h5><b>登録ありがとうございました</b></h5>
                </div>
                <p>ご登録頂いたメールアドレスに会員登録完了メールを送信しました。</p>
                <p>メールを確認して、本登録を完了させてください。</p>
                <form class="d-inline text-center" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="btn diet-button diet-button-register">メールを再送信</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
