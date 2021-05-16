@extends('news.main')
@section('content')
    @include('news.block.slider')
    <!-- Content Container -->
    <div class="content_container">
        <div class="container">
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-9">
                    <div class="main_content">
                        <!-- FEATURED -->
                        @include('news.block.featured', ['items'=> $itemsFeatured])

                        {{-- CATEGORY --}}
                        @include('news.pages.home.child-index.category')

                    </div>
                </div>


                <!-- SIDEBAR -->
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


@endsection
