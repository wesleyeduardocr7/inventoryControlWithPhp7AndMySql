<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Lista de Filiais
  </h1>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Editar Filial</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" action="/admin/branchs/<?php echo htmlspecialchars( $branch["idbranch"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" method="post">
          <div class="box-body">
            <div class="form-group">
              <label for="name">Nome</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="Digite o nome" value="<?php echo htmlspecialchars( $branch["name"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            </div>
              <label for="street">Rua</label>
              <input type="text" class="form-control" id="street" name="street" placeholder="Digite o nome da rua" value="<?php echo htmlspecialchars( $branch["street"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            </div>
            <div class="form-group">
              <label for="city">Cidade</label>
              <input type="text" class="form-control" id="city" name="city" placeholder="Digite o nome" value="<?php echo htmlspecialchars( $branch["city"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            </div>
            <div class="form-group">
              <label for="state">Estado</label>
              <input type="text" class="form-control" id="state" name="state" placeholder="Digite o nome" value="<?php echo htmlspecialchars( $branch["state"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
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