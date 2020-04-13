<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Lista de Estoques das Filiais
  </h1>
  <ol class="breadcrumb">
    <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
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
              <input type="number" class="form-control" id="idbranch" name="idbranch" placeholder="código filial"  required value="<?php echo htmlspecialchars( $idbranch, ENT_COMPAT, 'UTF-8', FALSE ); ?>" >
            </div>     
            <div class="form-group">
              <label for="idproduct">Informe o Código do Produto</label>
              <input type="number" class="form-control" id="idproduct" name="idproduct" placeholder="código produto " required   value="<?php echo htmlspecialchars( $idproduct, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            </div> 
            <div class="form-group">
              <label for="quantity">Informe a Quantidade</label>
              <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Quantidade" required   value="<?php echo htmlspecialchars( $quantity, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            </div>                   
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-success">Cadastrar</button>
            <a href="/admin/stocks" style="width: 90px;" class="btn btn-success">Voltar</a>
          </div>
          <?php if( $error != '' ){ ?>
          <div class="alert alert-danger">
              <?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?>
          </div>
          <?php } ?>
        </form>
      </div>
  	</div>
  </div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->