<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Editar Cliente
  </h1>
</section>

<!-- Main content -->
<section class="content">
  
  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Editar Cliente</h3>
        </div>
        <!-- /.box-header -->
          <!-- form start -->
        <form role="form" action="/admin/clients/<?php echo htmlspecialchars( $client["idclient"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" method="post">
          <div class="box-body">    
            <div class="form-group">
              <label for="name">Nome do Cliente</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="Informe o nome" required value="<?php echo htmlspecialchars( $client["name"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            </div>
            <div class="form-group">
              <label for="cpf">CPF</label>
              <input type="text" class="form-control" id="cpf" name="cpf" placeholder="Informe o CPF" required value="<?php echo htmlspecialchars( $client["cpf"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            </div>                     
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="/admin/clients" style="width: 70px;" class="btn btn-primary">Voltar</a>
          </div>
        </form>
      </div>
  	</div>
  </div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->