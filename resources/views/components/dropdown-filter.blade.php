<div class="filter p-0" >
    <label for="{{ $id }}" class=""> {{ $name }}
        <select id="{{ $id }}" class="col-1 select2-filter" style="width: {{ $width }}">
            @foreach ( $collections  as $collection )
            {{-- refactor this --}}
                <option value="{{ $feild == "null" ? $collection : $collection->$feild}}" class="" >
                    {{$feild == "null" ? $collection : $collection->$feild }}
                </option>
            @endforeach
        </select>
    </label>
    <button class="btn-filter-clear bi bi-filter btn btn-outline-secondary rounded-1 px-0 py-0 mx-0 " title="Clear Filter">Clear</button>
</div>



