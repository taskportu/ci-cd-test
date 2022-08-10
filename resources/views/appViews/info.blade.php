<div class="app-header mb-4">
    <h4 class="pl-3 text-center">INFORMASJON</h4>
</div>
@foreach($newsInfo as $key => $news)
    @if (isset($news) && isset($news->header) && isset($news->body))
        <div class="news-out mb-3" style="border: 2px solid;">
            <div class="app-header mb-0">
                <h4 class="pl-3">{{$news->header}}</h4>
            </div>
            <div class="card-body">
                <p class="mb-0 text-justify">
                    {{$news->body}}
                </p>
            </div>
        </div>
    @endif
@endforeach
