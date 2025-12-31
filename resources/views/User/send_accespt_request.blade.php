<div style="background: #fbdfd2;height: 100%;width: 100%;">
    {{-- {{ $users_data }} --}}

    <div class="d-flex justify-content-center" style="padding-top: 84px;">
        <div style="height: 200px;width: 200px;">
            <img style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('storage/img/'.$users_data->image_path) }}" alt="">
        </div>
    </div>
    <div class="d-flex justify-content-center mt-2" style="font-size: 21px;">{{ $users_data->name }}</div>
    <div class="d-flex justify-content-evenly mt-3">
        <div><button type="button" class="btn btn-primary" onclick="requestsend('{{ $users_data->id }}')">Request</button></div>
        {{-- <div><button type="button" class="btn btn-primary">Messages</button></div> --}}
    </div>
</div>
