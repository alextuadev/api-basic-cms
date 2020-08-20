@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-sm-9 col-xs-12">
                @foreach($posts as $post)
                    <article class="post-item">
                        <h3>
                            <a href="{{ route('post_detail', $post->slug ) }}" rel="bookmark">{{ $post->title }}</a>
                        </h3>
                        <div class="meta">
                            <span class="post-author"><i class="icon-user"></i> {{ $post->author }}</span>
                            <span class="post-date"><i class="icon-calendar"></i> {{ $post->created_at }}</span> <br>
                            <span class="post-category">
                            <i class="icon-folder-open"></i>
                                <a href="{{ $post->category->slug }}" rel="category">{{ $post->category->name }}</a>
                        </span>
                        </div>
                        <div class="post-image">
                            <a href="{{ $post->featured_image }}">
                                <img class="" src="{{ $post->featured_image }}" alt="">
                            </a>
                        </div>
                        <div>
                            {{ $post->content }}
                        </div>
                    </article>
                @endforeach
                {{ $posts->links() }}
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
                    <h5>Entradas relacionadas</h5>
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
