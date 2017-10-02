<!DOCTYPE html>
<html>
<head>
    <title>API Test</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta charset="utf-8">
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url('favicon.png'); ?>"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/animate.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css">
</head>
<body>
<div class="row">
<div class="col-sm-6 col-sm-offset-3">
    <div class="form_api">
    <h3>API REST Test</h3>
    <p>
    	Selecciona un elemento de la lista pra hacer una operaci&oacute;n CRUD.<br>
    	Un mensaje <b class="text-danger">'Bad Request'</b> indica que faltan par&aacute;metros para la operaci&oacute;n indicada.<br>
    	Un mensaje <b class="text-success">'Success'</b> indica que se complet&oacute; la operaci&oacute;n.
    </p>
    <form role="form" name="apiForm" id="apiForm" data-toggle="validator" class="shake">
       <div class="row">
            <div class="form-group col-sm-3">
                <label for="tipo" class="h4">Operaci&oacute;n</label>
                <select name="tipo" class="form-control" id="tipo" required data-error="Selecciona">
                	<option value="">...</option>
                	<option value="crear">Create</option>
                	<option value="lista">Read</option>
                	<option value="editar">Update</option>
                	<option value="borrar">Delete</option>
                </select>
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group col-sm-9">
                <label for="url_" class="h4">Target</label>
                <input type="text" class="form-control" id="url_" placeholder="URL del API" readonly>
                <div class="help-block with-errors"></div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-3" id="div_id">
                <label for="id_" class="h4">ID</label>
                <input type="text" class="form-control" name="id_" id="id_" placeholder="ID del item" required>
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group col-sm-3" id="div_item">
                <label for="item" class="h4">Item</label>
                <input type="text" class="form-control" name="item" id="item" placeholder="Item">
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group col-sm-3" id="div_catalogo">
                <label for="catalogo" class="h4">Cat&aacute;logo</label>
                <input type="text" class="form-control" name="catalogo" id="catalogo" placeholder="Item">
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group col-sm-3" id="div_area">
                <label for="area" class="h4">&Aacute;rea</label>
                <input type="text" class="form-control" name="area" id="area" placeholder="Area">
                <div class="help-block with-errors"></div>
            </div>
        </div>
        <button type="submit" id="form-submit" class="btn btn-info btn-lg pull-right ">Enviar</button>
        <div class="clearfix"></div>
        <div class="form-group">
            <label for="resultado" class="h4 ">Resultado</label>
            <textarea id="resultado" class="form-control" rows="5" placeholder=""></textarea>
            <div class="help-block with-errors"></div>
        </div>
        <div class="clearfix"></div>
        <div id="msgError" class="h3 text-center"></div>
        <div class="clearfix"></div>
    </form>
    </div>
</div>
</div>
</body>
<script  type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/validator.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/form-scripts.js"></script>
</html>
