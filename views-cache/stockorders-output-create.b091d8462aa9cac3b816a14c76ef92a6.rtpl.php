<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Pedidos de Saída
  </h1>
  <ol class="breadcrumb">
    <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="/admin/stockorders-output">Pedidos Saída</a></li>
    <li class="active"><a href="/admin/stockorders-output/create">Cadastrar</a></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Novo Pedido Saída</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" action="/admin/stockordersitem-output/create" method="post">
          <div class="box-body">
            
              <div class="form-group">
                <label for="idbranch">Informe o Código da Filial</label>
                <input type="number" class="form-control" id="idbranch" name="idbranch" required placeholder="código filial" value="<?php echo htmlspecialchars( $idbranch, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            </div> 
              
            <div class="form-group">
              <label for="iduser">Informe o Código do Usuário</label>
              <input type="number" class="form-control" id="iduser" name="iduser" required placeholder="código usuário" value="<?php echo htmlspecialchars( $iduser, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            </div>  

            <div class="form-group">
              <label for="idclient">Informe o Código do Cliente</label>
              <input type="number" class="form-control" id="idclient" name="idclient" required placeholder="código filial" value="<?php echo htmlspecialchars( $idclient, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            </div> 
                
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-success">Adicionar Itens</button>
            <a href="/" style="width: 120px;" class="btn btn-success">Voltar</a>
            <?php if( $error != '' ){ ?>
            <div style="margin-top: 15px;" class="alert alert-danger">
                <?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?>
            </div>
            <?php } ?>
          </div>
        </form>
      </div>
  	</div>
  </div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->