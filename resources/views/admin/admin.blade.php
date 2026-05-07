<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - BPS Kalsel</title>
    <link rel="icon" type="image/png" href="/logo_bps.png">
    
    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    {{-- Vite Assets --}}
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
</head>
<body>

{{-- Navbar Component --}}
@include('admin.navbar')

{{-- Tabs Navigation --}}
@include('admin.tabs')

{{-- Upload Tab --}}
@include('admin.upload-tab')

{{-- Kelola Tab --}}
@include('admin.kelola-tab', ['konten' => $konten])

{{-- Playlist Tab --}}
@include('admin.playlist-tab', ['playlists' => $playlists])

{{-- Preview Tab --}}
@include('admin.preview-tab')

{{-- Playlist Detail --}}
@include('admin.playlist-detail')

{{-- Popups --}}
@include('admin.popups', ['playlists' => $playlists])

</body>
</html>