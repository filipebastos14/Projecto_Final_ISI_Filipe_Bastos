@extends('layouts.main')

@section('content')
    <div class="container">
        <h2>Todas as bandas</h2>


        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Foto</th>
                    <th scope="col">Número de albuns criados</th>
                    <th></th>
                    @if(auth()->check())
                        @if(Auth::user()->role == 'admin')
                            <th><a href="{{ route('view-add-band', 0) }}" class="btn btn-info">Adicionar banda</a></th>
                        @endif
                    @endif

                </tr>
            </thead>
            <tbody>
                @foreach ($bands as $band)
                    <tr>
                        <th scope="row">{{ $band->id }}</th>
                        <td>{{ $band->name }}</td>
                        <td><img width="50px" height="50px"
                            src="{{$band->band_Photo? asset('storage/' . $band->band_Photo) : asset('images/no-photo.jpg')}}" alt="">
                        </td>
                        <td>{{$band->count}}</td>
                        <td>
                            <a href="{{ route('band-albums', $band->id) }}" class="btn btn-info">Ver</a>
                            @if(auth()->check())
                                @if(Auth::user()->role == 'admin' || Auth::user()->role == 'user')
                                    <a href="{{ route('view-add-band', $band->id) }}" class="btn btn-info">Editar</a>
                                @endif
                            @endif
                            @if(auth()->check())
                                @if(Auth::user()->role == 'admin')
                                    <a href="{{route('delete-band', $band->id)}}" class="btn btn-danger">Apagar</a>
                                @endif
                            @endif
                        </td>
                        @if(auth()->check())
                            @if(Auth::user()->role == 'admin')
                                <td><a href="{{ route('view-add-album', [0, $band->id]) }}" class="btn btn-info">Adicionar album</a></td>
                            @endif
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
