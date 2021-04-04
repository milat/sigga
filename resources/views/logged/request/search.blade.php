<div class="row justify-content-center">
    <div class="col">
        <div class="table-responsive">
            <table class="table table-hover">
                <caption>{{$requests->total()}} {{$language::get('records_found')}}</caption>
                <thead>
                    <tr class="">
                        <th scope="col">{{$language::get('request_requester')}}</th>
                        <th scope="col" class="text-center">{{$language::get('phone')}}</th>
                        <th scope="col" class="text-center">{{$language::get('request_category_id')}}</th>
                        <th scope="col" class="text-center">{{$language::get('document')}}</th>
                        <th scope="col" class="text-center">{{$language::get('document_date')}}</th>
                        <th scope="col" class="text-center">{{$language::get('request_status_id')}}</th>
                        <th scope="col">{{$language::get('request_title')}}</th>
                        <th scope="col">{{$language::get('request_place')}}</th>
                        <th scope="col" class="text-center">{{$language::get('request_created_at')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $request)

                        <tr class="clickable_row" data-url="{{route('request.view', $request->id)}}">
                            <td scope="row" style="white-space: nowrap;">
                                <a class='view' title="{{$language::get('view_me')}}" data-title="{{($request->requester()->type->id == 4)?$request->requester()->trade:$request->requester()->name}} <small>({{$language::get($request->requesterType())}})</small>" url='{{route($request->requester()->type->name.".view", $request->requester()->id)}}'>
                                    @if ($request->requester()->type->id == 4)
                                        {{$request->requester()->trade}}
                                    @else
                                        {{$request->requester()->name}}
                                    @endif
                                    <small>({{$language::get($request->requesterType())}})</small>
                                </a>
                            </td>
                            <td class="text-center" style="white-space: nowrap;">
                                <a class='copyme' title='{{$request->requester()->phone->type->name ?? ""}} ({{$language::get("copy_me")}})' request-id='{{$request->id}}' data="{{$request->requester()->phone->number ?? ''}}">
                                    {{$request->requester()->phone->number ?? ''}}
                                    @if ($request->requester()->phone && $request->requester()->phone->type->name == 'WhatsApp')
                                        <img width='15px' src="{{ asset('images/whatsapp.png') }}" />
                                    @endif
                                </a>
                                <br />
                                <span id='copied_{{$request->id}}' style='color:green; display:none;'>Copiado <x-bi-check2-square/></span>
                            </td>
                            <td class="text-center" style="white-space: nowrap;">
                                {{$request->category->name}}
                            </td>
                            <td class="text-center" style="white-space: nowrap;">
                                @if ($request->document)
                                    <a href="{{route('document.download', $request->document->id)}}" title="{{$language::get('download')}} {{strtolower($language::get('document'))}} '{{$request->document->code}}' ({{$request->document->file_name}})">
                                        {{$request->document->type->name}} Nº {{$request->document->code}}
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-center" style="white-space: nowrap;">
                                {{ $request->document ? date('d/m/Y', strtotime($request->document->date)) : '-' }}
                            </td>
                            <td class="text-center" style="white-space: nowrap;">
                                <span class="badge rounded-pill {{$request->status->class}}">
                                    {{$request->status->name}}
                                </span>
                            </td>
                            <td style="white-space: nowrap;">{{$request->title}}</td>
                            <td scope="row" style="white-space: nowrap;">{{$request->place ?? '' }}</td>
                            <td class="text-center" style="white-space: nowrap;">{{ date('d/m/Y H:i:s', strtotime($request->created_at)) }}</td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="9" align="center">
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

@include('logged.common.modal')

<script>
    $('.clickable_row').on("click", function() {
        url = $(this).attr("data-url");
        window.location = $(this).data("url");
    });

    $('.copyme').click(function (e) {
        e.stopPropagation();
        e.preventDefault();

        let inputCopy = document.createElement("input");
        inputCopy.value = $.trim($(this).attr('data'));
        document.body.appendChild(inputCopy);
        inputCopy.select();
        document.execCommand('copy');
        document.body.removeChild(inputCopy);

        var requestId = $(this).attr('request-id');

        $('#copied_'+requestId).fadeIn(700, function(){
            window.setTimeout(function(){
                $('#copied_'+requestId).fadeOut(700);
            }, 1000);
        });
    });
</script>

@include('logged.request.script_view_requester')