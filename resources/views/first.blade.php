@extends('app')

@section('title')
    Библиотека
@endsection

@section('css')
    @parent
    <link href="{{asset('/css/my.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Library</div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Автор</th>
                            <th>Количество книг</th>

                        </tr>
                        </thead>
                    <tbody>
                            @foreach($allAuthors as $a)
                            <tr>
                                <th>{{$a->author}}</th>

                                <th>{{$a->countBook}}</th>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Книги</th>
                            <th>Автор</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($allLibrary as $a)
                                <tr>
                                    <th>{{$a->nameBook}}</th>
                                    <th>{{$a->author}}</th>
                                </tr>
                        @endforeach
                        </tbody>

                    </table>
                    <form role="form" enctype="multipart/form-data" method="POST" action="{{action('MainController@postIndex')}}">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="form-group">
                        <label for="sel1">Выберите количество соавторов:</label>
                        <select class="form-control" id="sel1" style="width:auto;" name="selectCount">
                            @foreach($countSoAuthors as $c)
                                <option>{{$c}}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-success">Вывести</button>
                    </div>
                    </form>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Книги</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($status))
                             <tr>
                                 <th>{{$status}}</th>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
