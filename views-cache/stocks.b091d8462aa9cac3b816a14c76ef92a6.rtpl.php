<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Lista de Estoques
      </h1>
      <ol class="breadcrumb">
        <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="/admin/stocks">Estoques</a></li>
      </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
    
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
                
                <div class="box-header">
                  <a href="/admin/stocks/create" class="btn btn-success">Cadastrar Estoque</a>
                </div>
    
                <div class="box-body no-padding">
                  <table class="table table-striped">
                    <thead>
                      <tr>                       
                        <th style="width: 100px">Código da Filia</th>
                        <th>Nome Filial</th>                       
                        <th style="width: 100px">Código do Produto</th>     
                        <th>Nome Produto</th>                                            
                        <th>Quantidade</th>                                            
                        <th>Preço Unitário</th>                                            
                        <th>Data do Registo do Estoque</th>                                            
                      </tr>
                    </thead>
                    <tbody>
                      <?php $counter1=-1;  if( isset($stocks) && ( is_array($stocks) || $stocks instanceof Traversable ) && sizeof($stocks) ) foreach( $stocks as $key1 => $value1 ){ $counter1++; ?>
                      <tr>                                           
                        <td><?php echo htmlspecialchars( $value1["idbranch"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                        <td><?php echo htmlspecialchars( $value1["namebranch"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                        <td><?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                        <td><?php echo htmlspecialchars( $value1["nameproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                        <td><?php echo htmlspecialchars( $value1["quantity"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                        <td><?php echo htmlspecialchars( $value1["price"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                        <td><?php echo htmlspecialchars( $value1["dtregister"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
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