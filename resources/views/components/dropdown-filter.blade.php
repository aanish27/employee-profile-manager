<div class="filter p-0" >
    <label for="{{ $id }}" class="bi bi-filter"> {{ $name }} </label>
    <select id="{{ $id }}" class="col-1 select2-filter" style="width: {{ $width }}">
        <option value="clear-btn">Clear Selection</option>
        @foreach ( $collections  as $collection )
        {{-- refactor this --}}
            <option value="{{ $feild == "null" ? $collection : $collection->$feild}}" class="" >
                {{$feild == "null" ? $collection : $collection->$feild }}
            </option>
        @endforeach
    </select>
</div>



