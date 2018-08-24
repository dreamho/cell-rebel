<div class="row border-bottom white-bg">
    <nav class="navbar navbar-static-top" role="navigation">
        <div class="navbar-header">
            <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                <i class="fa fa-reorder"></i>
            </button>
            <a href="/" class="navbar-brand"><img class="img-responsive" src="{{ asset("img/logo-3x.png") }}"></a>
        </div>
        <div class="navbar-collapse collapse" id="navbar">
            <ul class="nav navbar-nav navbar-center">
                <li><a aria-expanded="false" role="button" id="ranking" href="{{ preserveCountry("/ranks") }}">Ranking</a></li>
                <li><a aria-expanded="false" role="button" id="reviews" href="{{ preserveCountry("/reviews") }}">Reviews</a></li>
                <li><a aria-expanded="false" role="button" id="about" href="/about">About</a></li>
                <li><a aria-expanded="false" role="button" id="contact" href="/contact">Contact Us</a></li>
                {{-- <li><a aria-expanded="false" role="button" id="benchmark" href="/benchmark">Benchmark</a></li> --}}
            </ul>
            <ul class="nav navbar-nav pull-right country-select">
                <li>
                    <a aria-expanded="false" role="button" style="height: 50px; width: 230px;" class="pull-right">
                        <select class="select_country">
                            @foreach($countries['data'] as $name=>$code)
                                @if(strtolower($code) == $countries['default'])
                                    <option value="{{strtolower($code)}}" selected="selected">{{$name}}</option>
                                @else
                                    <option value="{{strtolower($code)}}">{{$name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </a>
                </li>
                <!--<li><a aria-expanded="false" role="button" >Sign In</a></li>-->
            </ul>
        </div>
    </nav>
</div>