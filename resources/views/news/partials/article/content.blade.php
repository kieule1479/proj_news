@php
use App\Helpers\Template as Template;
use App\Helpers\URL;
$name = $item['name'];
$thumb = asset('images/article/' . $item['thumb']);
if ($showCategory) {
    $linkCategory = URL::linkCategory($item['category_id'], $item['category_name']);
}
$linkArticle = URL::linkArticle($item['id'], $item['name']);
$created = Template::showDateTimeFrontend($item['created']);

if ($lengthContent === 'full') {
    $content = $item['content'];
} else {
    $content = Template::showContent($item['content'], $lengthContent);
}
@endphp


<div class="post_content">

    @if ($showCategory)
        <div class="post_category cat_technology "> <a href="{{ $linkCategory }}">{{ $item['category_name'] }}</a>
        </div>
    @endif

    <div class="post_title">
        <a href="{{ $linkArticle }}">{{ $name }}</a>
    </div>
    <div class="post_info d-flex flex-row align-items-center justify-content-start">
        <div class="post_author d-flex flex-row align-items-center justify-content-start">
            <div class="post_author_name">
                <a href="#">Lưu Trường HảiLân</a>
            </div>
        </div>
        <div class="post_date">
            <a href="#">{{ $created }}</a>
        </div>
    </div>

    @if ($lengthContent > 0)
        <div class="post_text">
            <p> {!! $content !!} </p>
        </div>
    @endif
    @if ($lengthContent = 'full')
        <div class="post_text">
            <p> {!! $content !!} </p>
        </div>
    @endif
</div>
