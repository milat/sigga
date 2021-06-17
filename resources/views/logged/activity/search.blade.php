<div class="row justify-content-center">
    <div class="col">
        <div class="table-responsive">
            <table class="table table-hover">
                <caption>{{$activities->total()}} {{$language::get('records_found')}}</caption>
                <thead>
                    <tr class="table-info">
                        <th scope="col">{{$language::get('activity_name')}}</th>
                        <th scope="col">{{$language::get('activity_description')}}</th>
                        @can('activity.update')
                            <th scope="col" class="text-center">{{$language::get('edit')}}</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @forelse($activities as $activity)

                        <tr>
                            <td style="white-space: nowrap;">{{$activity->name}}</td>
                            <td style="white-space: nowrap;">{{$activity->description}}</td>
                            @can('activity.update')
                                <td class="text-center">
                                    <a href="{{route('activity.edit', $activity->id)}}" title="{{$language::get('edit')}} {{strtolower($language::get('activity'))}} '{{$activity->name}}'"><x-bi-pencil-square/></a>
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
    {!! $activities->links() !!}
</div>