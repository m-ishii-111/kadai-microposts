<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Favorite;
use App\Micropost;
use App\User;

class FavoritesController extends Controller
{
    public $favorite;

    function __construct(Favorite $favorite)
    {
        $this->favorite = $favorite;
    }

    public function store($micropostId)
    {
        $micropost_exist = Micropost::find($micropostId)->exists;
        if (!$micropost_exist) return back();

        $user = User::findOrFail(Auth::id());
        $user->favorites()->create([
            'micropost_id' => $micropostId
        ]);

        return back();
    }

    public function destroy(Request $request, $micropostId)
    {
        $user = Auth::user();
        $user->favorites()->where('micropost_id', $micropostId)->delete();

        return back();
    }
}
