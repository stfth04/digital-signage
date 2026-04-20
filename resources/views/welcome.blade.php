<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tayangan Seputar BPS</title>
    <link rel="icon" type="image/png" href="/logo_bps.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
 body {
    margin: 0;
    background: black;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* FRAME UTAMA (portrait) */
#player {
    aspect-ratio: 9 / 16;
    height: 100vh;
    max-width: calc(100vh * 9 / 16);
    background: black;

    display: flex;
    justify-content: center;
    align-items: center;
}

video, img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}
    </style>
</head>
<body>

<div id="player"></div>

@auth
    <button id="btnStop"
        style="position:fixed;top:10px;right:10px;z-index:999">
        ⏹ STOP
    </button>
@else
    <button
        onclick="window.location.href='/login'"
        style="position:fixed;top:10px;right:10px;z-index:999">
        LOGIN
    </button>
@endauth

<script>
    window.PLAYLIST = @json($contents ?? []);
</script>

@vite('resources/js/player.js')

</body>
</html>
