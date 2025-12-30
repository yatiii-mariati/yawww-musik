Route::get('/ping', function () {
    return response()->json([
        'message' => 'API Yaww Musik Ready'
    ]);
});
