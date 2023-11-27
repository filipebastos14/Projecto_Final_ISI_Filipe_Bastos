<?php

namespace App\Http\Controllers;

use App\Models\Band;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BandsController extends Controller
{
    public function getAll()
    {
        $bands = Band::select('bands.*', DB::raw('count(*) AS count'))
            ->join('albums', 'bands.id', '=', 'band_id')
            ->groupBy('bands.id')
            ->get();

        return $bands;
    }

    public function showAll(){
        $bands = $this->getAll();
        
        return view('home.home', compact('bands'));
    }

    public function assertInput(Request $request){

        if (isset($request->id)){
            $this->update($request);
        } else{
            $this->store($request);
        }
        return $this->showAll();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        $photo = null;
        if ($request->hasFile('photo')) {
            $photo = Storage::putFile('bandPhotos', $request->photo);
        }

        Band::insert([
            'name' => $request->name,
            'band_Photo' => $photo,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $photo = null;
        if ($request->hasFile('photo')) {
            $photo = Storage::putFile('bandPhotos', $request->photo);
        }

        $bandPhoto = $photo;

        if($request->photo == null){
            $tempBandPhoto = Band::select('band_Photo')
            ->where('id', $request->id)
            ->first();

            $bandPhoto = $tempBandPhoto->band_Photo;
        }

        Band::where('id', $request->id)
            ->update([
                'name' => $request->name,
                'band_Photo' => $bandPhoto,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        DB::table('albums')
            ->where('band_id', $id)
            ->delete();

        Band::where('id', $id)
            ->delete();

        return back();
    }


    // Views
    public function addNewBand($id)
    {
        $updateBand = Band::where('id', $id)
        ->first();
        

        if(isset($updateBand))
            return view('bands.new-band', compact('updateBand'));
        else
            return view('bands.new-band');
    }
}
