@include('header')

<body>
<div class="container text-right rtl">
    <div class="row mt-5">
        <div class="col-lg-5 form">
            <form action="/form" method="post" enctype="multipart/form-data">
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
            @if($errors->any())
                <div class="alert alert-danger mt-4">{{$errors->first()}}</div>
            @endif
            @if (Session::has('msg'))
                <div class="alert alert-success mt-4">{{ Session::get('msg') }}</div>
            @endif
        </div>

    </div>


<script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

</body>
</html>
