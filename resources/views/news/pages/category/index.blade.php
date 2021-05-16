@extends('news.main')
@section('content')

    <div class="section-category">
        @include('news.block.breakcrummb',['item'=>$itemsCategory] )

        <div class="content_container container_category">
            <div class="featured_title">
                <div class="container">
                    <div class="row">
                        <!-- Main Content -->
                        <div class="col-lg-9">
                            @include('news.pages.category.child-index.category',['item'=>$itemsCategory])
                        </div>
                        <!-- Sidebar -->
                        <div class="col-lg-3">
                            <div class="sidebar">
                                <!-- Latest POSTS -->
                                @include('news.block.latest_posts', ['items'=> $itemsLatest])

                                {{-- ADVERTISEMENT --}}
                                @include('news.block.advertisement', ['itemsAdvertisement'=> []])

                                {{-- MOST_VIEWED --}}
                                @include('news.block.most_viewed', ['itemsMostViewed'=> []])

                                {{-- TAGS --}}
                                @include('news.block.tags', ['itemsMostViewed'=> []])

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
