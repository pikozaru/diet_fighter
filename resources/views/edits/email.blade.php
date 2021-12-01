@extends('layouts.app')

@section('content')
<h2 class="mx-auto text-center under mt-4 mb-5">変更画面</h2>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 text-center">
            <form method="POST" action="/emailEdits">
                {{ csrf_field() }}
                <input type="text" name="email" class="input-text w-100" autofocus placeholder="yusya@diet.com" value="{{old('email', $user->email)}}">
                <div class="text-center">    
                    <button type="button" class="diet-button diet-button-enter mt-4" data-toggle="modal" data-target="#modal1">変更</button>
                </div>
                    
                <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="label1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="text-center mt-4 mb-2 pb-1" id="label1">
                                <h4>変更しますか？</h4>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="diet-button diet-button-back" data-dismiss="modal">いいえ</button>
                                <button type="submit" class="diet-button diet-button-enter">はい</button>
                            </div>
                        </div>
                     </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection