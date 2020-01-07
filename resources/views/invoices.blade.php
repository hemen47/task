@extends('master')

@section('content')
    <div class="text-center mb-3">
        <a href="/">برای ثبت فاکتور جدید اینجا را کلیک کنید</a>
    </div>
    <div class="text-center">
        <button class="btn btn-primary">
            <a class="text-white" href="http://127.0.0.1:8000/invoices">کل فاکتورها</a>
        </button>
        <button class="btn btn-danger">
            <a class="text-white" href="http://127.0.0.1:8000/invoices?paid=false">پرداخت نشده</a>
        </button>
        <button class="btn btn-success">
            <a class="text-white" href="http://127.0.0.1:8000/invoices?paid=true">پرداخت شده</a>
        </button>

        <table class="table mt-3">
            <thead>
            <tr>
                <th scope="col">شماره‌فاکتور</th>
                <th scope="col">مبلغ</th>
                <th scope="col">توضیحات</th>
                <th scope="col">دریافت‌کننده</th>
                <th scope="col">شبا</th>
                <th scope="col">پرداخت‌‌‌‌‌شده</th>
            </tr>
            </thead>
            @foreach($data as $d)
                <tbody>
                <tr>
                    <th scope="row">{{$d->id}}</th>
                    <td>{{$d->amount}}</td>
                    <td>{{$d->description}}</td>
                    <td>{{$d->receiver->name}}</td>
                    <td>{{$d->receiver->sheba}}</td>
                    <td>@if($d->paid)
                            <span class="text-success">بله</span>
                        @else
                            <span class="text-danger">خیر</span>
                        @endif
                    </td>
                </tr>
                </tbody>
            @endforeach
        </table>
        <div class="text-center border-top">
            <h5 class="m-4">مبلغ کل فاکتورها: {{$data->sum('amount')}}</h5>
        </div>
        <div id="payContainer" style="display:none">

            <form action="/pay" method="post" enctype="multipart/form-data" class="text-center">
                @csrf
                <button type="submit" class="btn btn-primary mt-2">پرداخت گروهی</button>
            </form>
        </div>


        @if (Session::has('results') )

            @foreach(Session::get('results') as $result)
            <div class="alert alert-success mt-4">{{ $result }}</div>
            @endforeach

        @endif


    </div>
    <script>
        let parameter = window.location.search.substr(6)
        if (parameter === "false") {
            document.getElementById("payContainer").style.display = "block";
        }
    </script>
@endsection
