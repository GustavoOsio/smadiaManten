@extends('layouts.show')

@section('content')
    @if ($errors->any())
        <div class="content-his mt-3" style="padding: 0%;background: transparent;">
            <div class="alert alert-danger">
                <strong>¡Ups!</strong> Hubo algunos problemas.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    @if ($message = Session::get('success'))
        <div class="content-his mt-3" style="padding: 0%;background: transparent;">
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        </div>
    @endif

    <div class="content-his mt-3">
        <form id="typesService" action="{{ route('email-confirmation-update') }}" method="POST">
            @csrf

            <p class="title-form">Correo de confirmacion de citas</p>
            <div class="line-form"></div>
            <div class="row">
                <input type="hidden" id="id" name="id" value="1">
                <textarea name="text" id="text" cols="30" rows="10"></textarea>
                <div id="editor">
                    <div id='edit' style='margin-top:30px;'>
                        {!!  $email->text !!}
                    </div>
                </div>
                <textarea name="address" id="address" cols="30" rows="10"></textarea>
                <div id="editor">
                    <div id='edit_2' style='margin-top:30px;'>
                        {!! $email->address !!}
                    </div>
                </div>
                <textarea name="firm" id="firm" cols="30" rows="10"></textarea>
                <div id="editor">
                    <div id='edit_3' style='margin-top:30px;'>
                        {!! $email->firm !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-2 col-md-6 margin-tb">
                            <button type="submit" class="btn btn-primary w-100">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Include Editor style. -->
    <link href='https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/css/froala_editor.pkgd.min.css' rel='stylesheet' type='text/css' />
    <!-- Include JS file. -->
    <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/js/froala_editor.pkgd.min.js'></script>
    <script>
        new FroalaEditor('#edit');
        new FroalaEditor('#edit_2');
        new FroalaEditor('#edit_3');
    </script>
    <style>
        #logo,#insertLink-1,#insertImage-1,#insertVideo-1,#moreRich-1{
            display: none !important;
        }
        #insertLink-2,#insertImage-2,#insertVideo-2,#moreRich-2{
            display: none !important;
        }
        #insertLink-3,#insertImage-3,#insertVideo-3,#moreRich-3{
            display: none !important;
        }
        #editor{
            width: 100%;
        }
        textarea{
            visibility: hidden;
            height: 0px;
        }
        .fr-wrapper a{
            display: none !important;
        }
    </style>
@endsection
