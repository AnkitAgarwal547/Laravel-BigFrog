@extends('layouts.app')

@section('content')

    <div class="wrapper">

        <section class="aboutBanner blogBannerBg fadeInLeft wow" @if($page->header_image) style="background: url('{{ URL::asset($page->header_image) }}') no-repeat !important;background-size: cover !important;" @endif>
            <div class="storeRating">
                <div class="ratingValue"></div>
                <div class="ratingStar">
                    <h2>{{ $articlesCategory->name }}</h2>
                </div>
            </div>
        </section>

        <section class="blogSection">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 mb-4 ">
                        <div class="blogWrapper">

                            @if(count($articles))
                                @foreach($articles as $index=>$article)
                                    <div class="blogContent fadeInUp wow">
                                        <h3><a href="{{ url('blog').'/'.$article->slug }}">{{ $article->title }}</a></h3>
                                        <ul class="blogHeadingContent">
                                            <li><a href="{{ url('/about') }}">{{ $author_name }}</a></li>
                                            <li><i class="fa fa-calendar" aria-hidden="true"></i> {{ date('F/j/Y',strtotime($article->created_at)) }}</li>
                                            <li>
                                                @php
                                                    $readingTime = str_word_count($article->description);
                                                    $m = floor($readingTime / 200);
                                                    $s = floor($readingTime % 200 / (200 / 60));
                                                    $est = $m . ' minute' . ($m == 1 ? '' : 's') . ', ' . $s . ' second' . ($s == 1 ? '' : 's');
                                                    $est = \Carbon\Carbon::parse($est)->diffInMinutes();
                                                    if($est == 0){
                                                        echo '~1 Min Read';
                                                    }
                                                    else{
                                                        echo $est .' Min Read';
                                                    }
                                                @endphp
                                            </li>
                                        </ul>
                                        <a href="{{ url('blog').'/'.$article->slug }}"><img src="@if (file_exists(public_path($article->featured_image)) && $article->featured_image!=''){{URL::asset($article->featured_image) }} @else {{ asset('assets/uploads/no_img.gif') }} @endif" class="img-fluid"></a>
                                        <p>{!! words($article->description, 100, '[...]') !!}</p>
                                        <div class="blogShareContent">
                                            <div class="shareSocial">
                                                <a href="http://www.sharethis.com/share?url={{ url()->current() }}&title={{ $article->title }}&img={{ URL::asset($article->featured_image) }}&summary={!! words($article->description, 20, '...') !!}" target="_blank" class="hoverSocial">Share <i class="fa fa-share-alt" aria-hidden="true"></i> </a>
                                            </div>
                                            <a href="{{ url('blog').'/'.$article->slug }}" class="btn blogReadMore">Read More <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="no-search">
                                    <h3>No Blogs found in this category</h3>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4 mb-5 fadeInRight wow">
                        @include('mobile-sidebar')
                    </div>
                </div>
                @if(count($articles) > 12)
                    @include('pagination', ['paginator' => $articles])
                @endif
            </div>
        </section>
    </div>

@endsection