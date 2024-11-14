@props([
    'modal_id' => null,
    'modal_name' => null,
    'id',
    'name',
    'width' => '200px',
    'collections'
])

<div class="filter p-0" >
    <label for="{{ $id }}" class="bi bi-filter"> {{ $name }} </label>
    <select id="{{ $id }}" class="col-1 select2-filter" style="width: {{ $width }}">
        <option value="btn_select_all">Select All</option>
        @foreach ( $collections  as $collection )
        {{-- refactor this --}}
            <option value="{{ $modal_id ? $collection->$modal_id : $collection}}">
                {{$modal_name ? $collection->$modal_name : $collection   }}
            </option>
        @endforeach
    </select>
</div>



