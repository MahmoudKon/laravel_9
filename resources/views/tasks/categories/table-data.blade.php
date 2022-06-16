@foreach ($categories as $category)
    <tr>
        @php $name = json_decode($category->name); @endphp
        <td>{{ $category->id }}</td>
        <td>{{ $name->ar }}</td>
        <td>{{ $name->en }}</td>
    </tr>
@endforeach
