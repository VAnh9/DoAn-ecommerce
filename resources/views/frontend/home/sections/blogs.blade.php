<section id="wsus__blogs" class="home_blogs">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="wsus__section_header">
                    <h3>recent blogs</h3>
                    <a class="see_btn" href="{{ route('blogs.index') }}">see more <i class="fas fa-caret-right"></i></a>
                </div>
            </div>
        </div>
        <div class="row home_blog_slider">
          @foreach ($blogs as $blog )
            <div class="col-xl-3">
                <div class="wsus__single_blog wsus__single_blog_2">
                    <a class="wsus__blog_img" href="{{ route('blog.index', $blog->slug) }}">
                        <img src="{{ asset($blog->thumb_image) }}" alt="blog" class="img-fluid w-100">
                    </a>
                    <div class="wsus__blog_text">
                        <a class="blog_top blue" href="javascript:;">{{ $blog->blogCategory->name }}</a>
                        <div class="wsus__blog_text_center">
                            <a href="{{ route('blog.index', $blog->slug) }}">{!! limitText($blog->title, 50) !!}</a>
                            <p class="date">{{ date('M D Y', strtotime($blog->created_at)) }}</p>
                        </div>
                    </div>
                </div>
            </div>
          @endforeach
        </div>
    </div>
</section>
