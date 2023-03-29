<div class="separator"></div>
<p class="title-form">Comision de ingresos/centro de costos (ventas)</p>
<div class="line-form"></div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 mt-0 mb-0 ">
        <div class="row justify-content-md-center mb-0">
            <div class="col-lg-5 col-md-6 margin-tb">
                <div class="title-crud" data-toggle="modal" data-target="#ModalReceipt">
                    <h4><span class="icon-new-02"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span> Agregar Centro de Costo</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 justify-content-md-center">
        <table class="table table-sale">
            <thead>
            <th class="fl-ignore">Centro de costo</th>
            <th class="fl-ignore">Porcentaje de Comision % (0-100).</th>
            <th class="fl-ignore"></th>
            </thead>
            <tbody id="tableToModify">
                @foreach($comissionCenterUser as $key => $cc)
                    <tr id="rowToClone-{{$key+1}}">
                        <td width="300px">
                            <input type="hidden" name="center_cost_id[]" id="center_cost_id-{{$key+1}}" value="{{$cc->center_cost_id}}" data-id="{{$key+1}}">
                            <select name="center_cost[]" class="form-control" required="" data-id="{{$key+1}}" id="center_cost-{{$key+1}}">
                                <option value="{{$cc->center_cost_id}}">{{$cc->center->name}}</option>
                            </select>
                        </td>
                        <td width="300px">
                            <input type="number" min="0" max="100" maxlength="100" id="percent_center-{{$key+1}}"
                                   name="percent_center[]" onkeypress="return soloNumeros(event);"
                                   data-id="{{$key+1}}" class="form-control" value="{{number_format($cc->commission_income,0,',','')}}" required="">
                        </td>
                        <td><span class="icon-close closeRow" onclick="closeRow({{$key+1}})"></span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="ModalReceipt" tabindex="-1" role="dialog" aria-labelledby="exampleModalReceiptTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalReceiptTitle">Buscar Centro de costo</h5>
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
                                @foreach($centers as $c)
                                    <tr data-json="{{$c}}" onclick='cloneRowIncomes(this)'>
                                        <td>ID-{{$c->id}}</td>
                                        <td>{{$c->name}}</td>
                                        <td>{{$c->status}}</td>
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
    var countS = 0;
    @foreach($comissionCenterUser as $key => $cc)
        countS++;
    @endforeach
    function cloneRowIncomes(obj){
        var row = JSON.parse($(obj).attr('data-json'));
        countS++;
        $("#tableToModify").append('<tr id="rowToClone-' + countS + '">' +
                '<td width="300px">' +
                    '<input type="hidden" name="center_cost_id[]" id="center_cost_id-' + countS +
                    '" value="'+ row.id +'" data-id="' + countS + '">' +
                    '<select name="center_cost[]" class="form-control" required data-id="' + countS + '" id="center_cost-' +
                    countS +
                    '"><option value="'+ row.id +'">'+ row.name +'</option>' +
                    '</select>' +
                '</td>' +
                '<td width="300px"><input type="number" min="0" max="100" maxlength="100" id="percent_center-' + countS +
                '" name="percent_center[]" onkeypress="return soloNumeros(event);" data-id="' + countS +
                '" class="form-control" value="0" required></td>' +
                '<td><span class="icon-close closeRow" onclick="closeRow(' + countS +
                ')"></span></td>' +
            '</tr>');
        $('#ModalReceipt').modal('hide');
    }

    function soloNumeros(e)
    {
        var keynum = window.event ? window.event.keyCode : e.which;
        if ((keynum == 8) || (keynum == 46))
            return true;
        return /\d/.test(String.fromCharCode(keynum));
    }

    function closeRow(pos) {
        var eliminar = document.getElementById("rowToClone-" + pos);
        var contenedor= document.getElementById("tableToModify");
        $("#rowToClone-" + pos).remove();
    }
</script>
