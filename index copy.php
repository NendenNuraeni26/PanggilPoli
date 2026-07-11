<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Display Panggilan Poli</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f4f7fb;
            overflow: hidden;
        }

        /* NAVBAR */
        .navbar {
            height: 70px;
            background: #2563eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 25px;
            color: #fff;
        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo img {
            width: 45px;
            height: 45px;
            border-radius: 8px;
            background: #fff;
            object-fit: contain;
        }

        .rs-name {
            font-size: 18px;
            font-weight: bold;
        }

        .nav-right {
            text-align: right;
            font-size: 15px;
            font-weight: bold;
        }

        /* MAIN */
        .container {
            display: flex;
            height: calc(100vh - 120px);
            padding: 20px;
            gap: 20px;
        }

        .kiri {
            width: 35%;
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 25px;
        }

        .card {
            text-align: center;
            width: 100%;
        }

        .judul {
            font-size: 22px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 20px;
        }

        .label {
            font-size: 14px;
            color: #64748b;
            margin-top: 12px;
        }

        .nomor {
            font-size: 70px;
            font-weight: bold;
            color: #ef4444;
            margin: 10px 0;
        }

        .nama {
            font-size: 30px;
            font-weight: bold;
            color: #111827;
        }

        .poli {
            font-size: 22px;
            font-weight: bold;
            color: #16a34a;
        }

        /* VIDEO */
        .kanan {
            width: 65%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .video-box {
            width: 90%;
            height: 100%;
            max-height: 520px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        }

        video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* FOOTER */
        .footer {
            height: 50px;
            background: #2563eb;
            display: flex;
            align-items: center;
            overflow: hidden;
            color: #fff;
        }

        .marquee {
            white-space: nowrap;
            display: inline-block;
            padding-left: 100%;
            animation: scroll 18s linear infinite;
            font-size: 15px;
            font-weight: bold;
        }

        @keyframes scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-100%); }
        }

        #unlock {
            position: fixed;
            inset: 0;
            background: #000;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            z-index: 9999;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <div class="navbar">
        <div class="nav-left">
            <div class="logo">
                <img src="aset/logo.png" alt="RS">
            </div>
            <div class="rs-name">RS Muhammadiyah Tuban</div>
        </div>

        <div class="nav-right">
            <div id="tanggal">-</div>
            <div id="jam">-</div>
        </div>
    </div>

    <!-- UNLOCK -->
    <div id="unlock">Klik untuk aktifkan suara & video</div>

    <audio id="notif" preload="auto">
        <source src="aset/notif.mp3" type="audio/mpeg">
    </audio>

    <!-- CONTENT -->
    <div class="container">

        <!-- LEFT -->
        <div class="kiri">
            <div class="card">

                <div class="judul">PANGGILAN POLI</div>

                <div class="label">NOMOR ANTRIAN</div>
                <div class="nomor" id="nomor">-</div>

                <div class="label">NAMA PASIEN</div>
                <div class="nama" id="nama">-</div>

                <div class="label">POLI TUJUAN</div>
                <div class="poli" id="poli">-</div>

            </div>
        </div>

        <!-- RIGHT -->
        <div class="kanan">
            <div class="video-box">
                <video id="videoPlayer" autoplay muted playsinline></video>
            </div>
        </div>

    </div>

    <!-- FOOTER -->
    <div class="footer">
        <div class="marquee">
            Terimakasih Telah Mempercayakan Kesehatan Anda dan Keluarga di RS Muhammadiyah Tuban. Layanan Ku Ibadahku.
        </div>
    </div>

    <script>
        /* ================= STATUS ================= */
        let audioUnlocked = false;
        let isLoading = false;

        // tracking per poli
        let terakhirMap = {};

        /* ================= JAM ================= */
        function updateTime() {
            const now = new Date();

            document.getElementById('jam').innerText =
                now.toLocaleTimeString('id-ID');

            document.getElementById('tanggal').innerText =
                now.toLocaleDateString('id-ID', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
        }

        setInterval(updateTime, 1000);
        updateTime();

        /* ================= UNLOCK AUDIO ================= */
        document.getElementById('unlock').addEventListener('click', () => {

            audioUnlocked = true;
            document.getElementById('unlock').style.display = 'none';

            const notif = document.getElementById('notif');

            notif.play().then(() => {
                notif.pause();
                notif.currentTime = 0;
            }).catch(() => {});

            speechSynthesis.cancel();
        });

        /* ================= VIDEO ================= */
        const videos = [
            'aset/vid-9.mp4',
            'aset/vid-2.mp4',
            'aset/vid-3.mp4'
        ];

        let currentVideo = 0;
        const videoPlayer = document.getElementById('videoPlayer');

        function playVideo(i) {
    videoPlayer.pause();
    videoPlayer.src = videos[i];
    videoPlayer.load();

    videoPlayer.play().catch(err => {
        console.log("Video error:", err);
    });
}
        videoPlayer.addEventListener('ended', () => {
            currentVideo = (currentVideo + 1) % videos.length;
            playVideo(currentVideo);
        });

        playVideo(0);

        /* ================= SUARA ================= */
        function panggilPasien(data) {

            if (!audioUnlocked) return;

            const notif = document.getElementById('notif');
            notif.currentTime = 0;

            notif.play().then(() => {

                notif.onended = function () {

                    const ucapan = new SpeechSynthesisUtterance(
                        'Atas nama ' + data.nm_pasien +
                        '. Silakan ke ' + data.nm_poli
                    );

                    ucapan.lang = 'id-ID';
                    ucapan.rate = 0.9;

                    speechSynthesis.cancel();
                    speechSynthesis.speak(ucapan);
                };

            }).catch(() => {

                const ucapan = new SpeechSynthesisUtterance(
                    'Atas nama ' + data.nm_pasien +
                    '. Silakan ke ' + data.nm_poli
                );

                ucapan.lang = 'id-ID';
                speechSynthesis.speak(ucapan);
            });
        }

        /* ================= CEK ANTRIAN MULTI POLI ================= */
        function cekAntrian() {

            if (isLoading) return;
            isLoading = true;

            fetch('ambil_antrian.php?t=' + Date.now())
                .then(r => r.json())
                .then(res => {

                    if (!res.success) {
                        isLoading = false;
                        return;
                    }

                    const list = res.data;

                    if (!list || list.length === 0) {
                        isLoading = false;
                        return;
                    }

                    for (let i = 0; i < list.length; i++) {

                        const data = list[i];

                        // skip kalau sudah dipanggil
                        if (terakhirMap[data.kd_poli] === data.no_rawat) {
                            continue;
                        }

                        terakhirMap[data.kd_poli] = data.no_rawat;

                        // tampilkan data terakhir yang dipanggil
                        document.getElementById('nomor').innerText = data.no_reg;
                        document.getElementById('nama').innerText = data.nm_pasien;
                        document.getElementById('poli').innerText = data.nm_poli;

                        panggilPasien(data);

                        const fd = new FormData();
                        fd.append('no_rawat', data.no_rawat);

                        fetch('update_status.php', {
                            method: 'POST',
                            body: fd
                        });

                        break;
                    }

                })
                .catch(err => console.log(err))
                .finally(() => {
                    isLoading = false;
                });
        }

        setInterval(cekAntrian, 3000);
        cekAntrian();
    </script>

</body>
</html>