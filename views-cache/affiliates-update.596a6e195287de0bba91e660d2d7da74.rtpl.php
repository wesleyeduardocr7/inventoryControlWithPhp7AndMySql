<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Lista de Produtos
  </h1>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Editar Produto</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" action="/admin/affiliates/<?php echo htmlspecialchars( $branch["idbranch"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" method="post">
          <div class="box-body">
            <div class="form-group">
              <label for="address">Endereço</label>
              <input type="text" class="form-control" id="address" name="address" placeholder="Digite o nome" value="<?php echo htmlspecialchars( $branch["address"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            </div>
            <div class="form-group">
              <label for="telephone">Telefone</label>
              <input type="text" class="form-control" id="telephone" name="telephone" placeholder="Digite a preço único"  value="<?php echo htmlspecialchars( $branch["telephone"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            </div>
            <div class="form-group">
              <label for="manager">Nome do Gerete</label>
              <input type="text" class="form-control" id="manager" name="manager" placeholder="Digite a quantidade total"  value="<?php echo htmlspecialchars( $branch["manager"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
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