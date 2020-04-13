<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Lista de Filiais
  </h1>
  <ol class="breadcrumb">
    <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="/admin/branchs">Filiais</a></li>
    <li class="active"><a href="/admin/branchs/create">Cadastrar</a></li>
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
        <form role="form" action="/admin/branchs/create" method="post">
          <div class="box-body">           
            <div class="form-group">
              <label for="name">Nome</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="Digite o nome" required>
            </div>
            <label for="street">Rua</label>
            <input type="text" class="form-control" id="street" name="street" placeholder="Digite o nome da rua" required>
          </div>
            <div class="form-group">
              <label for="city">Cidade</label>
              <input type="text" class="form-control" id="city" name="city" placeholder="Digite a cidade" required>
            </div>
            <div class="form-group">
              <label for="address">Estado</label>
              <input type="text" class="form-control" id="state" name="state" placeholder="Digite a cidade" required>
            </div>
            <div class="form-group">
              <label for="telephone">Telefone</label>
              <input type="text" class="form-control" id="telephone" name="telephone" placeholder="Digite o telefone" required>
            </div>
            <div class="form-group">
              <label for="manager">Nome gerente</label>
              <input type="text" class="form-control" id="manager" name="manager" placeholder="Digite o nome do gerente" required>
            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-success">Cadastrar</button>
            <a href="/admin/branchs" style="width: 90px;" class="btn btn-success">Voltar</a>
          </div>
        </form>
      </div>
  	</div>
  </div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->