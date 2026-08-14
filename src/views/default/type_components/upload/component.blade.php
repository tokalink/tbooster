<div class='row mb-3 {{$header_group_class}} {{ ($errors->first($name))?"has-error":"" }}' id='form-group-{{$name}}' style="{{@$form['style']}}">
    <label class='col-sm-2 col-form-label fw-bold'>{{$form['label']}}
        @if($required)
            <span class='text-danger' title='{!! cbLang('this_field_is_required') !!}'>*</span>
        @endif
    </label>

    <div class="{{$col_width?:'col-sm-10'}}">
        @if($value)
            <?php
            if(Storage::exists($value) || file_exists($value)):
            $url = asset($value);
            $ext = pathinfo($url, PATHINFO_EXTENSION);
            $images_type = array('jpg', 'png', 'gif', 'jpeg', 'bmp', 'tiff');
            if(in_array(strtolower($ext), $images_type)):
            ?>
            <p><a data-lightbox='roadtrip' href='{{$url}}'><img style='max-width:160px' class="img-thumbnail" title="Image For {{$form['label']}}" src='{{$url}}'/></a></p>
            <?php else:?>
            <p><a href='{{$url}}' class="btn btn-outline-secondary btn-sm">{{cbLang("button_download_file")}}</a></p>
            <?php endif;
            echo "<input type='hidden' name='_$name' value='$value'/>";
            else:
                echo "<p class='text-danger'><i class='bi bi-exclamation-triangle'></i> ".cbLang("file_broken")."</p>";
            endif;
            ?>
            @if(!$readonly || !$disabled)
                <p><a class='btn btn-danger btn-delete btn-sm' onclick="if(!confirm('{{cbLang("delete_title_confirm")}}')) return false"
                      href='{{url(CRUDBooster::mainpath("delete-image?image=".$value."&id=".$row->id."&column=".$name))}}'><i
                                class='bi bi-trash'></i> {{cbLang('text_delete')}} </a></p>
            @endif
        @endif
        @if(!$value)
            <input type='file' id="{{$name}}" title="{{$form['label']}}" {{$required}} {{$readonly}} {{$disabled}} class='form-control {{ $errors->first($name)?"is-invalid":"" }}' name="{{$name}}"/>
            <div class='form-text'>{{ @$form['help'] }}</div>
        @else
            <div class='form-text text-muted'><em>{{cbLang("notice_delete_file_upload")}}</em></div>
        @endif
        <div class="text-danger mt-1">{!! $errors->first($name)?"<i class='bi bi-exclamation-circle'></i> ".$errors->first($name):"" !!}</div>

    </div>

</div>
