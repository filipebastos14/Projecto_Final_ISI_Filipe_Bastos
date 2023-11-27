<?php

namespace App\Http\Controllers;

use App\Models\Band;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\BandsController;

class HomeController extends Controller
{
    public function getMain(){
        $bands = (new BandsController)->getAll();

        return view('home.home', compact(
            'bands',
        ));
    }

    public function storeBand(Request $request){
        if ($request->id) {

            $photo = null;
            if($request->hasFile('photo')){
                $photo = Storage::putFile('bandPhotos', $request->band_Photo);
            }

            Band::where('id', $request->id)
                ->update([
                    'name' => $request->name,
                    'band_Photo' => $photo,
                ]);
        } else {
            $photo = null;
            Band::insert([
                'name' => $request->name,
                'band_Photo' => $photo,
            ]);
        }

        return redirect()->route('home.home')->with('message', 'Banda adicionada com sucesso.');
    }
}
