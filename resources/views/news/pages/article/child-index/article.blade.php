{{-- <div class="post_image"><img src="images/article/exzJEG4WDU.jpeg" alt="images/article/exzJEG4WDU.jpeg"
            class="img-fluid w-100">
    </div> --}}

@include('news.partials.article.image',['item'=> $item, 'type'=>'single'])
@include('news.partials.article.content',['item'=> $item, 'lengthContent'=>'full' , 'showCategory'=> true])


