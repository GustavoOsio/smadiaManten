@can('view', \App\Models\PatientsFiles::class)
    <div role="tabpanel" class="tab-pane fade" id="patientsFiles">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="title-crud mb-3">
                    <h2>Archivos Documentales</h2>
                </div>
                <div class="button-new">
                    @can('create', \App\Models\Sale::class)
                        <a class="btn btn-primary openModalFiles" style="color:#ffffff"><span class="icon-new-02"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span> Crear</a>
                    @endcan
                </div>
            </div>
        </div>
        <table class="table table-striped table-soft">
            <thead>
            <tr>
                <th>ID</th>
                <th>Responsable</th>
                <th>Nombre</th>
                <th>Archivo</th>
                <th>Fecha</th>
            </tr>
            </thead>
            <tbody>
            @foreach($files as $f)
                <tr>
                    <td>F-{{ $f->id }}</td>
                    <td>{{ $f->responsable->name . " " . $f->responsable->lastname }}</td>
                    <td>{{ $f->name }}</td>
                    <td>
                        <a target="_blank" href="{{url($f->file)}}">
                            Abrir Archivo
                        </a>
                    </td>
                    <td>{{ $f->date }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <form action="{{ route('patientsUploadFiles') }}"
          id="uploadFileDocument"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="modalFileDocuments" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Subir Archivo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row justify-content-center">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <h6>
                                        Nombre:
                                    </h6>
                                    <input required type="text" id="name" name="name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <h6>
                                        Archivo:
                                    </h6>
                                    <input required type="file" id="file" name="file" readonly class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ATRAS</button>
                        <button type="button" class="uploadFileDocument btn btn-primary">Subir Archivo</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endcan
