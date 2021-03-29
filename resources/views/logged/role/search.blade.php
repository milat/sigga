<div class="row justify-content-center">
    <div class="col">
        <div class="table-responsive">
            <table class="table table-hover">
                <caption>{{$roles->total()}} {{$language::get('records_found')}}</caption>
                <thead>
                    <tr class="table-info">
                        <th scope="col">{{$language::get('role_name')}}</th>
                        <th scope="col" class="text-center">{{$language::get('role_is_active')}}</th>
                        <th scope="col" class="text-center">{{$language::get('edit')}}</th>
                        <th scope="col" class="text-center">{{$language::get('permissions')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)

                        <tr>
                            <th scope="row">{{$role->name}}</th>
                            <td class="text-center">{!! $role->is_active ? $language::get('active') : "<span class='inactive'>".$language::get('inactive')."</span>"!!}</td>
                            <td class="text-center">
                                <a href="{{route('role.edit', $role->id)}}" title="{{$language::get('edit')}} {{strtolower($language::get('role'))}} '{{$role->name}}'"><x-bi-pencil-square/></a>
                            </td>
                            <td class="text-center">
                                <a href="{{route('role.permission', $role->id)}}" title="{{$language::get('permissions')}} {{strtolower($language::get('role'))}} '{{$role->name}}'"><x-bi-key/></a>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" align="center">
                                {{$language::get('no_records_found')}}
                            </td>
                        </tr>

                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center">
    {!! $roles->links() !!}
</div>