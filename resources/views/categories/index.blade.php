@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-end mb-2">
    <a href="{{ route('categories.create') }}" class="btn btn-success">Add Category</a>
</div>
<div class="card card-default">
    <div class="card-header">Categories</div>
    <div class="card-body">
        @if( $categories->count() > 0 )
        <table class="table">
            <thead>
                <th>Name</th>
                <th>Posts Count</th>
                <th></th>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td>
                        {{ $category->name }}
                    </td>
                    <td>
                        <!-- {{ $category->posts->count() }} -->
                        {{ $category->posts()->where('user_id', auth()->id())->count() }}
                    </td>
                    <td>
                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-info btn-sm">Edit</a>
                        <a href="#" class="btn btn-danger btn-sm" onclick="handleDelete( '{{ $category->id }}' , '{{ $category->name }}' )">Delete</a>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="" method="POST" id="deleteCategoryForm">
                    @csrf
                    @method('DELETE')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Delete Category</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p class="text-center" style="font-weight: bold" id="modalContent">
                                Are you sure you want to delete ( <span id="deletedCategory"> </span> ) Category
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">No, Go back</button>
                            <button type="submit" class="btn btn-danger">Yes, Delete</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @else
        <h3 class="text-center">No Categories Yet</h3>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    function handleDelete(id, name) {
        var form = document.getElementById('deleteCategoryForm')

        // show data in modal
        document.getElementById('deletedCategory').innerHTML = name

        form.action = '/categories/' + id
        console.log('deleting.', form)
        var categoty_name = name
        $('#deleteModal').modal('show')
    }
</script>
@endsection