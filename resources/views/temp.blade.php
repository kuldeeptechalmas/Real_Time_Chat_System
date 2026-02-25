<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        /* Sidebar default */
        .sidebar {
            position: fixed;
            top: 0;
            left: -250px;
            /* hidden off-screen */
            width: 250px;
            height: 100%;
            background-color: #111;
            padding-top: 60px;
            transition: transform 0.4s ease;
            /* smooth slide effect */
            transform: translateX(0);
        }

        /* Sidebar links */
        .sidebar a {
            display: block;
            padding: 10px 20px;
            color: white;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: #575757;
        }

        /* Active class for showing sidebar */
        .sidebar.active {
            transform: translateX(250px);
            /* move into view */
        }

    </style>
</head>
<body>
    <button onclick="toggleSidebar()">☰ Menu</button>

    <div id="sidebar" class="sidebar">
        <a href="#">Home</a>
        <a href="#">About</a>
        <a href="#">Services</a>
        <a href="#">Contact</a>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("active");
        }

    </script>
    {{-- <button id="start">Start Recording</button>
    <button id="stop">Stop Recording</button>

    <script>
        let mediaRecorder;
        let audioChunks = [];
        let stream; // store stream globally

        document.getElementById('start').onclick = async () => {
            stream = await navigator.mediaDevices.getUserMedia({
                audio: true
            });

            mediaRecorder = new MediaRecorder(stream);

            mediaRecorder.start();

            mediaRecorder.ondataavailable = event => {
                audioChunks.push(event.data);
            };
        };

        document.getElementById('stop').onclick = () => {
            mediaRecorder.stop();

            // ✅ STOP the microphone
            stream.getTracks().forEach(track => track.stop());

            mediaRecorder.onstop = async () => {
                const audioBlob = new Blob(audioChunks, {
                    type: 'audio/webm'
                });

                const formData = new FormData();
                formData.append('audio', audioBlob);

                await fetch('/store', {
                    method: 'POST'
                    , body: formData
                    , headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
    });

    audioChunks = [];
    };
    };

    </script>
    --}}

</body>
</html>
