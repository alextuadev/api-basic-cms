@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-sm-9 col-xs-12">
                <div class="content">
                    {{ $post->content }}
                </div>
            </div>


            <div class="col-lg-3  col-sm-3 col-xs-12">
                <aside id="search" class="box widget widget_search">
                    <form role="search" method="get" id="searchform" class="searchform" action="{{ route('blog') }}">
                        <div>
                            <label class="screen-reader-text" for="s">Buscar:</label>
                            <input type="text" value="" name="s" id="s">
                            <input type="submit" id="" value="Buscar">
                        </div>
                    </form>
                    <i class="fa fa-search"></i>
                </aside>
                <aside class="box widget">
                    <h5>Entradas destacadas</h5>
                    <ul>
                        @foreach($related_post as $post)
                            <li>
                                <a href="{{ $post->slug }}">{{ $post->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                </aside>
            </div>
        </div>
    </div>

@endsection
