@foreach ($comments as $comment)
    <tr>
        @php $name = json_decode($comment->category_name); @endphp
        <td>{{ $comment->id }}</td>
        <td>{{ $comment->comment }}</td>
        <td>{{ $comment->post_title }}</td>
        <td>{{ $comment->user_name }}</td>
        <td>{{ $name->ar }}</td>
        <td>{{ $comment->created_at }}</td>
    </tr>
@endforeach
