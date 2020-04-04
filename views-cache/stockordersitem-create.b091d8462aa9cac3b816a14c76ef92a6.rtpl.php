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
          <form role="form" action="/admin/stockordersitem-output/create/<?php echo htmlspecialchars( $idbranch, ENT_COMPAT, 'UTF-8', FALSE ); ?>/<?php echo htmlspecialchars( $iduser, ENT_COMPAT, 'UTF-8', FALSE ); ?>/<?php echo htmlspecialchars( $idclient, ENT_COMPAT, 'UTF-8', FALSE ); ?>" method="get">
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
             
                <h3>Selecione o Parâmetro de Busca do Produto</h3>

                <div class="row">
                  <div class="col-sm-3">
                    <select class="form-control">
                      <option value="codigo">Código</option>
                      <option value="nome">Nome</option>
                    </select>
                  </div>
                </div>
                <br />
                <div>

                <input type="text" class="form-control" id="product_search_parameter" name="product_search_parameter" placeholder="Informe o Parâmetro" style="width: 290px;" required>
                        
            </div>
            <!-- /.box-body -->
            <div style="margin-top: 10px;" class="box-footer">
              <button type="submit" class="btn btn-success">Pesquisar</button>                            
            </div>   

            <div class="box-body no-padding">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th style="width: 10px">#</th>
                    <th>Nome</th>
                    <th>Sequencial</th>
                    <th>Código de Barras</th>
                    <th>Descrição</th>
                    <th>Preço Unitário</th>                        
                    <th>Quantidade em Estoque</th> 
                  </tr>
                </thead>
                <tbody>
                  <?php $counter1=-1;  if( isset($itensList) && ( is_array($itensList) || $itensList instanceof Traversable ) && sizeof($itensList) ) foreach( $itensList as $key1 => $value1 ){ $counter1++; ?>
                  <tr>
                    <td><?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td><?php echo htmlspecialchars( $value1["name"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td><?php echo htmlspecialchars( $value1["sequential"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td><?php echo htmlspecialchars( $value1["barcode"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td><?php echo htmlspecialchars( $value1["description"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td><?php echo htmlspecialchars( $value1["price"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>                        
                    <td><?php echo htmlspecialchars( $value1["stockquantity"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->

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