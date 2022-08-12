@extends('layout')
@section('home')
    @include('menu')
    <div class="container">
        {{-- <h3 class="text-center">Status</h3> --}}
        <div class="row mt-5">
            <div class="col-12 col-sm-10 offset-sm-1">
                <div class="card-header bg-dark text-white">News Info</div>
                <div class="js-messages"></div>
                        @if(!empty($newsInfo))
                            @foreach($newsInfo as $key => $news)
                        <div class="card mb-3 mt-4 @if($news->id === 1) bg-secondary @endif">
                            <div class="card-body">
                                <form class="form-inline send-news" data-url="/news-info/{{$news->id}}">
                                    <label class="sr-only" for="header-lbl">Header</label>
                                    <div class="input-group mr-sm-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Header</div>
                                        </div>
                                        <input type="text" class="form-control" id="header-lbl" aria-describedby="header-lbl" placeholder="Title" name="header" value="{{$news->header ?? ''}}">
                                    </div>

                                    <div class="input-group mr-sm-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Body</div>
                                        </div>
                                        <textarea name="news" id="news-lbl" rows="1" class="form-control" placeholder="Body">{{$news->body ?? ''}}</textarea>
                                    </div>

                                    <div class="form-check mr-sm-2">
                                        <input class="form-check-input" type="checkbox" id="status-lbl" name="status" @if($news->status == 1) checked @endif value="1">
                                        <label class="form-check-label" for="status-lbl">
                                            Is Active?
                                        </label>
                                    </div>

                                    <button type="submit" class="btn btn-primary mb-2">Save</button>
                                </form>
                            </div>
                            </div>
                            @endforeach
                        @endif
                        @if($newsInfo->count() < 5)
                            @for($i = $newsInfo->count()+1; $i <= 5; $i++)
                        <div class="card mb-3 mt-4">
                                        <div class="card-body">
                                <form class="form-inline send-news" data-url="/news-info/{{$i}}">
                                    <label class="sr-only" for="header-lbl">Header</label>
                                    <div class="input-group mr-sm-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Header</div>
                                        </div>
                                        <input type="text" class="form-control" id="header-lbl" aria-describedby="header-lbl" placeholder="Title" name="header">
                                    </div>

                                    <div class="input-group mr-sm-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Body</div>
                                        </div>
                                        <textarea name="news" id="news-lbl" rows="1" class="form-control" placeholder="Body"></textarea>
                                    </div>

                                    <div class="form-check mr-sm-2">
                                        <input class="form-check-input" type="checkbox" id="status-lbl" name="status" value="1">
                                        <label class="form-check-label" for="status-lbl">
                                            Is Active?
                                        </label>
                                    </div>

                                    <button type="submit" class="btn btn-primary mb-2">Save</button>
                                </form>
                    </div>
                    </div>
                            @endfor
                        @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('.send-news').submit(function () {
            let url = $(this).data('url');
            var data = $(this).serializeArray();
            console.log(url, data);
            ajax('POST', data, url, function (response, url) {
                console.log(response);
                if(response.error === true) showReturnMessages(response.message, 'error', 5000, 'js-messages');
                else if(response.error === false) showReturnMessages(response.message, 'success', 5000, 'js-messages');
            });
            return false;
        });
    </script>
@endsection
