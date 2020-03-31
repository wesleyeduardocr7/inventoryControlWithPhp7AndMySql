<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Lista de Pedidos de Estoques
  </h1>
  <ol class="breadcrumb">
    <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="/admin/stockorders">Pedidos de Estoque</a></li>
    <li class="active"><a href="/admin/stockorders/create">Cadastrar</a></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Novo Pedido de Estoque</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" action="/admin/stockorders/create" method="post">
          <div class="box-body">
            <div class="form-group">
              <label for="idstock">Informe o Código do Estoque</label>
              <input type="number" class="form-control" id="idstock" name="idstock" placeholder="código estoque">
              <br><a class="btn btn-primary" href="#" role="button">Iniciar Pedido</a><br>
            </div>

            <div class="box-body no-padding">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Código do Estoque</th>
                    <th>Código da Filial</th>
                    <th>Gerente</th>
                    <th>Cidade</th> 
                  </tr>
                </thead>
                <tbody>                 
                  <tr>
                    <td>OK</td>
                    <td>OK</td>
                    <td>OK</td>
                    <td>OK</td>                                
                  </tr>               
                </tbody>
              </table>
            </div>
            
            <div class="form-group">
              <label for="idproduct">Informe o Código do Produto</label>
              <input type="number" class="form-control" id="idproduct" name="idproduct" placeholder="código produto">
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