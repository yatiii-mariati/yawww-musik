<?php

use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('frontend.welcome');
});

/*
|--------------------------------------------------------------------------
| Auth Routes (WEB)
|--------------------------------------------------------------------------
*/
Route::get('/login', function () {
    return view('frontend.login');
})->name('login');

Route::get('/register', function () {
    return view('frontend.register');
});

Route::post('/login', [AuthController::class, 'loginWeb']);
Route::post('/register', [AuthController::class, 'registerWeb']);
Route::post('/logout', [AuthController::class, 'logoutWeb']);

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('frontend.dashboard');
    });

    Route::get('/top10', function () {
        return view('frontend.top10');
    });

    Route::get('/recommendation', function () {
        return view('frontend.recommendation');
    });

    Route::get('/favorite', function () {
        return view('frontend.favorite');
    });

=======
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Artist;
use App\Models\Album;
use App\Models\Song;
use App\Models\Rekomendasi;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\ArtistController as AdminArtistController;
use App\Http\Controllers\Admin\AlbumController;

/*
|--------------------------------------------------------------------------
| HALAMAN PUBLIK
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', fn () => view('frontend.login'))->name('login');
Route::get('/register', fn () => view('frontend.register'))->name('register');

/*
|--------------------------------------------------------------------------
| REKOMENDASI (USER – VIEW ONLY)
|--------------------------------------------------------------------------
*/
Route::get('/rekomendasi', function () {
    return view('frontend.rekomendasi', [
        'rekomendasis' => Rekomendasi::latest()->get()
    ]);
})->name('rekomendasi');

/*
|--------------------------------------------------------------------------
| REGISTER
|--------------------------------------------------------------------------
*/
Route::post('/register', function (Request $request) {

    $request->validate([
        'name'     => 'required|string|max:100',
        'email'    => 'required|email|unique:users',
        'password' => 'required|min:6',
    ]);

    User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => Hash::make($request->password),
        'role'     => 'user',
    ]);

    return redirect('/login')->with('success', 'Akun berhasil dibuat');
>>>>>>> 9355417c7faa822932c453e26ca20dc29b33da27
});


/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/
Route::post('/login', function (Request $request) {

    $credentials = $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    if (!Auth::attempt($credentials)) {
        return back()->with('error', 'Email atau password salah');
    }

    $request->session()->regenerate();

    return Auth::user()->role === 'admin'
        ? redirect('/admin')->with('success', 'Selamat datang Admin 👑')
        : redirect('/')->with('success', 'Login berhasil 👋');
});

/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:web', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {


        /* ================= SONG ================= */

Route::get('/songs', function () {
    return view('admin.songs-index', [
        'songs' => Song::with(['album.artist'])->get(),
    ]);
})->name('songs.index');

Route::get('/songs/create', function () {
    return view('admin.create-song', [
        'artists' => Artist::all(),
        'albums'  => Album::with('artist')->get(),
    ]);
})->name('songs.create');

Route::post('/songs', function (Request $request) {

    $request->validate([
        'title'    => 'required',
        'album_id' => 'required|exists:albums,id',
        'audio'    => 'required|mimes:mp3,wav',
    ]);

    $path = $request->file('audio')->store('songs', 'public');

    Song::create([
        'title'      => $request->title,
        'album_id'   => $request->album_id,
        'audio_path' => $path,
        'duration'   => 0,
    ]);

    return redirect()->route('admin.songs.index')
        ->with('success', 'Lagu berhasil ditambahkan');
})->name('songs.store');

