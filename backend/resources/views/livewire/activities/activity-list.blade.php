<div>

    <h2>Activities (past {{$daysToShow}} days)</h2>

    <hr>

    @foreach($activities as $activity)
        <div class="card  mb-3">
            <div class="card-body d-flex justify-content-between">
                <div>

                    <span class="mr-2">
                        @if(Str::contains($activity->title, ['disconnected']))
                            ❌
                        @else
                            ✅
                        @endif
                   </span>
                    {{$activity->title}}
                </div>
                <div>
                    {{$activity->created_at->diffForHumans()}}
                </div>
            </div>
        </div>
    @endforeach
</div>
