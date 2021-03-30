<div class="row justify-content-center">
    <div class="col">
        <div class="table-responsive">
            <table class="table table-hover">
                <caption>{{$requests->total()}} {{$language::get('records_found')}}</caption>
                <thead>
                    <tr class="">
                        <th scope="col">{{$language::get('request_requester')}}</th>
                        <th scope="col" class="text-center">{{$language::get('request_category_id')}}</th>
                        <th scope="col">{{$language::get('request_title')}}</th>
                        <th scope="col">{{$language::get('request_place')}}</th>
                        <th scope="col" class="text-center">{{$language::get('request_status_id')}}</th>
                        <th scope="col" class="text-center">{{$language::get('request_created_at')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $request)

                        <tr class="clickable_row" data-url="{{route('request.view', $request->id)}}">
                            <td scope="row" style="white-space: nowrap;">
                                {{$request->requester()}} <small>({{$language::get($request->requesterType())}})</small>
                            </td>
                            <td class="text-center" style="white-space: nowrap;">
                                {{$request->category->name}}
                            </td>
                            <td style="white-space: nowrap;">{{$request->title}}</td>
                            <td scope="row" style="white-space: nowrap;">{{$request->place ?? '' }}</td>
                            <td class="text-center" style="white-space: nowrap;">
                                <span class="badge rounded-pill {{$request->status->class}}">
                                    {{$request->status->name}}
                                </span>
                            </td>
                            <td class="text-center" style="white-space: nowrap;">{{ date('d/m/Y H:i:s', strtotime($request->created_at)) }}</td>
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
    {!! $requests->links() !!}
</div>

<script>
    $('.clickable_row').on("click", function() {
        url = $(this).attr("data-url");
        window.location = $(this).data("url");
    });
</script>