<div class="row">
    <div class="col-md-12">
        <fieldset>
            @can ('request.update')
                <div class="row">
                    <div class="col-12 col-md-2 offset-md-10 mb-2">
                        <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#attachmentModal">
                            {{$language::get('create')}}
                        </button>
                    </div>
                </div>
            @endcan

            <div class="row justify-content-center">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr class="">
                                    <th scope="col">{{$language::get('attachment_title')}}</th>
                                    <th scope="col">{{$language::get('attachment_file')}}</th>
                                    <th scope="col" class="text-center">{{$language::get('attachment_user_id')}}</th>
                                    <th scope="col" class="text-center">{{$language::get('attachment_created_at')}}</th>
                                    <th scope="col" class="text-center">{{$language::get('download')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($request->attachments as $attachment)

                                    <tr>
                                        <td>{{$attachment->title}}</td>
                                        <td>{{$attachment->file_name}}</td>
                                        <td class="text-center">{{$attachment->user->email}}</td>
                                        <td class="text-center">{{ date('d/m/Y H:i:s', strtotime($attachment->created_at)) }}</td>
                                        <td class="text-center">
                                            <a href="{{route('request.download', [$request->id, $attachment->id])}}" title="{{$language::get('download')}} '{{$attachment->file_name}}'"><x-bi-file-earmark-arrow-down/></a>
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
        </fieldset>
    </div>
</div>


@can ('request.update')
    <div class="modal fade" id="attachmentModal" tabindex="-1" role="dialog" aria-labelledby="attachmentModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="POST" enctype="multipart/form-data" action="{{ route('request.attachment', $request->id) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">{{$language::get('create')}} {{$language::get('attachment')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <input type='text' class="form-control" id="attachment_title" name="attachment_title" placeholder="{{$language::get('attachment_title_placeholder')}}" />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="file" class="form-control-file" id="attachment_file" name="attachment_file">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            {{$language::get('insert')}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endcan