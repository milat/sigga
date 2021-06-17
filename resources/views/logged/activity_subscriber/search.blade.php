
<div class="row justify-content-center">
    <div class="col">
        <div class="table-responsive">
            <table class="table table-hover">
                <caption>{{$subscribers->total()}} {{$language::get('records_found')}}</caption>
                <thead>
                    <tr class="table-info">
                        <th scope="col">{{$language::get('activity_subscriber_name')}}</th>
                        <th class="text-center" scope="col">{{$language::get('activity_subscriber_is_active')}}</th>
                        <!-- <th scope="col" class="text-center">{{$language::get('edit')}}</th> -->
                    </tr>
                </thead>
                <tbody>
                    @forelse($subscribers as $subscriber)

                        <tr>
                            <td style="white-space: nowrap;">{{$subscriber->owner->name}}</td>
                            <td class="text-center" style="white-space: nowrap;">{!! $subscriber->is_active ? $language::get('active') : "<span class='inactive'>".$language::get('inactive')."</span>"!!}</td>
                            <!-- <td class="text-center">
                                <input type="checkbox" class="access" role_id="1" permission_id="2"
                                {{ ($subscriber->is_active) ? 'checked="checked"' : '' }} data-onstyle="success" data-offstyle="danger" data-toggle="toggle"
                                data-on="{{$language::get('permission_access_is_alowed')}}" data-off="{{$language::get('permission_access_not_allowed')}}">
                                <small class="alert-danger" id="role_3" style="display: none;"><br />{{$language::get('role_permission_update_error')}}</small>
                            </td> -->
                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" align="center">
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
    {!! $subscribers->links() !!}
</div>
