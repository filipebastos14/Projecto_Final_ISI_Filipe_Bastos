@extends('layouts.main')

@section('content')
    <div class="container">
        <h2>Aqui vês todos os albuns da banda selecionada!</h2>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome do álbum</th>
                    <th scope="col">Foto</th>
                    <th scope="col">Data de lançamento</th>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                @foreach ($albums as $bandAlbum)
                    <tr>
                        <th scope="row">{{ $bandAlbum->id }}</th>
                        <td>{{ $bandAlbum->name }}</td>
                        <td><img width="50px" height="50px"
                                src="{{ $bandAlbum->album_Photo ? asset('storage/' . $bandAlbum->album_Photo) : asset('images/no-photo.jpg') }}"
                                alt="">
                        </td>
                        <td>{{$bandAlbum->release_date}}</td>
                        <td>
                            @if(auth()->check())
                                @if(Auth::user()->role == 'admin' || Auth::user()->role == 'user')
                                    <a href="{{ route('view-add-album', [$bandAlbum->id, $bandAlbum->band_id]) }}" class="btn btn-info">Editar</a>
                                @endif
                            @endif
                            @if(auth()->check())
                                @if(Auth::user()->role == 'admin')
                                    <a href="{{route('delete-album', $bandAlbum->id)}}" class="btn btn-danger">Apagar</a>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
