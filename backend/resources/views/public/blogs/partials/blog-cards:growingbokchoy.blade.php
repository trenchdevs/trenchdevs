@if($blogs->isEmpty())
    No entries found...
@else
    @foreach($blogs as $blog)
        <div class="col-md-6 mb-5">
            <a class="post-card-link" href="{{route('public.blogs.details', $blog->slug)}}">
                <div class="card">
                    <img class="card-img-top" src="{{$blog->primary_image_url}}"
                         alt="{{$blog->title}}">
                    <div class="card-body">
                        <p><small>{{date('F j, Y, g:i a', strtotime($blog->published_at))}}</small>
                        </p>
                        <h5 class="card-title">{{$blog->title}}</h5>
                        <p class="card-text">
                            {{ $blog->tagline }}
                        </p>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
@endif
