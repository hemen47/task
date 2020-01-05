@include('header')

<body>

<div class="container text-right rtl">
    <div class="row mt-5">
        <div class="col-lg-8 form">

            <table class="table">
                <thead>
                <tr>
                    <th scope="col">شماره‌فاکتور</th>
                    <th scope="col">مبلغ</th>
                    <th scope="col">توضیحات</th>
                    <th scope="col">دریافت‌کننده</th>
                    <th scope="col">شبا</th>
                    <th scope="col">موبایل</th>
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
                        <td>{{$d->receiver->number}}</td>
                    </tr>
                    </tbody>
                @endforeach
            </table>

            <form action="/pay" method="post" enctype="multipart/form-data" class="text-center">
                @csrf
                <button type="submit" class="btn btn-primary mt-2">پرداخت گروهی</button>
            </form>

            @if (Session::has('msg'))
                <div class="alert alert-success mt-4">{{ Session::get('msg') }}</div>
            @endif


        </div>
    </div>
</div>


<script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

</body>
</html>
