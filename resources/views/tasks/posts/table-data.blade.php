@foreach ($posts as $post)
    <tr>
        @php $name = json_decode($post->category_name); @endphp
        <td>{{ $post->id }}</td>
        <td>{{ $post->title }}</td>
        <td>{{ $post->user_name }}</td>
        <td>{{ $name->en }}</td>
    </tr>
@endforeach
