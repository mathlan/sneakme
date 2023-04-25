<h1> {{ $answer->name }} </h1>
<h2> {{ $answer->created_at }} </h2>
<h2> {{ $answer->updated_at }} </h2>
@foreach ($answer->keywords as $keyword)
    <h2> {{ $keyword->name }} </h2>
@endforeach

