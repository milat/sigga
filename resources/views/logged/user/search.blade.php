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
                        <th scope="col" class="text-center">{{$language::get('view')}}</th>
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
                            <td class="text-center">
                                <a class='view' href='javascript:;' title="{{$language::get('view_me')}}" url='{{route("user.view", $user->id)}}' data-title="{{$user->name}}">
                                    <x-bi-eye/>
                                </a>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" align="center">
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

@include('logged.common.modal')

@include('logged.request.script_view_requester')