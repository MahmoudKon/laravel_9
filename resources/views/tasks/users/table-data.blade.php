@foreach ($users as $user)
    <tr>
        <td>{{ $user->id }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>

            @foreach ($permissions as $id => $name)
                <label>
                    <input type="checkbox" class="toggle-permission" data-user-id="{{ $user->id }}"
                            data-permission-id="{{ $id }}" @checked(userHasPermission($user->id, $id))>
                    {{ $name }}
                </label>
            @endforeach

        </td>

    </tr>
@endforeach

{{-- This function 'userHasPermission' declaredted in App/Helpers/Helper.php file --}}
