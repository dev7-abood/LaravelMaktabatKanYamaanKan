@extends('dashboard.index')

@section('style')

@endsection


@section('content')
    <div class="container mt-2">
        <div class="content mt-2 mb-4">
            {{ Breadcrumbs::render('my_files') }}
        </div>
    </div>



    <div class="container">

        <form action="{{route('file.search_file_cat')}}" method="post">
            @csrf
            <div class="form-group">
                <label for="cat">ترتيب الملفات حسب التصنيف</label>
                <div class="form-group">
                    <select name="cat_id" class="form-control col-6 d-inline-block" id="cat">
                        @foreach($filesCategorie as $item)
                            <option @if(old('cat_id') == $item->id) selected @endif value="{{$item->id}}">{{$item->category_name}}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-outline-primary mb-2" style="font-size: 12px"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>


        <table class="table table-dark">
            <a href="{{route('my-files.index')}}" class="btn btn-outline-primary mb-2" style="font-size: 12px">جميع الملفات</a>

            <thead>
            <tr>
                <th scope="col">إسم الملف</th>
                <th scope="col">نوع الامتداد</th>
                <th scope="col">الحجم علي القرص</th>
                <th scope="col">الحالة عام/خصاص</th>
                <th scope="col">المدة</th>
                <th scope="col">التصنيف</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($files as $item)
                <tr>
                    <td>{{$item->original_name}}</td>
                    <td class="text-center">{{$item->file_ext}}</td>
                    <td class="text-center">{{$item->size .' '.'byte'}}</td>
                    <td class="text-center">
                        @if($item->power == 1)
                            خاص
                        @else
                            عام
                        @endif
                    </td>
                    <td>{{$item->created_at->diffForhumans()}}</td>
                    <td>{{\App\Models\FileCategorie::find($item->cat_id)->category_name ?? ''}}</td>
                    <td>
                        <a href="{{route('my-go-file.download' , ['id' => $item->id])}}" class="btn btn-outline-primary font-weight-bold mt-1"><i class="fas fa-download"></i></a>
                        <button type="button" data-toggle="modal" data-target="#update" data-id="{{$item->id}}" data-name="{{$item->original_name}}" data-cat="{{$item->cat_id}}" data-power="{{$item->power}}" class="btn btn-outline-light font-weight-bold mt-1"><i class="fas fa-edit"></i></button>
                        <button type="button" data-id="{{$item->id}}" data-name="{{$item->original_name}}" data-cat="{{$item->cat_id}}" data-toggle="modal" data-target="#delete_file" class="btn btn-outline-danger font-weight-bold mt-1"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center mt-2 mb-4">
            @if($files instanceof \Illuminate\Pagination\LengthAwarePaginator )
                {{ $files->links() }}
            @endif
        </div>

        <!-- Modal -->
        <div class="modal fade" id="delete_file" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="title">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        هل تريد فعلاََ حذف الملف؟
                    </div>
                    <form action="{{route('my-go-file.del')}}" method="post">
                        @csrf
                        <input type="hidden" id="id" name="id">
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">حذف</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="update" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="title">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        هل تريد فعلاََ تعديل خصائص الملف؟
                    </div>
                    <form action="{{route('my-go-file.update')}}" style="padding: 20px" method="post">
                        @csrf
                        <input type="hidden" id="id" name="id">

                        <div class="form-group">
                            <label for="cat">التصنيف</label>
                            <select name="file_cat" class="form-control" id="cat">
                                @foreach($filesCategorie as $item)
                                    <option id="cat_{{$item->id}}" value="{{$item->id}}">{{$item->category_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="power">الصلاحية</label>
                            <select name="power" class="form-control" id="power">
                                <option id="power_1" value="1">خاص</option>
                                <option id="power_2" value="2">عام</option>
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-info">تعديل</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>




        @endsection

@section('script')
<script>
    $('#delete_file').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('id') // Extract info from data-* attributes
        var name = button.data('name') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('#title').text(name)
        modal.find('#id').val(id)
    })

    $('#update').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('id') // Extract info from data-* attributes
        var name = button.data('name') // Extract info from data-* attributes
        var cat = button.data('cat') // Extract info from data-* attributes
        var power = button.data('power') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('#title').text(name)
        modal.find('#id').val(id)
        modal.find(`#cat_${cat}`).attr('selected' , true);
        modal.find(`#power_${power}`).attr('selected' , true);
    })
</script>
@endsection
