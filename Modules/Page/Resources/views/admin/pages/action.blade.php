<div class="btn-group">
    <a href="{{route('admin.page.page.edit',$page->id)}}" class="btn btn-info btn-sm"><i class="glyphicon glyphicon-pencil"></i></a>
    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-delete-confirmation"
        data-action-target="{{route('admin.page.page.destroy',$page->id)}}"><i class="glyphicon glyphicon-trash"></i></button>
</div>
