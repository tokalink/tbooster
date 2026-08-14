<div class='row mb-3 {{$header_group_class}} {{ ($errors->first($name))?"has-error":"" }}' id='form-group-{{$name}}' style="{{@$form['style']}}">
    <label class='col-sm-2 col-form-label fw-bold'>{{$form['label']}}
        @if($required)
            <span class='text-danger' title='{!! cbLang('this_field_is_required') !!}'>*</span>
        @endif
    </label>
    <div class="{{$col_width?:'col-sm-10'}}">

        @if(empty($form['dataenum']) && empty($form['datatable']) && empty($form['dataquery']))
            <em>{{cbLang('there_is_no_option')}}</em>
        @endif

        @if(!empty($form['dataenum']))
            <?php
            @$value = explode(";", $value);
            @array_walk($value, 'trim');
            $dataenum = $form['dataenum'];
            $dataenum = (is_array($dataenum)) ? $dataenum : explode(";", $dataenum);
            ?>
            @foreach($dataenum as $k=>$d)
                <?php
                if (strpos($d, '|')) {
                    $val = substr($d, 0, strpos($d, '|'));
                    $label = substr($d, strpos($d, '|') + 1);
                } else {
                    $val = $label = $d;
                }
				$checked = ( ($value && in_array($val, $value)) || (CRUDBooster::isCreate() && ($k==0 && isset($form['validation']) && $form['validation'])) ) ? "checked" : "";
                ?>
                <div class="form-check form-check-inline {{$disabled}}">
                    <input class="form-check-input" type="radio" {{$disabled}} {{$checked}} id="{{$name}}_{{$k}}" name="{{$name}}" value="{{$val}}">
                    <label class="form-check-label" for="{{$name}}_{{$k}}">{{$label}}</label>
                </div>
            @endforeach
        @endif

        <?php

        if (!empty($form['datatable'])):
            $datatable_array = explode(",", $form['datatable']);
            $datatable_tab = $datatable_array[0];
            $datatable_field = $datatable_array[1];

            $tables = explode('.', $datatable_tab);
            $selects_data = DB::table($tables[0])->select($tables[0].".id");

            if (CRUDBooster::isColumnExists($tables[0], 'deleted_at')) {
                $selects_data->where('deleted_at', NULL);
            }

            if (@$form['datatable_where']) {
                $selects_data->whereraw($form['datatable_where']);
            }

            if (count($tables)) {
                for ($i = 1; $i <= count($tables) - 1; $i++) {
                    $tab = $tables[$i];
                    $parent_table = $tables[$i - 1];
                    $fk_field = CRUDBooster::getForeignKey($parent_table, $tab);
                    $pk = CRUDBooster::findPrimaryKey($tab) ?: 'id';
                    $selects_data->leftjoin($tab, $tab.'.'.$pk, '=', $fk_field);
                }
            }

            //Because we use join statement, we need to select specified field to avoid ambigous
            $select_field = end($tables).'.'.$datatable_field;
            $select_field_alias = end($tables).'_'.$datatable_field;
            $selects_data->addselect($select_field.' as '.$select_field_alias);
            $selects_data = $selects_data->orderby(end($tables).'.'.$datatable_field, "asc")->get();

            foreach ($selects_data as $key => $d) {
                $val = $d->{$select_field_alias};
                if ($val == '' || ! $d->id) continue;

                $checked = ($value == $d->id) ? "checked" : "";

                echo "
											<div data-val='$val' class='form-check form-check-inline $disabled'>
											    <input class='form-check-input' type='radio' $disabled $checked id='".$name."_dt_".$key."' name='".$name."' value='".$d->id."'>
											    <label class='form-check-label' for='".$name."_dt_".$key."'>".$val."</label> 								    
											</div>";
            }

        endif;
        if (!empty($form['dataquery'])) {
            $query = DB::select($form['dataquery']);
            if ($query) {
                foreach ($query as $key => $q) {
                    $checked = ($value == $q->value) ? "checked" : "";
                    echo "<div data-val='$q->value' class='form-check form-check-inline $disabled'>
																<input class='form-check-input' type='radio' $disabled $checked id='".$name."_dq_".$key."' name='".$name."' value='$q->value'>
																<label class='form-check-label' for='".$name."_dq_".$key."'>".$q->label."</label>								    
																</div>";
                }
            }
        }
        ?>
        <div class="text-danger mt-1">{!! $errors->first($name)?"<i class='bi bi-exclamation-circle'></i> ".$errors->first($name):"" !!}</div>
        <div class='form-text'>{{ @$form['help'] }}</div>
    </div>
</div>