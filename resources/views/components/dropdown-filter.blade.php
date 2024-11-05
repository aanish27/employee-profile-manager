<select id="{{ $id }}" class="form-control-sm col-1 selectpicker" multiple>
    <option hidden>{{ $modal }}</option>
    @foreach ( $collections  as $collection )
        <option value="{{ $collection }}" class="" > {{$feild == "null" ? $collection : $collection->$feild }} </option>
    @endforeach
</select>
