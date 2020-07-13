@extends('layouts.app')

@section('content')
    <div class="wrapper">

        <section class="aboutBanner fadeInLeft wow">
            <div class="blogDetailTitle"><h1>{{$articleDetail->title}}</h1></div>

        </section>

        <section class="blogSection">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 mb-4 fadeInLeft wow">
                        <div class="blogWrapper">
                            <div class="blogContent">
                                <h3>{{$articleDetail->title}}</h3>
                                <ul class="blogHeadingContent">
                                    <li><a href="{{ url('/about') }}">{{ $author_name }}</a></li>
                                    <li><i class="fa fa-calendar" aria-hidden="true"></i> {{ date('F/j/Y',strtotime($articleDetail->created_at)) }}</li>
                                    <li>
                                        @php
                                            $readingTime = str_word_count($articleDetail->description);
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
                                <img src="@if (file_exists(public_path($articleDetail->featured_image)) && $articleDetail->featured_image!=''){{URL::asset($articleDetail->featured_image) }} @else {{ asset('assets/uploads/no_img.gif') }} @endif" class="img-fluid">
                                <p>{!! $articleDetail->description !!}</p>
                                <div class="blogShareContent">
                                    <div class="shareSocial float-right">
                                        <a href="http://www.sharethis.com/share?url={{ url()->current() }}&title={{ $articleDetail->title }}&img={{ URL::asset($articleDetail->featured_image) }}&summary={!! words($articleDetail->description, 20, '...') !!}" target="_blank" class="hoverSocial">Share <i class="fa fa-share-alt" aria-hidden="true"></i> </a>
                                    </div>
                                </div>
                            </div>
                            <div class="blogDetailForm">
                                @if(count($articlesComments) > 0)
                                    <h3>COMMENTS ON THIS POST</h3>
                                    <div class="blogs-comments">
                                        @foreach($articlesComments as $comments)
                                            <div class="row">
                                                <div class="col-md-2 image-container"><img src="{{ asset('assets/uploads/avatar.jpg') }}" alt="{{ $articleDetail->slug }}"></div>
                                                <div class="col-md-10 comment-container">
                                                    <h5>{{ $comments->name }}</h5>
                                                    <small><i class="fa fa-calendar"></i> {{ date('F/j/Y', strtotime($comments->created_at)) }}</small>
                                                    <p>{{ $comments->comment }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                <div class="clearfix"></div>
                                <h3>COMMENT</h3>
                                <form action="{{ url('articles/leave-reply') }}" method="post" id="leave_reply">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="article_id" value="{{ $articleDetail->id }}"/>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" name="name" placeholder="Your Name" class="form-control" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="email" name="email" placeholder="Your Email" class="form-control" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <textarea class="form-control" name="message" placeholder="Enter Your Comment..." rows="4" required=""></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                 <button class=" postBtn float-right">
                                                     <div class="page-loader" style="display: none;position: absolute;top: -45px;right: 64px;">
                                                         <img src="{{ config('constants.img_path') }}/loading.gif">
                                                     </div> Post
                                                 </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>


                        </div>
                    </div>
                    <div class="col-md-4 mb-5 fadeInRight wow">
                        @include('mobile-sidebar')
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection
@section('scripts')

    <script>
        $(document).ready(function () {

            var form = $('#leave_reply');
            form.submit(function(e) {
                e.preventDefault();
                $('div.page-loader').show();
                $.ajax({
                    url     : form.attr('action'),
                    type    : form.attr('method'),
                    data    : form.serialize(),
                    dataType: 'json',
                    success : function ( data )
                    {
                        $('div.page-loader').hide();
                        if(data.errors) {
                            $.each(data.errors, function (key, value) {
                                //$('.'+key+'-error').html(value);
                                $('input[name="'+key+'"],textarea[name="'+key+'"]').closest('div.form-group').addClass('has-error');
                            });
                        }
                        if(data.success == 1){
                            form.prepend('<div class="alert alert-success alert-dismissable"> <a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Your reply has been successfully submitted. After review, this will be publish on website soon.</div>')
                            form[0].reset();
                        }
                    },
                    error: function( json )
                    {
                        $('div.page-loader').hide();
                        if(json.status === 422) {
                            $.each(json.responseJSON, function (key, value) {
                                //$('.'+key+'-error').html(value);
                                $('input[name="'+key+'"],textarea[name="'+key+'"]').closest('div.form-group').addClass('has-error');
                            });
                        } else {
                            // Error

                            // alert('Incorrect credentials. Please try again.')
                        }
                    }
                });
            });

        });
    </script>
@stop