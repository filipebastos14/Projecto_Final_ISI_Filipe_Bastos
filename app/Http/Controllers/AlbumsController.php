<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AlbumsController extends Controller
{
    public function viewBandAlbuns($id)
    {
        $albums = DB::table('albums')
            ->where('band_id', $id)
            ->join('bands', 'band_id', '=', 'bands.id')
            ->select('albums.*')
            ->get();


        return view(
            'bands.band-albums',
            compact(
                'albums'
            )
        );
    }


    public function assertInput(Request $request){
        if (isset($request->id)){
            $this->update($request);
        } else{
            $this->store($request);
        }
        return redirect()->route('band-albums', $request->band_id);
    }

    public function store(Request $request)
    {
        $photo = null;

        if ($request->hasFile('photo')) {
            $photo = Storage::putFile('albumPhotos', $request->photo);

        }

        DB::table('albums')
            ->insert([
                'name' => $request->name,
                'album_Photo' => $photo,
                'release_date' => $request->release_date,
                'band_id' => $request->band_id
            ]);
    }

    public function update(Request $request)
    {
        $photo = null;
        if ($request->hasFile('photo')) {
            $photo = Storage::putFile('albumPhotos', $request->photo);
        }


        DB::table('albums')
            ->where('id', $request->id)
            ->update([
                'name' => $request->name,
                'album_Photo' => $photo,
                'release_date' => $request->release_date,
                'band_id' => $request->band_id
            ]);
            
    }

    public function delete($id)
    {
        DB::table('albums')
            ->where('id', $id)
            ->delete();

        return back();
    }



























    public function addNewAlbum($id, $bandId)
    {
        $updateAlbum = DB::table('albums')
            ->where('id', $id)
            ->first();

        if (isset($updateAlbum))
            return view('albums.add-album', compact(
                'updateAlbum',
                'bandId'
            )
            );
        else
            return view('albums.add-album', compact(
                'bandId'));
    }


}
