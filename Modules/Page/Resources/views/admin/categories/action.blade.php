<div class="btn-group">
    <a href="{{route('admin.category.category.edit',$category->id)}}" class="btn btn-info btn-sm"><i class="glyphicon glyphicon-pencil"></i></a>
    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-delete-confirmation"
        data-action-target="{{route('admin.category.category.destroy',$category->id)}}"><i class="glyphicon glyphicon-trash"></i></button>
</div>
