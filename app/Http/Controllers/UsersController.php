<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Micropost;

class UsersController extends Controller
{
    public $perPage = 10;
    public $user;

    function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $users = $this->user->orderBy('id', 'desc')->paginate($this->perPage);

        return view('users.index', [
            'users' => $users,
        ]);
    }

    public function show($id)
    {
        $user = $this->user->findOrFail($id);

        $user->loadRelationshipCounts();

        $microposts = $user->microposts()->orderBy('created_at', 'desc')->paginate($this->perPage);

        return view('users.show', [
            'user' => $user,
            'microposts' => $microposts,
        ]);
    }

    /**
     * ユーザのフォロー一覧ページを表示するアクション。
     *
     * @param  $id  ユーザのid
     * @return \Illuminate\Http\Response
     */
    public function followings($id)
    {
        // idの値でユーザを検索して取得
        $user = $this->user->findOrFail($id);

        // 関係するモデルの件数をロード
        $user->loadRelationshipCounts();

        // ユーザのフォロー一覧を取得
        $followings = $user->followings()->paginate($this->perPage);

        // フォロー一覧ビューでそれらを表示
        return view('users.followings', [
            'user' => $user,
            'users' => $followings,
        ]);
    }

    /**
     * ユーザのフォロワー一覧ページを表示するアクション。
     *
     * @param  $id  ユーザのid
     * @return \Illuminate\Http\Response
     */
    public function followers($id)
    {
        // idの値でユーザを検索して取得
        $user = $this->user->findOrFail($id);

        // 関係するモデルの件数をロード
        $user->loadRelationshipCounts();

        // ユーザのフォロワー一覧を取得
        $followers = $user->followers()->paginate($this->perPage);

        // フォロワー一覧ビューでそれらを表示
        return view('users.followers', [
            'user' => $user,
            'users' => $followers,
        ]);
    }

    public function favorites($userId)
    {
        $user = $this->user->findOrFail($userId);
        $user->loadRelationshipCounts();

        $favorites_ids = $user->favorites()->get()->pluck('micropost_id')->toArray();
        $microposts = Micropost::whereIn('id', $favorites_ids)->orderBy('updated_at', 'DESC')->paginate($this->perPage);

        return view('users.favorites', [
            'user' => $user,
            'microposts' => $microposts
        ]);
    }
}
