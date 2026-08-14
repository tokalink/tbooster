<div class='row mb-3 {{$header_group_class}} {{ ($errors->first($name))?"has-error":"" }}' id='form-group-{{$name}}' style="{{@$form['style']}}">
    <label class='col-sm-2 col-form-label fw-bold'>{{$form['label']}}
        @if($required)
            <span class='text-danger' title='{!! cbLang('this_field_is_required') !!}'>*</span>
        @endif
    </label>

    <div class="{{$col_width?:'col-sm-10'}}">
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
            <input type="email" name="{{$name}}" style="display: none">
            <input type='email' title="{{$form['label']}}"
                   {{$required}} {{$readonly}} {!!$placeholder!!} {{$disabled}} {{@$validation['max']?"maxlength=".@$validation['max']:""}} class='form-control {{ $errors->first($name)?"is-invalid":"" }}'
                   name="{{$name}}" id="{{$name}}" value='{{$value}}'/>
        </div>
        <div class="text-danger mt-1">{!! $errors->first($name)?"<i class='bi bi-exclamation-circle'></i> ".$errors->first($name):"" !!}</div>
        <div class='form-text'>{{ @$form['help'] }}</div>
    </div>
</div>