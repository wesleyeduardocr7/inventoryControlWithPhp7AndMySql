<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Pedidos de Entrada
    </h1>
    <ol class="breadcrumb">
      <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="/admin/stockorders-input">Pedidos Saída</a></li>
      <li class="active"><a href="/admin/stockorders-input/create">Cadastrar</a></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Novo Pedido Entrada</h3>
          </div>
          <form role="form" action="/admin/stockordersitem-input/create" method="post">
            <div class="box-body">

                <div class="form-group">
                  <label for="idbranch">Informe o Código da Filial</label>
                  <input type="number" class="form-control" id="idbranch" name="idbranch" required
                    placeholder="código filial" value="<?php echo htmlspecialchars( $idbranch, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                </div>

                <div class="form-group">
                  <label for="iduser">Informe o Código do Usuário</label>
                  <input type="number" class="form-control" id="iduser" name="iduser" required
                    placeholder="código usuário" value="<?php echo htmlspecialchars( $iduser, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                </div>              
                
            </div>
              <div style="margin-top: -20px;" class="box-footer">
                    <button type="submit" class="btn btn-success">Novo Pedido</button>
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