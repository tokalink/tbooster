<select id='list-icon' class="form-select" name="icon">
    <option value="">** Select an Icon</option>
    @foreach($fontawesome as $font)
        <option value='fa fa-{{$font}}' {{ (isset($row) && $row->icon == "fa fa-$font")?"selected":"" }} data-label='{{$font}}'>{{$font}}</option>
    @endforeach
</select>