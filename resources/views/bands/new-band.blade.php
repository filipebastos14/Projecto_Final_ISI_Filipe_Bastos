@extends('layouts.main')

    @section('content')
    <div class="container">
        @if(isset($updateBand))
        <h2>Aqui fazes update da banda {{$updateBand->name}}.</h2>
        @else
            <h2>Aqui adicionas novas bandas.</h2>
        @endif

        <form method="POST" action="{{route('store-band')}}" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="id" value="{{isset($updateBand) ? $updateBand->id : null}}">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Name</label>
                <input name="name" value="{{isset($updateBand) ? $updateBand->name : ''}}" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                @error('name')
                        Por favor, coloque um nome.
                @enderror
                </div>
            <div class="mb-3">
                <label for="photo" class="form-label">Photo</label>
                <input name="photo" type="file" accept="image/*" class="form-control" id="exampleInputPhoto1">
                @error('image')
                        Por favor, coloque uma imagem.
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        @if(session('message'))
        <div class="alert alert-sucess">{{session('message')}}</div>
        @endif
    </div>
    @endsection
