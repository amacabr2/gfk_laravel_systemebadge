@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                <div class="panel panel-default">

                    <div class="panel-heading">Ecrivez des commentaires</div>

                    <div class="panel-body">

                        <form action="{{ route('comments.store') }}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <textarea name="content" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary">Commenter</button>
                            </div>
                        </form>

                        <h2>Comments</h2>

                        @if (empty($comments))
                            @foreach($comments as $comment)
                                <p>{{ $comment->content }}</p>
                                <hr>
                            @endforeach
                        @else
                            <p><i>Pas de commentaire</i></p>
                        @endif

                    </div>
                </div>

            </div>

        </div>

    </div>

@endsection
