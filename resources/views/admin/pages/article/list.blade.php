@php
use App\Helpers\Template as Template;
use App\Helpers\Highlight as Highlight;
@endphp



<div class="x_content">
    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
            <thead>
                <tr class="headings">
                    <th class="column-title" style ='text-align: center'>#</th>
                    <th class="column-title" style ='text-align: center'>Slider Info</th>
                    <th class="column-title" style ='text-align: center'>Thumb</th>
                    <th class="column-title" style ='text-align: center'>Category</th>
                    <th class="column-title" style ='text-align: center'>Kiểu của bài viết</th>
                    <th class="column-title" style ='text-align: center'>Trạng thái</th>
                    {{-- <th class="column-title" style ='text-align: center'>Tạo mới</th>
                    <th class="column-title" style ='text-align: center'>Chỉnh sửa</th> --}}
                    <th class="column-title" style ='text-align: center'>Hành động</th>
                </tr>
            </thead>
            <tbody>


                @if (count($items) > 0)

                @foreach ($items as $key => $val)
                @php
                $index        = $key + 1;
                $class        = $index % 2 == 0 ? 'even' : 'odd';
                $id           = $val['id'];
                $name         = Highlight::show($val['name'], $params['search'], 'name');
                $content      = Highlight::show($val['content'], $params['search'], 'content');
                $thumb        = Template::showItemsThumb($controllerName, $val['thumb'], $val['name']);
                $categoryName = $val['category_name'];
                $status       = Template::showItemsStatus($controllerName, $id, $val['status']);
                $type         = Template::showItemsSelect($controllerName, $id, $val['type'], 'type');
                // $createdHistory  = Template::showItemsHistory($val['created_by'], $val['created']);
                // $modifiedHistory = Template::showItemsHistory($val['modified_by'], $val['modified']);
                $listBtnAction   = Template::showButtonAction($controllerName, $id);

                @endphp


                <tr class="{{ $class }} pointer">
                    <td>{{ $index }}</td>
                    <td width="35%">
                        <p><strong>Name : </strong> {!! $name !!}</p>
                        <p><strong>Content: </strong> {!! $content !!}</p>
                    </td>

                    <td width="15%">{!! $thumb !!}</td>
                    <td width="10%" style ='text-align: center' >{!! $categoryName !!}</td>
                    <td>{!! $type !!}</td>
                    <td>{!! $status !!}</td>
                    {{-- <td>{!! $createdHistory !!}</td>
                    <td>{!! $modifiedHistory !!}</td> --}}
                    <td class="last">{!! $listBtnAction !!}</td>
                </tr>
                @endforeach


                @else
                @include('admin.templates.list_empty', ['colspan'=>6])
                @endif


            </tbody>
        </table>
    </div>
</div>
