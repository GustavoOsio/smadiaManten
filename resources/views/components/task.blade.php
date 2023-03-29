<div class="modal fade" id="ModalTask" tabindex="-1" role="dialog" aria-labelledby="exampleModalTaskTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalTaskTitle">Agregar Tarea</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frmTask">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8 offset-2">
                            <div id="date-task"></div>
                            <input type="hidden" name="date" value="{{ date("Y-m-d") }}">
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <strong>Usuarios:</strong>
                                <select required class="form-control filter-schedule" style="width: 100%" name="users[]" multiple required>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ ucwords(mb_strtolower($user->name . " " . $user->lastname, "UTF-8")) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" name="title" class="form-control" minlength="3" maxlength="80" placeholder="Titulo de la tarea" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea name="comment" class="form-control" minlength="10" rows="5" placeholder="Descripción de la tarea" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" >Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>