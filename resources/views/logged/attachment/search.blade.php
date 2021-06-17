<div class="row justify-content-center">
    <div class="col">
        <div class="table-responsive">
            <table class="table table-hover">
                <caption>{{$attachments->total()}} {{$language::get('records_found')}}</caption>
                <thead>
                    <tr class="table-info">
                        <th scope="col">{{$language::get('attachment_title')}}</th>
                        <th scope="col">{{$language::get('attachment_file')}}</th>
                        <th scope="col" class="text-center">{{$language::get('attachment_date')}}</th>
                        @can('attachment.update')
                            <th scope="col" class="text-center">{{$language::get('edit')}}</th>
                        @endcan
                        <th scope="col" class="text-center">{{$language::get('download')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attachments as $attachment)

                        <tr>
                            <td style="white-space: nowrap;">{{$attachment->title}}</td>
                            <td style="white-space: nowrap;">{{$attachment->file->name}}</td>
                            <td class="text-center" style="white-space: nowrap;"> {{ date('d/m/Y', strtotime($attachment->date)) }}</td>
                            @can('attachment.update')
                                <td class="text-center">
                                    <a href="{{route('attachment.edit', $attachment->id)}}" title="{{$language::get('edit')}} {{strtolower($language::get('attachment'))}} '{{$attachment->title}}'"><x-bi-pencil-square/></a>
                                </td>
                            @endcan
                            <td class="text-center">
                                <a href="{{route('attachment.download', $attachment->id)}}" title="{{$language::get('download')}} {{strtolower($language::get('attachment'))}} '{{$attachment->title}}'"><x-bi-file-earmark-arrow-down/></a>
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
    {!! $attachments->links() !!}
</div>