@extends('layouts.main')

    @section('content')
    <div class="container">
        @if(isset($updateAlbum->id))
        <h2>Aqui fazes update do album {{$updateAlbum->name}}.</h2>
        @else
            <h2>Aqui adicionas novos albuns.</h2>
        @endif


        <form method="POST" action="{{route('store-album')}}" enctype="multipart/form-data">
            @csrf


            <input name="band_id" type="hidden" value="{{$bandId}}">

            <input name="id" type="hidden" value="{{isset($updateAlbum->id) ? $updateAlbum->id : null}}">

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Name</label>
                <input name="name" value="{{isset($updateAlbum) ? $updateAlbum->name  : ''}}" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                @error('name')
                        Por favor, coloque um nome do album.
                @enderror
                </div>
            <div class="mb-3">
                <label for="time" class="form-label">Release date</label>
                <input name="release_date" value="{{isset($updateAlbum) ? $updateAlbum->release_date : ''}}" type="date" class="form-control" id="exampleInputPassword1">
            </div>
            <div class="mb-3">
                <label for="photo" class="form-label">Photo</label>
                <input name="photo" type="file" accept="image/*" class="form-control" id="exampleInputPhoto1" required>
                @error('image')
                        Por favor, coloque uma imagem.
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
        </form>
        @if(session('message'))
        <div class="alert alert-sucess">{{session('message')}}</div>
        @endif
    </div>
    @endsection
