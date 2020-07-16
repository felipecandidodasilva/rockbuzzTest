@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Posts</div>

                    <div class="card-body">
                        <a class='btn btn-success my-3' href="{{ url('posts/create') }}">create</a>
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($posts as $post)
                                <tr>
                                    <td>{{ $post->title }}</td>
                                    <td>
                                        <form action="{{route('posts.destroy',  $post->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                        <div class="btn-group">

                                            <a class='btn btn-primary' href="{{ route('posts.edit', $post->id) }}">edit</a>
                                            <input type="submit" class='btn btn-danger' value="destroy" onclick="return confirm('Tem certeza que deseja deletar esse registro?');">
                                        </div>
                                    </form>
                                        
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>{{ $posts->links() }}</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
