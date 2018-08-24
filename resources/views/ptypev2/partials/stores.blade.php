<div class="text-center download-app ">
    <div class="container-white-rounded row">
        <div class="col-md-6 image-left" >
            <h1>
                Download Our App
                <small class="download-app-small">Thousands of fellow mobile users want to see your review.</small>
            </h1>
            <ul class="list-inline">
                <li>
                    <a href="{{ env('PLAYSTORE_URL') }}" target="_blank" rel="nofollow">
                        <img src="{{ asset("img/stores/playstore.png") }}" class="img-responsive img-button">
                    </a>
                </li>

                <li>
                    <a href="{{ env('APPSTORE_URL') }}" target="_blank" rel="nofollow">
                        <img src="{{ asset("img/stores/appstore.png") }}" class="img-responsive img-button">
                    </a>
                </li>
            </ul>
        </div>
        <div class="image-right col-md-6">
            <img src="{{ asset("img/stores/group.png") }}" class="img-responsive">
        </div>
    </div>
</div>