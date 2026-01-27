<div>
    @if (isset($UserAllGroup))
    @foreach ($UserAllGroup as $item)
    <div class="bg-light" style="padding: 21px;display:flex;">
        <div style="width: 27px;height: 27px;">
            @if ($item->UserData->image_path!=Null)
            <img style="width: 100%;height: 100%;object-fit: cover;border-radius: 20px;" src="{{ asset('storage/img/'.$item->UserData->image_path) }}" alt="">
            @else
            @if ($item->UserData->gender=='Men')
            <img style="width: 100%;height: 100%;object-fit: cover;border-radius: 20px;" src="{{ asset('img/male.png') }}" alt="">

            @else
            <img style="width: 100%;height: 100%;object-fit: cover;border-radius: 20px;" src="{{ asset('img/female.png') }}" alt="">

            @endif
            @endif
        </div>

        <div style="margin-left: 27px;">
            {{$item->UserData->name}}
        </div>
        @if (Auth::id()==$item->creater_id)
        @if ($item->user_id==$item->creater_id)
        <div style="position: absolute;right: 16%;">
            <div style="background: #fbdfd2;cursor: auto;" class="btn btn-info">
                Creater
            </div>
        </div>
        @else
        <div style="position: absolute;right: 16%;">
            <button type="button" onclick="RemoveGroupUser({{ $item->id }})" style="background: #fbdfd2;" class="btn btn-info">Remove</button>
        </div>
        @endif
        @else
        @if ($item->user_id==$item->creater_id)
        <div style="position: absolute;right: 16%;">
            <div style="background: #fbdfd2;cursor: auto;" class="btn btn-info">
                Creater
            </div>
        </div>
        @endif
        @endif

    </div>
    @endforeach
    <div class="bg-light" style="padding: 21px;display:flex;margin: 10px 0px 10px 0px;position: relative;">
        <div style="margin-left: 27px;color: green;">
            Change Group Image
        </div>
        <div style="position: absolute;right: 13%;top: 22%;">
            <div onclick="OpenUpdateGroupImage()" style="background: #fbdfd2;cursor: auto;" class="btn btn-info">
                Update
            </div>
            @if ($UserAllGroup[0]->GroupData->image_path!=null)

            <div onclick="RemoveGroupImage('{{ $UserAllGroup[0]->group_id }}')" style="background: #fbdfd2;cursor: auto;" class="btn btn-info">
                Remove
            </div>
            @endif
        </div>
        <input type="file" name="groupimage" style="display:none;" id="groupimage">
    </div>
    <div class="bg-light btn" style="padding: 21px;display:flex;" onclick="ExitGroup('{{ $UserAllGroup[0]->group_id }}')">
        <div style="margin-left: 27px;color: red;">
            Exit Group
        </div>
    </div>
    <div style="display: flex;justify-content: space-around;margin-top: 15px;">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="SaveImageToGroup('{{ $UserAllGroup[0]->group_id }}')">Save Changes</button>
    </div>
</div>

@endif

<script>
    fileInput = document.getElementById('groupimage');
    imagePreview = document.getElementById('imagePreview');

    fileInput.addEventListener('change', function(event) {

        const files = event.target.files;

        if (files && files[0] && files[0].name.split('.')[1] == 'png' || files[0].name.split('.')[1] == 'jpg' || files[0].name.split('.')[1] == 'svg') {

            reader = new FileReader();

            reader.onload = function(e) {
                imagePreview.src = e.target.result;
            };

            reader.readAsDataURL(files[0]);

        }
    });

</script>
