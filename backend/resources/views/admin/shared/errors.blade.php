@if(!empty($errors->all()))

    <div class="alert alert-danger p-2">
        <ul class="list-unstyled mb-0">
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif
