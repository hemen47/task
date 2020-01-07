@extends('master')

@section('content')
    <form action="/save" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="amount">مبلغ</label>
            <input type="number" name="amount" class="form-control" id="amount"
                   placeholder="لطفا مبلغ مورد نظر را وارد کنید">
        </div>
        <div class="form-group">
            <label for="receiver">لطفا اسم شخص مورد نظر را انتخاب کنید</label>
            <select class="form-control" id="receiver" name="receiver" >
                @foreach ($receivers as $receiver)
                    <option value="{{$receiver->id}}">{{$receiver->name}}</option>.
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="description">توضیحات</label>
            <textarea class="form-control" id="description" rows="3" name="description" ></textarea>
        </div>
        <button type="submit" class="btn btn-primary">ارسال فاکتور</button>

    </form>

    @if (Session::has('msg'))
        <div class="alert alert-success mt-4">{{ Session::get('msg') }}</div>
    @endif


@endsection
