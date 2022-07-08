@if (Auth::user()->is_favoriting(Auth::id(), $micropost->id))
    {{-- アンフォローボタンのフォーム --}}
    {!! Form::open(['route' => ['micropost.unfavorite', $micropost->id], 'method' => 'delete']) !!}
        {!! Form::submit('UnFavorite', ['class' => "btn btn-success btn-sm mr-2"]) !!}
    {!! Form::close() !!}
@else
    {{-- フォローボタンのフォーム --}}
    {!! Form::open(['route' => ['micropost.favorite', $micropost->id]]) !!}
        {!! Form::submit('Favorite', ['class' => "btn btn-light btn-sm mr-2"]) !!}
    {!! Form::close() !!}
@endif