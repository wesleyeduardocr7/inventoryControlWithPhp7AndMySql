<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Itens do Pedido de Saída
  </h1>
  <ol class="breadcrumb">
    <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="/admin">Itens de Pedido</a></li>
    <li class="active"><a href="/admin/stockordersitem-output/create">Cadastrar</a></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Novo Item de Pedido</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" action="/admin/stockordersitem-output/create" method="post">
          <div class="box-body">
            
            <table class="table table-striped">
              <thead>
                <tr> 
                  <th>Código da Filial</th>
                  <th>Nome da Filial</th>
                  <th>Códido do Usuário</th>
                  <th>Nome do Usuário</th>
                  <th>Códido do Cliente</th>                                  
                  <th>Nome do Cliente</th>
                  <th>Tipo do Pedido</th>                        
                </tr>
              </thead>
              <tbody>               
                <tr>
                  <td><?php echo htmlspecialchars( $idbranch, ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                  <td><?php echo htmlspecialchars( $namebranch, ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                  <td><?php echo htmlspecialchars( $iduser, ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                  <td><?php echo htmlspecialchars( $nameuser, ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                  <td><?php echo htmlspecialchars( $idclient, ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                  <td><?php echo htmlspecialchars( $nameclient, ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                  <td>SAÍDA</td>
                </tr>              
              </tbody>
            </table>            
            <br><a class="btn btn-primary" href="#" role="button">Adicionar Itens</a><br>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-success">Concluir</button>
            <a href="/admin/stockorder-output/create/<?php echo htmlspecialchars( $idbranch, ENT_COMPAT, 'UTF-8', FALSE ); ?>/<?php echo htmlspecialchars( $iduser, ENT_COMPAT, 'UTF-8', FALSE ); ?>/<?php echo htmlspecialchars( $idclient, ENT_COMPAT, 'UTF-8', FALSE ); ?>" style="width: 120px;" class="btn btn-success">Voltar</a>
          </div>
        </form>
      </div>
  	</div>
  </div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->