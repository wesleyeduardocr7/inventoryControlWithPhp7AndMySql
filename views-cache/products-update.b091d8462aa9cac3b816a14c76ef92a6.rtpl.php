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
          <form role="form" action="/admin/products/<?php echo htmlspecialchars( $product["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" method="post">
            <div class="box-body">    
              <!-- <div class="form-group">
                <label for="idproduct">Id</label>
                <input type="text" class="form-control" id="idproduct" name="name" placeholder="Informe o nome" required value="<?php echo htmlspecialchars( $product["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
              </div>-->
              <div class="form-group">
                <label for="name">Nome do Produto</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Informe o nome" required value="<?php echo htmlspecialchars( $product["name"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
              </div>
              <div class="form-group">
                <label for="sequential">Sequencial</label>
                <input type="text" class="form-control" id="sequential" name="sequential" placeholder="Informe o sequencial" required value="<?php echo htmlspecialchars( $product["sequential"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
              </div>
              <div class="form-group">
                <label for="barcode">Código de Barras</label>
                <input type="text" class="form-control" id="barcode" name="barcode" placeholder="Informe o código de barras" required value="<?php echo htmlspecialchars( $product["barcode"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
              </div>
              <div class="form-group">
                <label for="description">Descrição</label>
                <input type="text" class="form-control" id="description" name="description" placeholder="Informe a descrição" required value="<?php echo htmlspecialchars( $product["description"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
              </div>
              <div class="form-group">
                <label for="price">Preço Unitário</label>
                <input type="number" class="form-control" id="price" name="price" placeholder="Informe o preço unitário" required value="<?php echo htmlspecialchars( $product["price"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
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