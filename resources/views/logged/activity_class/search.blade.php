<div class="row justify-content-center">
    <div class="col">
        <div class="table-responsive">
            <table class="table table-hover">
                <caption>{{$classes->total()}} {{$language::get('records_found')}}</caption>
                <thead>
                    <tr class="table-info">
                        <th scope="col">{{$language::get('activity')}}</th>
                        <th scope="col">{{$language::get('activity_class_responsible_user_id')}}</th>
                        <th scope="col">{{$language::get('activity_class_schedule')}}</th>
                        <th scope="col">{{$language::get('activity_class_place')}}</th>
                        <th scope="col">{{$language::get('activity_class_max_subscribers')}}</th>
                        <th scope="col" class="text-center">{{$language::get('activity_class_is_active')}}</th>
                        @can('activity_subscribe')
                            <th scope="col" class="text-center">{{$language::get('activity_subscribers')}}</th>
                        @endcan
                        @can('activity_class.update')
                            <th scope="col" class="text-center">{{$language::get('edit')}}</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @forelse($classes as $class)

                        <tr>
                            <td style="white-space: nowrap;">{{$class->activity->name}}</td>
                            <td style="white-space: nowrap;">{{$class->responsible->name}}</td>
                            <td style="white-space: nowrap;">{{$class->schedule}}</td>
                            <td style="white-space: nowrap;">{{$class->place}}</td>
                            <td style="white-space: nowrap;">{{$class->max_subscribers??'-'}}</td>
                            <td class="text-center" style="white-space: nowrap;">{!! $class->is_active ? $language::get('active') : "<span class='inactive'>".$language::get('inactive')."</span>"!!}</td>
                            @can('activity_subscribe')
                                <td class="text-center">
                                    <a href="{{route('activity_class.subscriber', $class->id)}}" title="{{$language::get('edit')}} {{strtolower($language::get('activity_class'))}} '{{$class->activity->name}}'"><x-bi-person-badge/> {{'('.$class->activeSubscribers->count().')'}}</a>
                                </td>
                            @endcan
                            @can('activity_class.update')
                                <td class="text-center">
                                    <a href="{{route('activity_class.edit', $class->id)}}" title="{{$language::get('edit')}} {{strtolower($language::get('activity_class'))}} '{{$class->activity->name}}'"><x-bi-pencil-square/></a>
                                </td>
                            @endcan
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
    {!! $classes->links() !!}
</div>