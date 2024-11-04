@if ($feild == "null")
    <select id="{{ $id }}" class="form-control-sm col-1" multiple>
        <option hidden>{{ $modal }}</option>
        @foreach ( $collections  as $collection )
            <option value="{{ $collection }}" class="" > {{ $collection }} </option>
        @endforeach
    </select>
@else
    <select id="{{ $id }}" class="form-control-sm col-1" multiple>
        <option hidden>{{ $modal }}</option>
        @foreach ( $collections  as $collection )
            <option value="{{ $collection }}" class="" > {{ $collection->$feild }} </option>
        @endforeach
    </select>
@endif
