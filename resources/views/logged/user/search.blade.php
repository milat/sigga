<div class="row justify-content-center">
    <div class="col">
        <div class="table-responsive">
            <table class="table table-hover">
                <caption>{{$users->total()}} {{$language::get('records_found')}}</caption>
                <thead>
                    <tr class="table-info">
                        <th scope="col">{{$language::get('user_name')}}</th>
                        <th scope="col">{{$language::get('user_email')}}</th>
                        <th scope="col" class="text-center">{{$language::get('user_role_id')}}</th>
                        <th scope="col" class="text-center">{{$language::get('user_is_active')}}</th>
                        @can('user.update')
                            <th scope="col" class="text-center">{{$language::get('edit')}}</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)

                        <tr>
                            <th scope="row" style="white-space: nowrap;">{{$user->name}}</th>
                            <td style="white-space: nowrap;">{{$user->email}}</td>
                            <td class="text-center" style="white-space: nowrap;">{{$user->role->name}}</td>
                            <td class="text-center" style="white-space: nowrap;">{!! $user->is_active ? $language::get('active') : "<span class='inactive'>".$language::get('inactive')."</span>"!!}</td>
                            @can('user.update')
                                <td class="text-center">
                                    <a href="{{route('user.edit', $user->id)}}" title="{{$language::get('edit')}} {{strtolower($language::get('user'))}} {{$user->name}}"><x-bi-pencil-square/></a>
                                </td>
                            @endcan
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
    {!! $users->links() !!}
</div>