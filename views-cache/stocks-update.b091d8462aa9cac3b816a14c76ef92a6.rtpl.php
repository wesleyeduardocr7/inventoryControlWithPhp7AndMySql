<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Lista de Estoques
  </h1>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Editar Estoque</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" action="/admin/stock/<?php echo htmlspecialchars( $stock["idstock"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" method="post">
          <div class="box-body">
            <div class="form-group">
              <label for="idbranch">Código da Filial</label>
              <input type="number" class="form-control" id="idbranch" name="idbranch" placeholder="Digite o Código da Filial" value="<?php echo htmlspecialchars( $stock["idbranch"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            </div>
            <div class="form-group">
              <label for="idproduct">Código do Produto</label>
              <input type="number" class="form-control" id="idproduct" name="idproduct" placeholder="Digite o Código do Produto"  value="<?php echo htmlspecialchars( $stock["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            </div>                       
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Salvar</button>
          </div>
        </form>
      </div>
  	</div>
  </div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->