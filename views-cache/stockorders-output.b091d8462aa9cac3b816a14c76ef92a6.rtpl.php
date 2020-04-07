<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Lista de Pedidos de Saída
      </h1>
      <ol class="breadcrumb">
        <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="/admin/stockorders">Pedidos de Saída</a></li>
      </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
    
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
                
                <div class="box-header">
                  <a href="/admin/stockorders/create" class="btn btn-success">Cadastrar Pedido de Saída</a>
                </div>
    
                <div class="box-body no-padding">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th style="width: 100px">Código do Pedido</th>
                        <th style="width: 100px">Código da Filial</th>
                        <th style="width: 100px">Código Usuário</th>                        
                        <th>Código do Cliente</th>
                        <th>Meio de Pagamento</th>
                        <th>Tipo de Pedido</th>
                        <th>Anotação para entrega</th>
                        <th>Data do Registro</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $counter1=-1;  if( isset($stockorders) && ( is_array($stockorders) || $stockorders instanceof Traversable ) && sizeof($stockorders) ) foreach( $stockorders as $key1 => $value1 ){ $counter1++; ?>
                      <tr>
                        <td><?php echo htmlspecialchars( $value1["idstockorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                        <td><?php echo htmlspecialchars( $value1["idbranch"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                        <td><?php echo htmlspecialchars( $value1["iduser"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                        <td><?php echo htmlspecialchars( $value1["idclient"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>     
                        <td>BOLETO</td>                       
                        <td>SAÍDA</td>               
                        <td><?php echo htmlspecialchars( $value1["deliverynote"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>             
                        <td><?php echo htmlspecialchars( $value1["dtregister"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                        <td>
                          <a style="margin-bottom: 5px;" href="/admin/stockordersitem-output/create/<?php echo htmlspecialchars( $value1["idstockorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="btn btn-primary"> Ver Itens</a>
                        </td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
                <!-- /.box-body -->
              </div>              
        </div>
      </div>
    
    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->