<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin</title>
    <link rel="icon" type="image/png" href="/logo_bps.png">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* (CSS persis seperti yang kamu kirim) */
        /* ---------- General ---------- */
        body {
            background-color: #f2f6fa;
            font-family: 'Poppins', sans-serif;
        }

        .navbar {
            background-color: #286090;
            color: white;
        }

        .navbar a {
            color: white !important;
            text-decoration: none;
        }

        /* ---------- Upload area ---------- */
        .upload-area {
            border-radius: 20px;
            background: #ffffff;
            border: 2px dashed #cbd5e0;
            text-align: center;
            padding: 60px 40px;
            transition: all 0.3s ease;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
            position: relative;
        }

        .upload-area:hover {
            border-color: #336F97;
            background: #f8fafc;
        }

        .icon-upload {
            margin-bottom: 20px;
        }

        /* ---------- Form controls ---------- */
        .form-control,
        .form-select {
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            padding: 12px 15px;
            background-color: #ffffff;
            font-size: 14px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #336F97;
            box-shadow: 0 0 0 3px rgba(51, 111, 151, 0.1);
            background-color: #ffffff;
        }

        .upload-section {
            padding-right: 40px;
        }

        /* ---------- Buttons ---------- */
        .btn-simpan {
            background-color: #47d160;
            border: none;
            border-radius: 20px;
            color: white;
            width: 150px;
            padding: 8px 40px;
            font-size: 14px;
        }

        .btn-simpan:hover {
            background-color: #3cb155;
        }

        .btn-aksi {
            background: none;
            border: none;
            color: #f7941d;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-aksi:hover {
            text-decoration: underline;
        }

        /* ---------- Playlist styles ---------- */
        .btn-add-playlist {
            background-color: #5a5555;
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            border: none;
            font-size: 16px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .playlist-btn-wrapper {
            margin-bottom: 20px;
            margin-top: 10px;
            margin-left: 30px;
        }

        .popup-playlist-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .popup-playlist-box {
            background: #e5eff6;
            padding: 30px;
            width: 350px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        .popup-title {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .popup-input {
            width: 100%;
            padding: 10px 15px;
            border-radius: 25px;
            border: none;
            background: #d9d9d9;
            margin-bottom: 20px;
        }

        .btn-buat-playlist {
            background: #206486;
            color: white;
            border: none;
            padding: 10px 30px;
            border-radius: 25px;
            font-size: 16px;
            cursor: pointer;
            font-weight: 600;
        }

        .btn-buat-playlist:hover {
            background: #1a4f6a;
        }

        .playlist-card {
            width: 150px;
            background: #ffffff;
            border-radius: 10px;
            padding: 10px;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.15);
            text-align: center;
            font-size: 14px;
            margin-left: 30px;
            cursor: pointer;
        }

        .playlist-thumb {
            width: 100%;
            height: 100px;
            background: #bdbdbd;
            border-radius: 6px;
            margin-bottom: 8px;
        }

        .playlist-detail {
            background: #dfe9f0;
            padding: 40px;
            border-radius: 10px;
            margin-top: 20px;
        }

        .playlisttitle {
            font-size: 24px;
            font-weight: 600;
            margin-top: -34px;
            margin-left: 127px;
        }

        .playlist-detail-buttons {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            margin: 5px 0 5px 0;
            margin-left: 850px;
            margin-top: -40px
        }

        .btn-play-all,
        .btn-add-content {
            background: #206486;
            color: white;
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 14px;
            width: auto;
            min-width: 150px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-play-all:hover,
        .btn-add-content:hover {
            background: #1a4f6a;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .playlist-empty {
            color: #8c8c8c;
            margin-top: 100px;
            text-align: center;
            font-size: 16px;
        }

        /* ---------- Table ---------- */
        .table-container {
            background-color: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .table {
            border-collapse: separate;
            border-spacing: 0 10px;
            border: none;
        }

        .table thead th {
            background-color: #f8f9fa !important;
            color: #495057 !important;
            border: none;
            padding: 15px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }

        .table tbody tr {
            background-color: #ffffff;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.02);
        }

        .table tbody tr:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            background-color: #fcfcfc;
        }

        .table td {
            border: none;
            padding: 20px 15px;
            background-color: transparent !important;
        }

        .table td:first-child {
            border-top-left-radius: 12px;
            border-bottom-left-radius: 12px;
        }

        .table td:last-child {
            border-top-right-radius: 12px;
            border-bottom-right-radius: 12px;
        }

        .content-thumbnail,
        .content-video {
            width: 120px;
            height: 70px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #000;
        }

        .is-portrait {
            width: 70px !important;
            height: 110px !important;
        }

        /* ---------- Badges ---------- */
        .badge-kind {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge-video {
            background-color: #e3f2fd;
            color: #1976d2;
        }

        .badge-image {
            background-color: #f1f8e9;
            color: #388e3c;
        }

        .badge-res {
            background-color: #fff3e0;
            color: #e65100;
        }

        .badge-orient {
            background-color: #f3e5f5;
            color: #7b1fa2;
        }

        /* small helpers */
        .d-none {
            display: none !important;
        }

        .btn-back {
            width: 43px;
            height: 43px;
            cursor: pointer;
            margin-left: 60px;
            margin-top: 22px;
        }

        .item-box {
            position: relative;
            margin-top: 28px;
            margin-right: 35px;
        }

        .more-menu {
            position: absolute;
            top: 10px;
            right: 0;
            background: #e9f1f8;
            border-radius: 18px;
            padding: 10px 0;
            width: 250px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 999;
        }

        .more-item {
            padding: 10px 20px;
            font-size: 18px;
            cursor: pointer;
        }

        .more-item:hover {
            background: rgba(0, 0, 0, 0.05);
        }

        .d-none {
            display: none !important;
        }

        .icon-more {
            position: absolute;
            top: -68px;
            /* 👉 naikkan ke atas */
            right: 10px;
            width: 35px;
        }

        /* POPUP WRAPPER */
        .popup-jadwal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.35);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        /* BOX */
        .jadwal-box {
            width: 430px;
            background: #e8f3fc;
            border-radius: 18px;
            padding: 25px 30px;
            box-shadow: 0 8px 26px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        /* TITLE */
        .jadwal-title {
            font-size: 20px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 25px;
        }

        /* INPUT ROW */
        .jadwal-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        /* INPUT COLUMN */
        .jadwal-col {
            width: 47%;
            text-align: center;
        }

        .jadwal-col label {
            display: block;
            font-weight: 600;
            font-size: 17px;
            margin-bottom: 8px;
        }

        /* INPUT WRAPPER */
        .jadwal-input {
            position: relative;
            background: #d9d9d9;
            border-radius: 20px;
            padding: 8px 12px;
        }

        .jadwal-input input {
            width: 100%;
            border: none;
            background: transparent;
            font-size: 15px;
            text-align: center;
            outline: none;
            padding-right: 35px;
            font-weight: 500;
        }

        /* ICON */
        .icon-calendar {
            position: absolute;
            width: 20px;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            opacity: 0.7;
        }

        /* DIVIDER */
        .divider {
            margin: 18px 0;
            opacity: 0.4;
        }

        /* BUTTON WRAPPER */
        .jadwal-actions {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }

        /* BATAL BUTTON */
        .btn-cancel {
            width: 50%;
            padding: 9px 0;
            background: #d9d9d9;
            border: none;
            border-radius: 18px;
            font-weight: 600;
            cursor: pointer;
        }

        .preview-player {
            width: 100%;
            height: 450px;
            background: #000;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            overflow: hidden;
            position: relative;
        }

        .preview-player.mode-landscape-preview {
            aspect-ratio: 16 / 9;
            height: auto;
            max-height: 450px;
        }

        .preview-player.mode-portrait-preview {
            aspect-ratio: 9 / 16;
            width: auto;
            height: 450px;
            margin: 0 auto;
        }

        .preview-player video,
        .preview-player img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .preview-placeholder {
            color: #aaa;
        }


        /* SIMPAN BUTTON */
        .btn-save {
            width: 50%;
            padding: 9px 0;
            background: #206486;
            color: white;
            border: none;
            border-radius: 18px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-save:hover {
            opacity: 0.9;
        }

        /* OVERLAY */
        .popup-ganti {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.35);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        /* BOX */
        .ganti-box {
            width: 430px;
            background: #e8f3fc;
            border-radius: 18px;
            padding: 25px 30px;
            box-shadow: 0 8px 26px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        /* TITLE */
        .ganti-title {
            font-size: 20px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 25px;
        }

        /* INPUT WRAPPER */
        .ganti-input-wrap {
            background: #d9d9d9;
            border-radius: 20px;
            padding: 12px 18px;
            margin-bottom: 20px;
            position: relative;
        }

        .ganti-input-wrap label {
            display: block;
            font-weight: 600;
            font-size: 17px;
            margin-bottom: 8px;
        }

        .ganti-input {
            width: 100%;
            border: none;
            background: transparent;
            font-size: 16px;
            outline: none;
            text-align: center;
            font-weight: 500;
        }

        /* DIVIDER */
        .divider {
            margin: 18px 0;
            opacity: 0.4;
        }

        /* BUTTON WRAPPER */
        .ganti-actions {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }

        /* CANCEL BUTTON */
        .btn-cancel {
            width: 50%;
            padding: 9px 0;
            background: #d9d9d9;
            border: none;
            border-radius: 18px;
            font-weight: 600;
            cursor: pointer;
        }

        /* SAVE BUTTON */
        .btn-save {
            width: 50%;
            padding: 9px 0;
            background: #206486;
            color: white;
            border: none;
            border-radius: 18px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-save:hover {
            opacity: 0.9;
        }


        /* ===== POPUP HAPUS (BARU, MENYAMAI JADWAL & GANTI NAMA) ===== */
        .popup-hapus {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.35);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .hapus-box {
            width: 430px;
            background: #e8f3fc;
            /* sama seperti popup lain */
            border-radius: 18px;
            padding: 30px 35px;
            box-shadow: 0 8px 26px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .hapus-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #1a1a1a;
        }

        .hapus-text {
            font-size: 17px;
            color: #333;
            margin-bottom: 30px;
        }

        /* TOMBOL */
        .hapus-actions {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }

        .btn-hapus-cancel {
            width: 50%;
            padding: 10px 0;
            border: none;
            border-radius: 18px;
            background: #d9d9d9;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-hapus-yes {
            width: 50%;
            padding: 10px 0;
            border: none;
            border-radius: 18px;
            background: #206486;
            color: white;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-hapus-yes:hover {
            opacity: 0.9;
        }

        /* pop up select playlist */
        /* Popup Select Playlist - Improved Design */
        .d-none {
            display: none;
        }

        #popupPilihPlaylist {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            backdrop-filter: blur(4px);
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .popup-box {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
            padding: 25px;
            border-radius: 16px;
            width: 90%;
            max-width: 500px;
            max-height: 80vh;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: slideUp 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.1);
            display: flex;
            flex-direction: column;
        }

        @keyframes slideUp {
            from {
                transform: translateY(40px) scale(0.95);
                opacity: 0;
            }

            to {
                transform: translateY(0) scale(1);
                opacity: 1;
            }
        }

        .popup-box h3 {
            margin: 0 0 20px 0;
            color: #2c3e50;
            font-size: 22px;
            font-weight: 600;
            padding-bottom: 15px;
            border-bottom: 2px solid rgba(52, 152, 219, 0.2);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .popup-box h3:before {
            font-size: 20px;
        }

        #playlistList {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 12px;
            overflow-y: auto;
            padding: 10px 5px;
            margin-bottom: 20px;
            flex: 1;
        }

        .playlist-card {
            background: white;
            border-radius: 12px;
            padding: 15px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid transparent;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
            overflow: hidden;
        }

        .playlist-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(52, 152, 219, 0.15);
            border-color: rgba(52, 152, 219, 0.3);
        }

        .playlist-card.selected-playlist {
            border-color: #3498db;
            background: linear-gradient(135deg, #e3f2fd 0%, #f0f8ff 100%);
            box-shadow: 0 8px 25px rgba(52, 152, 219, 0.2);
        }

        .playlist-card.selected-playlist:after {
            content: "✓";
            position: absolute;
            top: 8px;
            right: 8px;
            background: #3498db;
            color: white;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
        }

        .playlist-thumb {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            background: linear-gradient(135deg, #3498db, #2ecc71);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            flex-shrink: 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .playlist-card:nth-child(2n) .playlist-thumb {
            background: linear-gradient(135deg, #9b59b6, #e74c3c);
        }

        .playlist-card:nth-child(3n) .playlist-thumb {
            background: linear-gradient(135deg, #f39c12, #e67e22);
        }

        .playlist-info {
            flex: 1;
            min-width: 0;
        }

        .playlist-title {
            margin: 0;
            font-weight: 600;
            color: #2c3e50;
            font-size: 15px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .playlist-card:hover .playlist-title {
            color: #3498db;
        }

        .popup-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            padding-top: 20px;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }

        .popup-actions button {
            padding: 12px 28px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .popup-actions button:first-child {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
        }

        .popup-actions button:first-child:hover {
            background: linear-gradient(135deg, #2980b9, #1f639b);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(52, 152, 219, 0.3);
        }

        .popup-actions button:last-child {
            background: transparent;
            color: #7f8c8d;
            border: 2px solid #e0e0e0;
        }

        .popup-actions button:last-child:hover {
            background: #f8f9fa;
            color: #2c3e50;
            border-color: #bdc3c7;
        }

        /* Scrollbar Styling */
        #playlistList::-webkit-scrollbar {
            width: 6px;
        }

        #playlistList::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 10px;
        }

        #playlistList::-webkit-scrollbar-thumb {
            background: rgba(52, 152, 219, 0.3);
            border-radius: 10px;
        }

        #playlistList::-webkit-scrollbar-thumb:hover {
            background: rgba(52, 152, 219, 0.5);
        }

        /* Loading state for dynamic content */
        .playlist-card.loading {
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.6;
            }

            100% {
                opacity: 1;
            }
        }

        /* Empty state */
        #playlistList:empty:before {
            content: "Belum ada playlist yang tersedia";
            color: #95a5a6;
            text-align: center;
            padding: 40px;
            font-style: italic;
            width: 100%;
            display: block;
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .popup-box {
                width: 95%;
                padding: 20px;
            }

            #playlistList {
                grid-template-columns: 1fr;
            }

            .popup-actions {
                flex-direction: column;
            }

            .popup-actions button {
                width: 100%;
            }
        }

        .modal-custom {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .35);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .modal-box {
            background: #f5f7fa;
            border-radius: 16px;
            width: 380px;
            padding: 20px 22px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .15);
        }

        /* HEADER */
        .modal-header {
            position: relative;
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        /* Judul benar-benar center */
        .modal-header h4 {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            margin: 0;
            font-size: 16px;
            font-weight: 600;
            text-align: center;
        }

        /* Tombol close tetap kanan */
        .modal-close {
            margin-left: auto;
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
        }


        /* BODY */
        .modal-body {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .label {
            font-size: 13px;
            color: #555;
        }

        .input-text {
            background: #e0e0e0;
            border: none;
            border-radius: 10px;
            padding: 8px 12px;
        }

        /* TIME INPUT */
        .time-inputs {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .time-inputs input {
            width: 60px;
            text-align: center;
            padding: 8px;
            border-radius: 10px;
            border: none;
            background: #e0e0e0;
            font-size: 14px;
        }

        .time-inputs span {
            font-weight: bold;
        }

        /* ACTIONS */
        .modal-actions {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-top: 18px;
        }

        .btn-cancel {
            background: #dcdcdc;
            border: none;
            padding: 8px 22px;
            border-radius: 20px;
            cursor: pointer;
        }

        .btn-save {
            background: #2b6f9e;
            color: #fff;
            border: none;
            padding: 8px 26px;
            border-radius: 20px;
            cursor: pointer;
        }

        /* ICON PENSIL */
        .btn-edit-duration {
            margin-left: 8px;
            border: none;
            background: none;
            font-size: 14px;
            cursor: pointer;
        }

        .input-duration {
            width: 100%;
            padding: 8px 18px;
            border-radius: 999px;
            /* bikin pill */
            border: none;
            background: #e5e5e5;
            /* mirip tombol batal */
            text-align: center;
            font-size: 14px;
            font-weight: 500;
            outline: none;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg px-4 py-3" style="background-color: #336F97;">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <img src="/logo_bps.png" alt="Logo" width="80" class="me-2">
                <div class="text-white">
                    <strong>BADAN PUSAT STATISTIK</strong><br>
                    PROVINSI KALIMANTAN SELATAN
                </div>
            </div>

            <div class="ms-auto text-end text-white me-3">
                <div id="time"></div>
                <div id="date"></div>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-light btn-sm ms-3 rounded-pill d-flex align-items-center gap-2">
                    <img src="/logout.png" alt="Logout Icon" width="18" height="18"> Log Out
                </button>
            </form>
        </div>
    </nav>

    <script>
        function updateDateTime() {
            const now = new Date();

            // ambil waktu UTC
            const utcHours = now.getUTCHours();
            const minutes = now.getUTCMinutes();

            // WITA = UTC + 8
            const witaHours = (utcHours + 8) % 24;

            const hours = witaHours.toString().padStart(2, '0');
            const mins = minutes.toString().padStart(2, '0');

            // tanggal dalam indonesia
            const options = {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            };

            // generate tanggal normal (pakai waktu lokal)
            const dateString = now.toLocaleDateString('id-ID', options);

            document.getElementById('time').textContent = `${hours}:${mins} WITA`;
            document.getElementById('date').textContent = dateString;
        }

        updateDateTime();
        setInterval(updateDateTime, 1000);
    </script>

    <!-- Tabs -->
    <div style="background-color: #336F97; color: white; border-top: 5px solid #8DBEDE;">
        <div class="container d-flex justify-content-start gap-4 py-3">
            <a href="#" class="text-white fw-bold text-decoration-none active-tab"
                onclick="showTab('upload', event)">Upload File</a>
            <a href="#" class="text-white text-decoration-none" onclick="showTab('kelola', event)">Kelola
                Konten</a>
            <a href="#" class="text-white text-decoration-none" onclick="showTab('playlist', event)">Playlist</a>
            <a href="#" class="text-white text-decoration-none" onclick="showTab('preview', event)">Preview</a>
        </div>
    </div>

    {{-- ========================= UPLOAD TAB ========================= --}}
    <div id="upload" class="tab-content {{ session('show_tab', 'upload') == 'upload' ? '' : 'd-none' }}">
        <div class="container mt-4">
            <form action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row align-items-start">
                    <!-- Upload column -->
                    <div class="col-md-7 upload-section">
                        <h5 class="mb-4"><strong>Upload File</strong></h5>

                        <div class="upload-area d-flex flex-column align-items-center justify-content-center"
                            id="uploadArea">
                            <div class="icon-upload" id="iconArea">
                                <img src="{{ asset('icon.png') }}" alt="Upload Icon" width="80" style="opacity: 0.6;">
                            </div>

                            <div id="uploadTextContainer">
                                <p id="uploadText" class="mb-1" font-weight="600">Klik atau seret file ke area ini</p>
                                <p class="text-muted small">Mendukung format Gambar dan Video (Maks. 20MB)</p>
                            </div>

                            <img id="previewImage" src="" alt=""
                                style="display:none; max-width: 100%; max-height: 300px; object-fit: contain; border-radius:12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
                            <video id="previewVideo" controls
                                style="display:none; max-width: 100%; max-height: 300px; border-radius:12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);"></video>

                            <input type="file" name="file" id="fileInput" hidden accept="image/*,video/*">
                        </div>
                    </div>

                    <!-- Properti column -->
                    <div class="col-md-5 ps-md-4">
                        <div class="card border-0 shadow-sm rounded-4 p-4">
                            <h6 class="mb-4 text-primary"><strong>Properti Konten</strong></h6>

                            <div class="mb-3">
                                <label for="nama_file" class="form-label text-secondary small fw-bold">NAMA FILE</label>
                                <input type="text" id="nama_file" name="nama_file" class="form-control"
                                    placeholder="Masukkan judul konten" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="resolusi"
                                        class="form-label text-secondary small fw-bold">RESOLUSI</label>
                                    <input type="text" id="resolusi" name="resolusi" class="form-control"
                                        placeholder="Otomatis terdeteksi" readonly>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="orientasi"
                                        class="form-label text-secondary small fw-bold">ORIENTASI</label>
                                    <select id="orientasi" name="orientasi" class="form-select">
                                        <option>Landscape</option>
                                        <option>Portrait</option>
                                    </select>
                                </div>
                            </div>

                            <div class="btn-area">
                                <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold shadow-sm">
                                    Simpan Konten
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- ========================= PILIH PLAYLIST ========================= --}}
    <div id="popupPilihPlaylist" class="d-none">
        <div class="popup-box">
            <h3>Pilih Playlist</h3>
            <div id="playlistList" class="d-flex flex-wrap gap-3 mt-3">
                @foreach ($playlists as $playlist)
                    <div class="playlist-card" data-id="{{ $playlist->id }}"
                        onclick="selectPlaylist({{ $playlist->id }}, this)">
                        <div class="playlist-thumb">
                            @if (isset($playlist->thumbnail) && $playlist->thumbnail)
                                <img src="{{ $playlist->thumbnail }}" alt="{{ $playlist->nama_playlist }}"
                                    style="width:100%;height:100%;object-fit:cover;border-radius:8px;">
                            @else
                                {{ substr($playlist->nama_playlist, 0, 1) }}
                            @endif
                        </div>
                        <div class="playlist-info">
                            <p class="playlist-title">{{ $playlist->nama_playlist }}</p>
                            @if (isset($playlist->jumlah_content))
                                <small style="color:#7f8c8d;font-size:12px;">{{ $playlist->jumlah_content }}
                                    lagu</small>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="popup-actions mt-3">
                <button onclick="submitAddToPlaylist()" id="submitBtn">TAMBAH KE PLAYLIST</button>
                <button onclick="closePopupPlaylist()">BATAL</button>
            </div>
        </div>
    </div>

    {{-- ========================= PREVIEW TAB ========================= --}}
    <div id="preview" class="tab-content d-none">
        <div class="container mt-4">
            <div id="previewPlayer" class="preview-player">
                <span class="preview-placeholder">Klik tab Preview</span>
            </div>
        </div>
    </div>

    {{-- ======================= END PREVIEW TAB ======================= --}}



    {{-- ========================= KELOLA TAB ========================= --}}

    <div id="kelola" class="tab-content {{ session('show_tab') == 'kelola' ? '' : 'd-none' }}">
        <div class="container mt-5">
            <div class="table-container">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No/ID</th>
                            <th>Konten</th>
                            <th>Jenis Konten</th>
                            <th>Resolusi</th>
                            <th>Orientasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($konten as $item)
                            <tr>
                                <td class="fw-bold text-secondary">#{{ $loop->iteration }}</td>
                                <td class="text-start">
                                    <div class="d-flex align-items-center gap-3">
                                        @php
                                            $ext = strtolower(pathinfo($item->file ?? '', PATHINFO_EXTENSION));
                                        @endphp

                                        @if (in_array($ext, ['mp4', 'mov', 'avi', 'mkv', 'webm']))
                                            <video src="{{ asset('storage/' . $item->file) }}"
                                                class="content-video {{ strtolower($item->orientasi) == 'portrait' ? 'is-portrait' : '' }}"></video>
                                        @else
                                            <img src="{{ asset('storage/' . $item->file) }}"
                                                class="content-thumbnail {{ strtolower($item->orientasi) == 'portrait' ? 'is-portrait' : '' }}">
                                        @endif

                                        <div>
                                            <div class="fw-bold text-dark">{{ $item->nama_file }}</div>
                                            <small class="text-muted">{{ basename($item->file) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge-kind {{ $item->jenis == 'Video' ? 'badge-video' : 'badge-image' }}">
                                        {{ $item->jenis }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge-kind badge-res">
                                        {{ $item->resolusi ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge-kind badge-orient">
                                        {{ $item->orientasi ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-sm btn-outline-success rounded-pill px-3"
                                            onclick="playSingleItem('{{ $item->file }}', '{{ $item->orientasi }}')">
                                            Putar
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                            onclick="window.selectedKontenId={{ $item->id }}; openPopupPlaylist();">
                                            + Playlist
                                        </button>

                                        <form action="{{ route('contents.destroy', $item->id) }}" method="POST"
                                            style="display:inline;" onsubmit="return confirm('Hapus konten ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger rounded-pill px-3">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ================= PLAYLIST TAB ================= -->
    <div id="playlist" class="tab-content">

        <div class="playlist-btn-wrapper">
            <button class="btn-add-playlist">+ Playlist</button>
        </div>

        <div id="playlistListMain" class="d-flex flex-wrap gap-3 mt-3">
            @foreach ($playlists as $playlist)
                <div class="playlist-card" data-id="{{ $playlist->id }}">

                    <div class="playlist-thumb">
                        @if (!empty($playlist->thumb_auto))
                            <img src="{{ asset($playlist->thumb_auto) }}" alt="{{ $playlist->nama_playlist }}"
                                class="playlist-thumb-img">
                        @else
                            <div class="playlist-thumb-empty">
                                {{ strtoupper(substr($playlist->nama_playlist, 0, 1)) }}
                            </div>
                        @endif
                    </div>

                    <div class="playlist-info">
                        <div class="playlist-title">
                            {{ $playlist->nama_playlist }}
                        </div>
                    </div>

                </div>
            @endforeach
        </div>


        <!-- Popup tambah playlist (BOLEH DI SINI) -->
        <div id="popupPlaylist" class="popup-playlist-overlay d-none">
            <div class="popup-playlist-box">
                <h3 class="popup-title">Beri nama playlist</h3>

                <input type="text" id="playlistTitle" class="popup-input" placeholder="Judul">

                <form action="{{ route('playlist.store') }}" method="POST" id="formPlaylist">
                    @csrf
                    <input type="hidden" id="judul_playlist" name="judul">

                    <button type="submit" class="btn-buat-playlist">BUAT</button>
                    <button type="button" onclick="closePopupAddPlaylist()">BATAL</button>
                </form>
            </div>
        </div>

    </div>
    <!-- ================= END PLAYLIST TAB ================= -->


    <!-- ================= PLAYLIST DETAIL (WAJIB DI LUAR) ================= -->
    <div id="playlistDetail" class="tab-content d-none">

        <div id="playlistDetailContent">
            <h2>Detail Playlist</h2>
            <p>Konten playlist akan muncul di sini</p>
        </div>

    </div>
    <!-- ================= END PLAYLIST DETAIL ================= -->



    {{-- ========================= SCRIPTS (single place) ========================= --}}
    <script>
        // showTab helper (keperluan navbar tabs)
        // showTab helper (navbar tabs)
        function showTab(tabId, event) {
            if (event) event.preventDefault();

            // sembunyikan semua tab
            document.querySelectorAll('.tab-content')
                .forEach(el => el.classList.add('d-none'));

            // tampilkan tab tujuan
            const tab = document.getElementById(tabId);
            if (tab) tab.classList.remove('d-none');

            // highlight active tab
            document.querySelectorAll('.container.d-flex a')
                .forEach(a => a.classList.remove('active-tab'));

            if (event && event.target) {
                event.target.classList.add('active-tab');
            }

            // 🔥 KHUSUS PREVIEW (Hanya reload jika tidak sedang memutar item tunggal)
            if (tabId === 'preview' && typeof loadActivePreview === 'function' && !window.skipAutoReload) {
                loadActivePreview();
            }
        }


        // openTab for programmatic navigation (used by server side session show_tab)
        function openTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('d-none'));
            document.getElementById(tabId).classList.remove('d-none');
        }


        function addToPlaylist(kontenId) {
            const playlistSelect = document.querySelector('#default-playlist-id');
            if (!playlistSelect || !playlistSelect.value) {
                alert('Silakan pilih playlist terlebih dahulu!');
                return;
            }

            const playlistId = playlistSelect.value;
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch('/playlist-content-add', {
                method: 'POST',
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": token
                },
                body: JSON.stringify({
                    konten_id: kontenId,
                    playlist_id: playlistId
                })
            })
                .then(res => {
                    if (!res.ok) throw new Error('Server error');
                    return res.json();
                })
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                    } else {
                        alert(data.error ?? 'Gagal menambahkan konten');
                    }
                })
                .catch(err => {
                    alert('Gagal menambahkan konten ke playlist');
                });

        }


        // OPEN
        function openJadwal() {
            document.getElementById("popupJadwal").classList.remove("d-none");
        }

        // CLOSE
        function closeJadwal() {
            document.getElementById("popupJadwal").classList.add("d-none");
        }

        // SAVE
        function saveJadwal() {
            const mulai = document.getElementById("tglMulai").value;
            const selesai = document.getElementById("tglSelesai").value;

            if (!mulai || !selesai) {
                alert("Tanggal tidak boleh kosong!");
                return;
            }

            console.log("Mulai:", mulai);
            console.log("Selesai:", selesai);

            closeJadwal();
        }

        let activePlaylistId = null;

        function openGanti(id, nama) {
            activePlaylistId = id;
            document.getElementById("namaBaru").value = nama;
            document.getElementById("popupGanti").classList.remove("d-none");
        }

        function closeGanti() {
            document.getElementById("popupGanti").classList.add("d-none");
        }

        function saveGanti() {
            let nama = document.getElementById("namaBaru").value.trim();
            if (nama === "" || !activePlaylistId) return;

            fetch("{{ route('playlist.updateName') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    id: activePlaylistId,
                    nama_playlist: nama
                })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        // Update nama pada card tanpa reload
                        location.reload();
                    }
                    closeGanti();
                })
                .catch(err => console.error(err));
        }

        // =========== GLOBAL POPUP HAPUS ===========

        // Menyimpan ID playlist yang ingin dihapus
        let deleteId = null;

        // Tampilkan popup hapus
        function openHapus(id, name) {
            deleteId = id;

            document.getElementById("hapusText").innerText =
                `Yakin ingin menghapus playlist "${name}"?`;

            document.getElementById("popupHapus").classList.remove("d-none");
        }

        // Tutup popup hapus
        function closeHapus() {
            deleteId = null;
            document.getElementById("popupHapus").classList.add("d-none");
        }

        // Konfirmasi hapus
        function confirmHapus() {
            if (!deleteId) return;

            fetch(`/playlist/${deleteId}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                }
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const card = document.querySelector(
                            `.playlist-card[data-id="${deleteId}"]`
                        );
                        if (card) card.remove();

                        closeHapus();
                        openTab('playlist');
                    } else {
                        alert(data.message);
                    }
                })
                .catch(err => console.error(err));
        }

        document
            .querySelector('#playlist')
            .addEventListener('click', function (e) {

                const card = e.target.closest('.playlist-card');
                if (!card) return;

                const playlistId = card.dataset.id;
                if (!playlistId) return;

                loadPlaylistDetail(playlistId);

                document.getElementById('playlist').classList.add('d-none');
                document.getElementById('playlistDetail').classList.remove('d-none');
            });

        // escape HTML helper
        function escapeHtml(unsafe) {
            return String(unsafe)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        // popup add playlist: sync hidden input before submission
        document.querySelector('#formPlaylist')?.addEventListener('submit', function (e) {
            const title = document.getElementById('playlistTitle').value.trim();
            if (!title) {
                e.preventDefault();
                alert('Masukkan judul playlist.');
                return false;
            }
            document.getElementById('judul_playlist').value = title;
        });

        // make "BUAT" button also fill hidden input if user clicks button outside form (older logic)
        document.querySelector('.btn-buat-playlist')?.addEventListener('click', function () {
            document.getElementById('judul_playlist').value = document.getElementById('playlistTitle').value || '';
        });

        // Upload area interactions: click zone triggers hidden input
        document.getElementById('uploadArea')?.addEventListener('click', function () {
            document.getElementById('fileInput').click();
        });

        // Preview image/video for selected file
        document.getElementById('fileInput')?.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (e) {
                const previewImg = document.getElementById('previewImage');
                const previewVid = document.getElementById('previewVideo');
                const textContainer = document.getElementById('uploadTextContainer');
                const iconArea = document.getElementById('iconArea');

                if (iconArea) iconArea.style.display = 'none';
                if (textContainer) textContainer.style.display = 'none';

                if (file.type.startsWith('image/')) {
                    previewVid.style.display = 'none';
                    previewImg.style.display = 'block';
                    previewImg.src = e.target.result;

                    // Deteksi Resolusi Gambar
                    const tempImg = new Image();
                    tempImg.src = e.target.result;
                    tempImg.onload = function () {
                        document.getElementById('resolusi').value = this.width + 'x' + this.height;
                    };

                } else if (file.type.startsWith('video/')) {
                    previewImg.style.display = 'none';
                    previewVid.style.display = 'block';

                    previewVid.src = e.target.result;
                    previewVid.controls = true;

                    // Deteksi Resolusi Video
                    previewVid.onloadedmetadata = function () {
                        document.getElementById('resolusi').value = this.videoWidth + 'x' + this.videoHeight;
                    };

                    previewVid.load();
                }
            };
            reader.readAsDataURL(file);
        });

        // If server set show_tab in session, open that tab after DOM ready
        document.addEventListener('DOMContentLoaded', function () {
            @if (session('show_tab'))
                openTab("{{ session('show_tab') }}");
            @endif
        });

        // Fungsi toggle menu titik tiga
        function toggleMenu(el) {
            // Tutup semua menu lain agar tidak dobel
            document.querySelectorAll('.more-menu').forEach(menu => {
                if (menu !== el.parentElement.querySelector('.more-menu')) {
                    menu.classList.add('d-none');
                }
            });

            // Toggle menu pada item yang diklik
            const target = el.parentElement.querySelector('.more-menu');
            target.classList.toggle('d-none');
        }

        document.addEventListener('click', function (e) {
            const clickedInside = e.target.closest('.item-box');

            // Jika klik di luar item playlist
            if (!clickedInside) {
                document.querySelectorAll('.more-menu').forEach(menu => {
                    menu.classList.add('d-none');
                });
            }
        });
    </script>

    <!-- POPUP JADWAL -->
    <div class="popup-jadwal d-none" id="popupJadwal">

        <div class="jadwal-box">
            <h3 class="jadwal-title">Jadwal</h3>

            <div class="jadwal-row">
                <div class="jadwal-col">
                    <label>Mulai</label>
                    <div class="jadwal-input">
                        <input type="date" id="tglMulai">
                    </div>
                </div>

                <div class="jadwal-col">
                    <label>Selesai</label>
                    <div class="jadwal-input">
                        <input type="date" id="tglSelesai">
                    </div>
                </div>
            </div>

            <hr class="divider">

            <div class="jadwal-actions">
                <button class="btn-cancel" onclick="closeJadwal()">Batal</button>
                <button class="btn-save" onclick="saveJadwal()">Simpan</button>
            </div>
        </div>

    </div>

    <!-- POPUP GANTI NAMA -->
    <div class="popup-ganti d-none" id="popupGanti">

        <div class="ganti-box">
            <h3 class="ganti-title">Ganti Nama</h3>

            <div class="ganti-input-wrap">
                <label>Nama Baru</label>
                <input type="text" id="namaBaru" class="ganti-input" placeholder="Masukkan nama baru">
            </div>

            <div class="ganti-actions">
                <button class="btn-cancel" onclick="closeGanti()">Batal</button>
                <button class="btn-save" onclick="saveGanti()">Simpan</button>
            </div>
        </div>

    </div>

    <!-- POPUP HAPUS PLAYLIST -->
    <div class="popup-hapus d-none" id="popupHapus">
        <div class="hapus-box">
            <h3 class="hapus-title">Hapus Playlist</h3>

            <p id="hapusText" class="hapus-text">
                Yakin ingin menghapus playlist?
            </p>

            <div class="hapus-actions">
                <button class="btn-hapus-cancel" onclick="closeHapus()">TIDAK</button>
                <button class="btn-hapus-yes" onclick="confirmHapus()">YA</button>
            </div>
        </div>
    </div>

    <div class="popup-hapus d-none" id="popupTambahKePlaylist">
        <div class="hapus-box">
            <h3 class="hapus-title">Tambah Ke Playlist</h3>

            <p class="hapus-text">Pilih playlist untuk konten ini:</p>

            {{-- <div id="playlistList" style="text-align:left; margin-bottom:20px;">
                <!-- daftar playlist akan dimasukkan lewat JS -->
            </div> --}}

            <div class="hapus-actions">
                <button class="btn-hapus-cancel" onclick="closeTambahKePlaylist()">BATAL</button>
            </div>
        </div>
    </div>

    <div id="durationModal" class="modal-custom d-none">
        <div class="modal-box">

            <!-- Judul playlist (read-only) -->

            <div class="modal-header">
                <h4>Atur Durasi Konten</h4>
                <button class="modal-close" onclick="closeDurationModal()">×</button>
            </div>

            <div class="modal-body">
                <!-- Durasi -->
                <label class="label">Durasi (detik)</label>
                <input type="number" id="durationInput" min="1" class="input-duration" placeholder="Contoh: 10">
            </div>

            <div class="modal-actions">
                <button class="btn-cancel" onclick="closeDurationModal()">Batal</button>
                <button class="btn-save" onclick="saveDuration()">Simpan</button>
            </div>

        </div>
    </div>

    <!-- ====================== SCRIPT LOAD PLAYLIST DETAIL ====================== -->
    <script>
        async function loadPlaylistDetail(playlistId) {
            activePlaylistId = playlistId;
            try {
                const res = await fetch(`/admin/playlist/${playlistId}/content`);
                if (!res.ok) throw new Error('Gagal mengambil data');

                const data = await res.json();
                const playlist = data.playlist;
                const items = data.contents;

                let rows = '';

                if (items.length === 0) {
                    rows = `<p class="playlist-empty">Video atau Foto tidak ada</p>`;
                } else {
                    rows = `
            <div class="table-container mt-4">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Urutan</th>
                            <th>Konten</th>
                            <th>Durasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${items.map((item, i) => {
                        const isVideo = item.file.match(/\.(mp4|mov|avi|mkv|webm)$/i);
                        const orientasi = (item.orientasi || 'Landscape').toLowerCase();
                        const portraitClass = orientasi === 'portrait' ? 'is-portrait' : '';
                        const preview = isVideo
                            ? `<video src="/storage/${item.file}" class="content-video ${portraitClass}"></video>`
                            : `<img src="/storage/${item.file}" class="content-thumbnail ${portraitClass}">`;

                        return `
        <tr id="row-${item.pc_id}">
            <td>${i + 1}</td>
            <td>${preview}</td>
            <td>
                ${typeof item.duration === 'number' ? item.duration + 's' : '-'}
                ${item.jenis === 'Gambar' ? `
            <button class="btn-edit-duration"
                onclick="openDurationModal(${item.pc_id}, ${item.duration ?? 5})"
                title="Atur durasi">
                ✎
            </button>
        ` : ''}
            </td>
            <td>
                <button type="button"
                    class="btn-aksi text-primary me-2"
                    onclick="playSingleItem('${item.file}', '${item.orientasi}')">
                    Putar
                </button>
                <button type="button"
                    class="btn-aksi text-danger"
                    onclick="hapusKonten(${item.pc_id})">
                    Hapus
                </button>
            </td>
        </tr>
        `;
                    }).join('')}
                    </tbody>
                </table>
            </div>`;
                }

                document.getElementById('playlistDetailContent').innerHTML = `
                    <div class="playlist-header" style="position:relative;">

                        <img src="/logoback.png" class="btn-back" onclick="openTab('playlist')" />

                        <h2 class="playlisttitle">${escapeHtml(playlist.nama_playlist)}</h2>

                        <!-- ICON TITIK 3 -->
                        <div class="item-box">
                            <img src="/logotitik3.png"
                                class="icon-more"
                                onclick="toggleMenu(this)" />

                            <!-- MENU YANG MUNCUL -->
                            <div class="more-menu d-none">
                                <div class="more-item" onclick="openJadwal()">Jadwal</div>
                                <div class="more-item"
                                    onclick="openHapus(${playlist.id}, '${escapeHtml(playlist.nama_playlist)}')">
                                    Hapus Playlist
                                </div>
                                <div class="more-item"
                                    onclick="openGanti(${playlist.id}, '${escapeHtml(playlist.nama_playlist)}')">
                                    Ganti Nama
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="playlist-detail-buttons">
                        <button class="btn-play-all"
                             onclick="window.open('/play/${playlist.id}', '_blank')">
                            ► Putar Semua
                        </button>
                        <button class="btn-add-content" data-playlist-id="${playlist.id}">
                            Tambah Konten +
                        </button>
                    </div>
                    ${rows}
                `;

            } catch (err) {
                console.error(err);
                alert('Gagal memuat playlist');
            }
        }


        let selectedPlaylistId = null;

        function selectPlaylist(id, el) {
            selectedPlaylistId = id;

            // hapus highlight sebelumnya
            document.querySelectorAll('#popupPilihPlaylist .playlist-card')
                .forEach(card => card.classList.remove('selected-playlist'));

            // tandai yang dipilih
            el.classList.add('selected-playlist');

            console.log('Playlist dipilih:', selectedPlaylistId);
        }

        function openPopupPlaylist() {
            document.getElementById('popupPilihPlaylist').classList.remove('d-none');
        }

        function closePopupPlaylist() {
            document.getElementById('popupPilihPlaylist').classList.add('d-none');
        }

        function submitAddToPlaylist() {
            if (!selectedPlaylistId || !window.selectedKontenId) {
                alert("Silakan pilih playlist dan konten terlebih dahulu!");
                return;
            }

            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch('/playlist-content-add', {
                method: 'POST',
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": token
                },
                body: JSON.stringify({
                    playlist_id: selectedPlaylistId,
                    konten_id: window.selectedKontenId
                })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert('Konten berhasil ditambahkan ke playlist!');
                        closePopupPlaylist();
                        openTab('playlist');
                    } else {
                        alert(data.error);
                    }
                });
        }

        // Optional: Add keyboard support
        document.addEventListener('keydown', function (e) {
            const popup = document.getElementById('popupPilihPlaylist');
            if (!popup.classList.contains('d-none')) {
                if (e.key === 'Escape') {
                    closePopupPlaylist();
                }
                if (e.key === 'Enter' && document.querySelector('.selected-playlist')) {
                    submitAddToPlaylist();
                }
            }
        });

        // Optional: Add fade out animation
        function closePopupPlaylist() {
            const popup = document.getElementById('popupPilihPlaylist');
            popup.style.animation = 'fadeIn 0.3s ease reverse';
            setTimeout(() => {
                popup.classList.add('d-none');
                popup.style.animation = '';
            }, 200);
        }
        // add playlist 
        document.addEventListener('DOMContentLoaded', function () {
            const btnAddPlaylist = document.querySelector('.btn-add-playlist');
            const popupPlaylist = document.getElementById('popupPlaylist');

            if (btnAddPlaylist && popupPlaylist) {
                btnAddPlaylist.addEventListener('click', function () {
                    popupPlaylist.classList.remove('d-none');
                });
            }
        });

        function closePopupAddPlaylist() {
            document.getElementById('popupPlaylist').classList.add('d-none');
        }
        document.addEventListener('DOMContentLoaded', () => {
            showTab('upload');
        });
        // hapus konten dari playlist
        function hapusKonten(pc_id) {
            if (!confirm('Hapus konten ini dari playlist?')) return;

            fetch(`/playlist-content/${pc_id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);

                        const row = document.getElementById(`row-${pc_id}`);
                        if (row) {
                            row.remove();
                        }
                    } else {
                        alert(data.message);
                    }

                })
                .catch(err => {
                    alert('Terjadi kesalahan');
                    console.error(err);
                });
        }
        function playSingleItem(filePath, orientasi) {
            // Kunci agar showTab tidak memanggil loadActivePreview
            window.skipAutoReload = true;

            // Pindah ke tab preview
            showTab('preview');

            // Set data item tunggal
            previewList = [{
                file: filePath,
                orientasi: orientasi || 'Landscape',
                duration: 10
            }];
            previewIndex = 0;
            playPreview();

            // Lepas kunci setelah beberapa saat
            setTimeout(() => { window.skipAutoReload = false; }, 500);
        }

        let previewIndex = 0;
        let previewTimer = null;
        let previewList = [];

        const VIDEO_EXT = ['mp4', 'mov', 'avi', 'mkv', 'webm'];
        const IMAGE_EXT = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        const previewPlayer = document.getElementById('previewPlayer');

        // ambil playlist aktif dari session lewat blade
        const ACTIVE_PLAYLIST_ID = @json(session('last_playlist_id'));

        function loadActivePreview() {
            if (!previewPlayer) {
                console.warn('previewPlayer element not found');
                return;
            }

            if (!ACTIVE_PLAYLIST_ID) {
                previewPlayer.innerHTML =
                    '<span style="color:#aaa">Belum ada playlist diputar</span>';
                return;
            }

            fetch(`/admin/playlist/${ACTIVE_PLAYLIST_ID}/content`)
                .then(res => res.json())
                .then(data => {
                    // 🔥 PENGAMAN: Jika sedang memutar item tunggal, abaikan reload otomatis
                    if (window.skipAutoReload) return;

                    previewList = data.contents || [];
                    previewIndex = 0;

                    if (!previewList.length) {
                        previewPlayer.innerHTML =
                            '<span style="color:#aaa">Playlist kosong</span>';
                        return;
                    }

                    playPreview();
                });
        }


        function playPreview() {
            clearTimeout(previewTimer);
            const item = previewList[previewIndex];
            const orientasi = (item.orientasi || 'Landscape').toLowerCase();

            // Set orientasi preview
            previewPlayer.className = 'preview-player mode-' + orientasi + '-preview';
            previewPlayer.innerHTML = '';

            const file = `/storage/${item.file}`;
            const ext = file.split('.').pop().toLowerCase();

            if (VIDEO_EXT.includes(ext)) {
                const video = document.createElement('video');
                video.src = file;
                video.autoplay = true;
                video.muted = false;
                video.controls = true; // 🔥 Tambahkan ini agar bisa di-pause
                video.style.maxWidth = '100%';
                video.style.maxHeight = '100%';
                video.onended = nextPreview;
                previewPlayer.appendChild(video);
                return;
            }

            if (IMAGE_EXT.includes(ext)) {
                const img = document.createElement('img');
                img.src = file;
                img.style.maxWidth = '100%';
                img.style.maxHeight = '100%';
                previewPlayer.appendChild(img);

                const dur = item.duration && item.duration > 0 ? item.duration : 5;
                previewTimer = setTimeout(nextPreview, dur * 1000);
            }
        }

        function nextPreview() {
            if (previewList.length === 0) return;
            previewIndex++;
            if (previewIndex >= previewList.length) previewIndex = 0;
            playPreview();
        }

        function stopPreview() {
            if (previewTimer) {
                clearTimeout(previewTimer);
                previewTimer = null;
            }
        }

        let currentPcId = null;

        function openDurationModal(pcId, currentDuration) {
            currentPcId = pcId;
            document.getElementById('durationInput').value = currentDuration || 5;
            document.getElementById('durationModal').classList.remove('d-none');
        }

        function closeDurationModal() {
            document.getElementById('durationModal').classList.add('d-none');
            currentPcId = null;
        }

        async function saveDuration() {
            const duration = document.getElementById('durationInput').value;

            if (!duration || duration <= 0) {
                alert('Durasi tidak valid');
                return;
            }

            try {
                const res = await fetch(`/admin/playlist-content/${currentPcId}/duration`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        duration
                    })
                });

                if (!res.ok) throw new Error();

                closeDurationModal();
                loadPlaylistDetail(activePlaylistId);

            } catch {
                alert('Gagal menyimpan durasi');
            }
        }
    </script>
    <!-- ====================== END SCRIPT ====================== -->

</body>

</html>