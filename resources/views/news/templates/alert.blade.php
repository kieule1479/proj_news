@if (session('news_notify'))
    <div class="alert alert-success" role="alert">

        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
       <strong> {{ session('news_notify') }} </strong>
    </div>
@endif