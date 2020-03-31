<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Lista de Filiais
  </h1>
  <ol class="breadcrumb">
    <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="/admin/affiliates">Filiais</a></li>
    <li class="active"><a href="/admin/affiliates/create">Cadastrar</a></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Nova Filial</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" action="/admin/affiliates/create" method="post">
          <div class="box-body">           
            <div class="form-group">
              <label for="address">Endereço</label>
              <input type="text" class="form-control" id="address" name="address" placeholder="Digite a cidade">
            </div>
            <div class="form-group">
              <label for="telephone">Telefone</label>
              <input type="text" class="form-control" id="telephone" name="telephone" placeholder="Digite o telefone">
            </div>
            <div class="form-group">
              <label for="manager">Nome gerente</label>
              <input type="text" class="form-control" id="manager" name="manager" placeholder="Digite o nome do gerente">
            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-success">Cadastrar</button>
          </div>
        </form>
      </div>
  	</div>
  </div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->