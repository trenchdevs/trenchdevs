<div>
    @foreach($activities as $activity)
        <div class="alert alert-warning">
            {{$activity->title}}
        </div>
    @endforeach
</div>
