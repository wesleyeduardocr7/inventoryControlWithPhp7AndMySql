<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Lista de Estoques das Filiais
  </h1>
  <ol class="breadcrumb">
    <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="/admin/stocks">Produtos</a></li>
    <li class="active"><a href="/admin/stocks/create">Cadastrar</a></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Novo Estoque</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" action="/admin/stocks/create" method="post">
          <div class="box-body">
            <div class="form-group">
              <label for="idbranch">Informe o Código da Filial</label>
              <input type="number" class="form-control" id="idbranch" name="idbranch" placeholder="código filial">
            </div>     
            <div class="form-group">
              <label for="responsible">Informe o Nome do Responsável</label>
              <input type="text" class="form-control" id="responsible" name="responsible" placeholder="Nome do Responsável">
            </div> 
            <div class="form-group">
              <label for="telephone">Informe o Telefone</label>
              <input type="text" class="form-control" id="telephone" name="telephone" placeholder="Telefone">
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