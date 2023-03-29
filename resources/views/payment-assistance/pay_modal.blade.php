<div class="modal fade" id="modalPay" tabindex="-1" role="dialog" aria-labelledby="exampleModalExportTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalReceiptTitle">Ver pagos</h5>
                <input type="hidden" id="destination">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frmPaymentAssistancePayGo">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" class="date-export-pay-assistance form-control" name="date_start_pay" id="date_start_pay" placeholder="Fecha inicial">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" class="date-export-pay-assistance form-control" name="date_end_pay" id="date_end_pay" placeholder="Fecha final">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select name="pend_pay" id="pend_pay" class="form-control filter-schedule">
                                    <option value="">Pendientes</option>
                                    <option value="si">SI</option>
                                    <option value=no>NO</option>
                                </select>
                            </div>
                        </div>
                        @php
                            $user = \App\User::where('status','activo')->get();
                        @endphp
                        <div class="col-md-12">
                            <div class="form-group">
                                <select name="asys_pay" id="asys_pay" class="form-control filter-schedule">
                                    <option value="">Asistencial</option>
                                    @foreach($user as $us)
                                        <option value="{{$us->id}}">{{$us->name}} {{$us->lastname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="goPayment" >Proceder a pagar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .select2-container{
        width: 100% !important;
    }
</style>
