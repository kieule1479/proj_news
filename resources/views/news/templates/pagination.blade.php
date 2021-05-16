@php
$totalItems= $items->total();
$totalPages= $items->lastPage();
$totalItemsPerPage= $items->perPage();

@endphp

<div class="x_content">
    <div class="row">
        <div class="col-md-8">
            <p class="m-b-0">
                Tổng số phần tử trên 1 trang: <span class="label label-info label-pagination">{{$totalItemsPerPage}}</span>
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Tổng số phần tử:<span class="label label-success label-pagination">{{$totalItems}}</span>
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Tổng số trang:<span class="label label-danger label-pagination">{{$totalPages}}</span>

            </p>
        </div>
        <div class="col-md-4">
         
        {!! $items->appends(request()->input())->links('pagination.pagination_backend')!!}
        </div>
    </div>
</div>