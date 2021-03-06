<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Pedidos de Saída
    </h1>
    <ol class="breadcrumb">
      <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="/">Pedidos Saída</a></li>
      <li class="active"><a href="/">Cadastrar</a></li>
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
          <form role="form" action="/admin/stockordersitem/create/<?php echo htmlspecialchars( $ordertype, ENT_COMPAT, 'UTF-8', FALSE ); ?>" method="post">
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

                <?php if( $ordertype == 'exitrequest' ){ ?>
                  <div class="form-group">
                    <label for="idclient">Informe o Código do Cliente</label>
                    <input type="number" class="form-control" id="idclient" name="idclient" required
                      placeholder="código filial" value="<?php echo htmlspecialchars( $idclient, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                  </div>
                <?php } ?>
                                
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

          <div class="box-body">
          
          <?php if( $checkout == 'true' ){ ?>
          <form action="/admin/stockorders/create/checkout/<?php echo htmlspecialchars( $ordertype, ENT_COMPAT, 'UTF-8', FALSE ); ?>/<?php echo htmlspecialchars( $idstockorder, ENT_COMPAT, 'UTF-8', FALSE ); ?>" method="post">
            <label style="font-size: 25px;" for="idstockorder">Código do Pedido: <?php echo htmlspecialchars( $idstockorder, ENT_COMPAT, 'UTF-8', FALSE ); ?></label>               
             <label style="font-size: 25px;" for="idstockorder">| <?php echo htmlspecialchars( $ordertype, ENT_COMPAT, 'UTF-8', FALSE ); ?></label>                           
            <br>
            <a style="margin-bottom: 5px;" href="/admin/stockordersitem/create/<?php echo htmlspecialchars( $ordertype, ENT_COMPAT, 'UTF-8', FALSE ); ?>/<?php echo htmlspecialchars( $idstockorder, ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="btn btn-primary"> Editar Itens</a>
            <p><strong>Selecione o Metódo de Pagamento</p></strong> 
            <div class="radioPaymentMethod">              
              <input  class="radioavista"  checked type="radio" name="gender" value="avista"> À VISTA
              <input style="margin-left: 5px;" class="radioboleto" type="radio" name="gender" value="boleto"> BOLETO
              <input style="margin-left: 5px;" class="radiocartao" type="radio" name="gender" value="cartao"> CARTÃO
          </div>
            <br>
            <label for="deliverynote">Observação para Entrega</label>
            <input type="text" class="form-control" id="deliverynote" name="deliverynote" required placeholder="Nota de Entrega">
            <br>
           <button type="submit" class="btn btn-success">Concluir</button>     
          </form>
          <?php } ?>
        </div>  
       
        </div>
      </div>
    </div>

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->