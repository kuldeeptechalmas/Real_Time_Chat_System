<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <button id="start">Start Recording</button>
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


</body>
</html>
