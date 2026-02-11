<div style="height: 100%;width: 100%;">
    {{-- {{ $users_data }} --}}

    <div class="d-flex justify-content-center" style="padding-top: 84px;">
        <div style="height: 200px;width: 200px;">

            @if ($users_data->image_path==Null)
            @if ($users_data->gender=='Men')
            <img style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/male.png') }}" alt="">
            @else
            <img style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/female.png') }}" alt="">
            @endif
            @else
            <img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $users_data->name }}','{{ $users_data->image_path }}','{{ $users_data->phone }}','{{ $users_data->email }}')" style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('storage/img/'.$users_data->image_path) }}" alt="">
            @endif

        </div>
    </div>
    <div class="d-flex justify-content-center mt-2 text-white" style="font-size: 21px;">{{ $users_data->name }}</div>
    <div class="d-flex justify-content-evenly mt-3">
        @if (isset($requested))
        <div id="requestedid"><button type="button" class="btn btn-primary">Following</button></div>
        <div id="removerequestedid"><button type="button" class="btn btn-primary" onclick="removerequest('{{ $users_data->id }}')">UnFollow</button></div>

        <div id="requestid" style="display: none"><button type="button" class="btn btn-primary" onclick="requestsend('{{ $users_data->id }}')">Follow</button></div>
        @else

        @if (isset($user_can_request))
        <div><button type="button" class="btn btn-primary" onclick="RequestIsAccept('{{ $users_data->id }}')">Follow Back</button></div>
        @else

        <div id="requestedid" style="display: none"><button type="button" class="btn btn-primary">Following</button></div>
        <div id="removerequestedid" style="display: none"><button type="button" class="btn btn-primary" onclick="removerequest('{{ $users_data->id }}')">UnFollow</button></div>

        <div id="requestid"><button type="button" class="btn btn-primary" onclick="requestsend('{{ $users_data->id }}')">Follow</button></div>
        @endif

        @endif
    </div>
</div>
