<div class="modal fade" id="ModalExport" tabindex="-1" role="dialog" aria-labelledby="exampleModalExportTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalReceiptTitle">Exportar a excel</h5>
                <input type="hidden" id="destination">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frmExport">
                <div class="modal-body">
                    <input type="hidden" name="url" value="{{ $url }}">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <select name="filter" id="filterExport_schedules" class="form-control">
                                    <option value="all">Todos</option>
                                    <option value="date">Rango de fechas
                                    <option value="states">Estados</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" class="date-export form-control" name="date_start" placeholder="Fecha inicial">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" class="date-export form-control" name="date_end" placeholder="Fecha final">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select name="states_schedules" id="states_schedules" class="status-export form-control">
                                    <option value="all">Seleccionar</option>
                                    <option value="programada">Programada</option>
                                    <option value="confirmada">Confirmada</option>
                                    <option value="fallida">Fallida</option>
                                    <option value="completada">Completada</option>
                                    <option value="cancelada">Cancelada</option>
                                    <!--<option value="en sala">en sala</option>-->
                                    <option value="reprogramada">Reprogramada</option>
                                    <option value="atendida">Atendida</option>
                                    <option value="vencida">Vencida</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="exportarSchedule" >Exportar</button>
                </div>
            </form>
        </div>
    </div>
</div>
