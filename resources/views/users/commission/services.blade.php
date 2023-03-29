<div class="separator"></div>
<p class="title-form">Comision de Servicios/Doctores (Realización)</p>
<div class="line-form"></div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 mt-0 mb-0 ">
        <div class="row justify-content-md-center mb-0">
            <div class="col-lg-5 col-md-6 margin-tb">
                <div class="title-crud" data-toggle="modal" data-target="#ModalReceipt_2">
                    <h4><span class="icon-new-02"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span>
                        Agregar Servicio
                    </h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 justify-content-md-center">
        <table class="table table-sale">
            <thead>
            <th class="fl-ignore">Servicio</th>
            <th class="fl-ignore">Porcentaje de Comision % (0-100).</th>
            <th class="fl-ignore"></th>
            </thead>
            <tbody id="tableToModify_2">
            @foreach($comissionServiceUser as $key => $cs)
                <tr id="rowToClone_2-{{$key+1}}">
                    <td width="300px">
                        <input type="hidden" name="service_id[]" id="service_id-{{$key+1}}" value="{{$cs->service_id}}" data-id="{{$key+1}}">
                        <select name="service[]" class="form-control" required="" data-id="{{$key+1}}" id="service-{{$key+1}}">
                            <option value="{{$cs->service_id}}">{{$cs->service->name}}</option>
                        </select>
                    </td>
                    <td width="300px">
                        <input type="number" min="0" max="100" maxlength="100" id="percent_service-{{$key+1}}"
                               name="percent_service[]" onkeypress="return soloNumeros(event);"
                               data-id="{{$key+1}}" class="form-control" value="{{number_format($cs->commission_service,0,',','')}}" required="">
                    </td>
                    <td><span class="icon-close closeRow" onclick="closeRow_2({{$key+1}})"></span>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="ModalReceipt_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalReceiptTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalReceiptTitle">Buscar Servicio</h5>
                <input type="hidden" id="destination">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frmSearchCenterCost">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <table class="table table-hover" id="tableSearchProduct">
                            <thead>
                            <th class="fl-ignore">ID</th>
                            <th class="fl-ignore">Centro de Costo</th>
                            <th class="fl-ignore">Estado</th>
                            </thead>
                            <tbody>
                            @foreach($services as $s)
                                <tr data-json="{{$s}}" onclick='cloneRowService(this)'>
                                    <td>ID-{{$s->id}}</td>
                                    <td>{{$s->name}}</td>
                                    <td>{{$s->status}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<style>
    .search-table-input{
        display: none;
    }
</style>
<script>
    var countS1 = 0;
    @foreach($comissionServiceUser as $key => $cs)
        countS1++;
    @endforeach
    function cloneRowService(obj){
        var row = JSON.parse($(obj).attr('data-json'));
        countS1++;
        $("#tableToModify_2").append('<tr id="rowToClone_2-' + countS1 + '">' +
            '<td width="300px">' +
            '<input type="hidden" name="service_id[]" id="service_id-' + countS1 +
            '" value="'+ row.id +'" data-id="' + countS1 + '">' +
            '<select name="service[]" class="form-control" required data-id="' + countS1 + '" id="service-' +
            countS1 +
            '"><option value="'+ row.id +'">'+ row.name +'</option>' +
            '</select>' +
            '</td>' +
            '<td width="300px"><input type="number" min="0" max="100" maxlength="100" id="percent_service-' + countS1 +
            '" name="percent_service[]" onkeypress="return soloNumeros(event);" data-id="' + countS1 +
            '" class="form-control" value="0" required></td>' +
            '<td><span class="icon-close closeRow" onclick="closeRow_2(' + countS1 +
            ')"></span></td>' +
            '</tr>');
        $('#ModalReceipt_2').modal('hide');
    }

    function soloNumeros(e)
    {
        var keynum = window.event ? window.event.keyCode : e.which;
        if ((keynum == 8) || (keynum == 46))
            return true;
        return /\d/.test(String.fromCharCode(keynum));
    }

    function closeRow_2(pos) {
        var eliminar = document.getElementById("rowToClone-" + pos);
        var contenedor= document.getElementById("tableToModify");
        $("#rowToClone_2-" + pos).remove();
    }
</script>