Route::delete('/songs/{song}', function (Song $song) {

    if ($song->audio_path && Storage::disk('public')->exists($song->audio_path)) {
        Storage::disk('public')->delete($song->audio_path);
    }

    $song->delete();

    return back()->with('success', 'Lagu berhasil dihapus');
})->name('songs.destroy');

        

    Route::get('/', function () {
        return view('admin.dashboard', [
            'artists' => Artist::all(),
            'albums'  => Album::with('artist')->get(),
        ]);
    })->name('dashboard');

       // ✅ INI YANG DIBUTUHKAN OLEH route('admin.rekomendasi')
    Route::get('/rekomendasi', function () {
        return view('admin.rekomendasi', [
            'rekomendasis' => \App\Models\Rekomendasi::with('song')->latest()->get(),
            'songs' => \App\Models\Song::with('album.artist')->get(),
        ]);
    })->name('rekomendasi');

    Route::post('/rekomendasi', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'song_id'   => 'required|exists:songs,id',
            'judul'     => 'required',
            'artis'     => 'required',
            'photo'     => 'nullable|image',
            'deskripsi' => 'nullable',
        ]);

        $photo = $request->hasFile('photo')
            ? $request->file('photo')->store('rekomendasi', 'public')
            : null;

        \App\Models\Rekomendasi::create([
            'song_id'   => $request->song_id,
            'judul'     => $request->judul,
            'artis'     => $request->artis,
            'photo'     => $photo,
            'deskripsi' => $request->deskripsi,
        ]);

        return back()->with('success', 'Rekomendasi ditambahkan');
    })->name('rekomendasi.store');

    Route::delete('/rekomendasi/{rekomendasi}', function (\App\Models\Rekomendasi $rekomendasi) {
        if ($rekomendasi->photo) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($rekomendasi->photo);
        }
        $rekomendasi->delete();

        return back()->with('success', 'Rekomendasi dihapus');
    })->name('rekomendasi.destroy');

    /* ARTIST */
    Route::get('/artists/create', fn () => view('admin.create-artist'))->name('artists.create');
    Route::post('/artists', [AdminArtistController::class, 'store'])->name('artists.store');
    Route::get('/artists/{artist}', fn (Artist $artist) =>
        view('admin.artist-show', compact('artist'))
    )->name('artists.show');
    Route::get('/artists/{artist}/edit', [AdminArtistController::class, 'edit'])->name('artists.edit');
    Route::put('/artists/{artist}', [AdminArtistController::class, 'update'])->name('artists.update');
    Route::delete('/artists/{artist}', [AdminArtistController::class, 'destroy'])->name('artists.destroy');

    /* ALBUM */
    Route::get('/artists/{artist}/albums/create', [AlbumController::class, 'create'])->name('albums.create');
    Route::post('/artists/{artist}/albums', [AlbumController::class, 'store'])->name('albums.store');
    Route::get('/albums/{album}/edit', [AlbumController::class, 'edit'])->name('albums.edit');
    Route::put('/albums/{album}', [AlbumController::class, 'update'])->name('albums.update');
    Route::delete('/albums/{album}', [AlbumController::class, 'destroy'])->name('albums.destroy');
    });

/*
|--------------------------------------------------------------------------
| USER AUTH AREA
|--------------------------------------------------------------------------
*/
Route::middleware('auth:web')->group(function () {

    Route::get('/favorites', fn () => view('frontend.favorites'))->name('favorites');
    Route::get('/account', fn () => view('frontend.account'))->name('account');

    /* UPDATE PHOTO (FIXED) */
    Route::post('/account/update-photo', function (Request $request) {

        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        /** @var User $user */
        $user = Auth::user();

        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        $path = $request->file('photo')->store('profile', 'public');
        $user->update(['photo' => $path]);

        return back()->with('success', 'Foto profil berhasil diperbarui');
    });

    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');
});

/*
|--------------------------------------------------------------------------
| FAVORITE SYSTEM (AJAX)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:web')->prefix('web')->group(function () {

    Route::get('/favorites/list', function () {

        /** @var User $user */
        $user = Auth::user();

        $playlist = $user->playlists()
            ->where('name', 'Favorite')
            ->with('songs.album.artist')
            ->first();

        if (!$playlist) {
            return response()->json([]);
        }

        return response()->json(
            $playlist->songs->map(fn (Song $song) => [
                'id'          => $song->id,
                'title'       => $song->title,
                'audio_path'  => $song->audio_path,
                'artist_name' => optional($song->album->artist)->name,
            ])
        );
    });

    Route::post('/favorites/toggle/{song}', function (Song $song) {

        /** @var User $user */
        $user = Auth::user();

        $playlist = $user->playlists()
            ->firstOrCreate(['name' => 'Favorite']);

        if ($playlist->songs()->where('song_id', $song->id)->exists()) {
            $playlist->songs()->detach($song->id);
            return response()->json(['favorited' => false]);
        }

        $playlist->songs()->attach($song->id);
        return response()->json(['favorited' => true]);
    });

    Route::post('/favorites/remove/{song}', function (Song $song) {

    /** @var \App\Models\User $user */
    $user = Auth::user();

    $playlist = $user->playlists()
        ->where('name', 'Favorite')
        ->first();

    // Kalau playlist belum ada, langsung sukses (tidak error)
    if (!$playlist) {
        return response()->json(['success' => true]);
    }

    $playlist->songs()->detach($song->id);

    return response()->json(['success' => true]);
});


/*
|--------------------------------------------------------------------------
| TEST ACTIVITY LOG
|--------------------------------------------------------------------------
*/
Route::get('/test-activity', function () {

    DB::table('activity_logs')->insert([
        'user_id'    => Auth::id(),
        'action'     => 'TEST',
        'model'      => 'System',
        'model_id'   => null,
        'description'=> 'Test insert activity log',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return 'OK';
});
});