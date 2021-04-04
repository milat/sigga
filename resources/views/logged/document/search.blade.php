<div class="row justify-content-center">
    <div class="col">
        <div class="table-responsive">
            <table class="table table-hover">
                <caption>{{$documents->total()}} {{$language::get('records_found')}}</caption>
                <thead>
                    <tr class="table-info">
                        <th scope="col">{{$language::get('document_type_id')}}</th>
                        <th scope="col">{{$language::get('document_code')}}</th>
                        <th scope="col">{{$language::get('document_title')}}</th>
                        <th scope="col">{{$language::get('document_file_name')}}</th>
                        <th scope="col" class="text-center">{{$language::get('document_date')}}</th>
                        @can('document.update')
                            <th scope="col" class="text-center">{{$language::get('edit')}}</th>
                        @endcan
                        <th scope="col" class="text-center">{{$language::get('download')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $document)

                        <tr>
                            <td scope="row" style="white-space: nowrap;">{{$document->type->name}}</td>
                            <td style="white-space: nowrap;">{{$document->code}}</td>
                            <td style="white-space: nowrap;">
                                <span title="{{$document->title}}">
                                    {{substr($document->title, 0, 30)}}
                                    @if (strlen($document->title) > 30)
                                        [...]
                                    @endif
                                </span>
                            </td>
                            <td style="white-space: nowrap;">{{$document->file_name}}</td>
                            <td class="text-center" style="white-space: nowrap;"> {{ date('d/m/Y', strtotime($document->date)) }}</td>
                            @can('document.update')
                                <td class="text-center">
                                    <a href="{{route('document.edit', $document->id)}}" title="{{$language::get('edit')}} {{strtolower($language::get('document'))}} '{{$document->code}}'"><x-bi-pencil-square/></a>
                                </td>
                            @endcan
                            <td class="text-center">
                                <a href="{{route('document.download', $document->id)}}" title="{{$language::get('download')}} {{strtolower($language::get('document'))}} '{{$document->code}}'"><x-bi-file-earmark-arrow-down/></a>
                            </td>
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
    {!! $documents->links() !!}
</div>