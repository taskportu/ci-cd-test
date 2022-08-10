<div class="container" id="terminaliste">
    <div class="row">
        <div class="col-12">
            <div id="hideDiv">

                <div class="app-header">
                    <h4>KOMMENDE UKE / TERMINLISTE</h4>
                </div>

                <div class="top-nav mb-4">
                    <label class="frame-btn btn btn-outline-primary active" data-frame="one">KOMMENDE UKE</label>
                    <label class="frame-btn btn btn-outline-primary" data-frame="two">TERMINLISTE</label>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">

            {{--<iframe id="tournamentFrame" src="https://occ.no/turneringer/" width="100%" title="TERMINLISTE" style="height: 100rem; margin-top: -42rem;"></iframe>--}}
            <div class="content">
                <div class="load">
                    <img class="img-fluid" src="{{asset('images/loading.gif')}}" alt="Loading">
                </div>
                <div class="frames d-none frame-one">
                    <iframe class="tournamentFrame" id="tournamentFrameTwo" src="https://occ.no/posts/kommende-uke/" width="100%" title="KOMMENDE UKE"></iframe>
                </div>
                <div class="frames d-none frame-two">
                    <iframe class="tournamentFrame" id="tournamentFrameOne" src="https://occ.no/posts/terminliste/" width="100%" title="TERMINLISTE"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

@push('link')
    <style>

    </style>
@endpush
@push('script2')
    <script>
        $(document).ready(function () {
            $('#tournamentFrameOne').on('load', function () {
                $('.load').addClass('d-none');
                $('.frame-one').removeClass('d-none');
                $('.frame-two').addClass('d-none');
            });
        });

        $('.frame-btn').on('click', function () {
            $('.frame-btn').removeClass('active');
            $(this).addClass('active');
            let frame = $(this).data('frame');
            console.log(frame);
            // $('#tournamentFrameOne').on('load', function () {
                loadFrame(frame);
            // });
        });

        function loadFrame(frame) {
            if(frame === 'one') {
                $('.load').addClass('d-none');
                $('.frame-one').removeClass('d-none');
                $('.frame-two').addClass('d-none');
            }
            else if (frame === 'two') {
                $('.load').addClass('d-none');
                $('.frame-two').removeClass('d-none');
                $('.frame-one').addClass('d-none');
            }
        }
    </script>
@endpush
