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


<tr>
    <td colspan="10">
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                @for ($i = 1; $i <= $pages; $i++)
                    <li class="page-item {{ $i == $current_page ? 'active' : '' }}"><a class="page-link" href="?page={{ $i }}">{{ $i }}</a></li>
                @endfor
            </ul>
        </nav>
    </td>
</tr>
