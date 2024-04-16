@extends('frontend.layouts.master')
@section('title')
  {{ $settings->site_name }} || Blog
@endsection

@section('content')

<!--============================
    BREADCRUMB START
==============================-->
<section id="wsus__breadcrumb">
  <div class="wsus_breadcrumb_overlay">
      <div class="container">
          <div class="row">
              <div class="col-12">
                  <h4>blog details</h4>
                  <ul>
                      <li><a href="#">blog</a></li>
                      <li><a href="javascript:;">blog details</a></li>
                  </ul>
              </div>
          </div>
      </div>
  </div>
</section>
<!--============================
  BREADCRUMB END
==============================-->


<!--============================
  BLOGS DETAILS START
==============================-->
<section id="wsus__blog_details">
  <div class="container">
      <div class="row">
          <div class="col-xxl-9 col-xl-8 col-lg-8">
              <div class="wsus__main_blog">
                  <div class="wsus__main_blog_img">
                      <img src="{{ asset($blog->thumb_image) }}" alt="blog" class="img-fluid w-100">
                  </div>
                  <p class="wsus__main_blog_header">
                      <span><i class="fas fa-user-tie"></i> by {{ $blog->user->name }}</span>
                      <span><i class="fal fa-calendar-alt"></i> {{ date('M d Y', strtotime($blog->created_at)) }}</span>
                      <span><i class="fal fa-comment-alt-smile"></i> {{ count($comments) }} Comment</span>
                  </p>
                  <div class="wsus__description_area">
                      <h1>{!! $blog->title !!}</h1>
                      <p>{!! $blog->description !!}</p>
                  </div>
                  <div class="wsus__share_blog">
                      <p>share:</p>
                      <ul>
                          <li><a target="_blank" class="facebook" href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}"><i class="fab fa-facebook-f"></i></a></li>
                          <li><a target="_blank" class="twitter" href="https://twitter.com/share?url={{url()->current()}}&text={{$blog->title}}"><i class="fab fa-twitter"></i></a></li>
                          <li><a target="_blank" class="linkedin" href="https://www.linkedin.com/shareArticle?url={{url()->current()}}&title={{$blog->title}}&summary={{limitText($blog->description,50)}}"><i class="fab fa-linkedin-in"></i></a></li>
                      </ul>
                  </div>
                  @if (count($relatedBlogs) != 0)
                    <div class="wsus__related_post">
                        <div class="row">
                            <div class="col-xl-12">
                                <h5>related post</h5>
                            </div>
                        </div>
                        <div class="row blog_det_slider">
                          @foreach ($relatedBlogs as $relatedBlog )
                            <div class="col-xl-3">
                                <div class="wsus__single_blog wsus__single_blog_2">
                                    <a class="wsus__blog_img" href="{{ route('blog.index', $relatedBlog->slug) }}">
                                        <img src="{{ asset($relatedBlog->thumb_image) }}" alt="blog" class="img-fluid w-100">
                                    </a>
                                    <div class="wsus__blog_text">
                                        <a class="blog_top blue" href="javascript:;">{{ $relatedBlog->blogCategory->name }}</a>
                                        <div class="wsus__blog_text_center">
                                            <a href="{{ route('blog.index', $relatedBlog->slug) }}">{!! $relatedBlog->title !!}</a>
                                            <p class="date">{{ date('M d Y', strtotime($relatedBlog->created_at)) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          @endforeach
                        </div>
                    </div>
                  @endif
                  <div class="wsus__comment_area">
                      <h4>comment <span>{{ count($comments) }}</span></h4>
                      @foreach ($comments as $comment )
                        <div class="wsus__main_comment">
                            <div class="wsus__comment_img">
                                <img style="width: 70px" src="{{ asset($comment->user->image) }}" alt="user" class="img-fluid">
                            </div>
                            <div class="wsus__comment_text replay" style="padding-left: 0">
                                <h6>{{ $comment->user->name }} <span>{{ date('d M Y', strtotime($comment->created_at)) }}</span></h6>
                                <p>{{ $comment->comment }}</p>
                            </div>
                        </div>
                      @endforeach
                      @if (count($comments) == 0)
                        <i>Be a first one to comment!</i>
                      @endif
                      <div id="pagination">
                        <div class="mt-5">
                          @if ($comments->hasPages())
                            {{ $comments->withQueryString()->links() }}
                          @endif
                        </div>
                      </div>
                  </div>
                  <div class="wsus__post_comment">
                    @if (Auth::check())
                      <h4>post a comment</h4>
                      <form action="{{ route('user.blog-comment') }}" method="POST">
                        @csrf
                          <div class="row">
                              <div class="col-xl-12">
                                  <div class="wsus__single_com">
                                      <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                                      <textarea rows="5" name="comment" placeholder="Your Comment"></textarea>
                                  </div>
                              </div>
                          </div>
                          <button class="common_btn" type="submit">post comment</button>
                      </form>
                    @else
                      <h5>Login to comment on post!</h5>
                      <a class="common_btn mt-2" href="{{ route('login') }}">Login</a>
                    @endif
                  </div>
              </div>
          </div>
          <div class="col-xxl-3 col-xl-4 col-lg-4">
              <div class="wsus__blog_sidebar" id="sticky_sidebar">
                  <div class="wsus__blog_search">
                      <h4>search</h4>
                      <form action="{{ route('blogs.index') }}" method="GET">
                          <input type="text" placeholder="Search" name="search">
                          <button type="submit" class="common_btn"><i class="far fa-search"></i></button>
                      </form>
                  </div>
                  <div class="wsus__blog_category">
                      <h4>Categories</h4>
                      <ul>
                        @foreach ($blogCategories as $blogCategory )
                          <li><a href="{{ route('blogs.index', ['category' => $blogCategory->slug]) }}">{{ $blogCategory->name }}</a></li>
                        @endforeach
                      </ul>
                  </div>
                  <div class="wsus__blog_post">
                      <h4>More Post</h4>
                      @foreach ($moreBlogs as $moreBlog )
                        <div class="wsus__blog_post_single">
                            <a href="{{ route('blog.index', $moreBlog->slug) }}" class="wsus__blog_post_img">
                                <img src="{{ asset($moreBlog->thumb_image) }}" alt="blog" class="imgofluid w-100">
                            </a>
                            <div class="wsus__blog_post_text">
                                <a href="{{ route('blog.index', $moreBlog->slug) }}">{{ $moreBlog->title }}</a>
                                <p> <span>{{ date('M d Y', strtotime($moreBlog->created_at)) }}</span> {{ count($moreBlog->blogComments) }} Comment </p>
                            </div>
                        </div>
                      @endforeach

                  </div>
              </div>
          </div>
      </div>
  </div>
</section>
<!--============================
  BLOGS DETAILS END
==============================-->

@endsection


