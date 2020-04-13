<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Itens do Pedido de Saída
    </h1>
    <ol class="breadcrumb">
      <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="/">Itens de Pedido</a></li>
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
          <!-- form start -->
            <form role="form" action="/admin/stockordersitem-output/create/<?php echo htmlspecialchars( $idbranch, ENT_COMPAT, 'UTF-8', FALSE ); ?>/<?php echo htmlspecialchars( $iduser, ENT_COMPAT, 'UTF-8', FALSE ); ?>/<?php echo htmlspecialchars( $idclient, ENT_COMPAT, 'UTF-8', FALSE ); ?>/<?php echo htmlspecialchars( $idstockorder, ENT_COMPAT, 'UTF-8', FALSE ); ?>" method="get">
                  <div class="box-body">              
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                  <th>Código do Pedido</th>
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
                                  <td><?php echo htmlspecialchars( $idstockorder, ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
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
                        <h3>Informe o Parâmetro de Busca do Produto</h3>
                        <input type="text" class="form-control" id="product_search_parameter" name="product_search_parameter" placeholder="Código ou Nome" style="width: 417px;" required>                        
                  </div>
                        
                  <div style="margin-top: 10px;" class="box-footer">
                    <button type="submit" class="btn btn-success">Pesquisar</button>                            
                  </div> 
                  
                  <?php if( $error != '' ){ ?>
                  <div class="alert alert-danger">
                      <?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?>
                  </div>
                  <?php } ?> 
            </form>


          <!-- form start -->
          <form role="form" action="/admin/stockordersitem-output/additem" method="get">
            <div class="box-body">
            
              <table class="table table-striped">
                <thead>
                 
                  <tr>
                    <th  style="width: 200px;">Código do Produto</th>
                    <th>Nome</th>                  
                    <th>Descrição</th>  
                  </tr>
                </thead>
                <tbody>                 
                  <tr>
                    <td><?php echo htmlspecialchars( $idproduct, ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td><?php echo htmlspecialchars( $name, ENT_COMPAT, 'UTF-8', FALSE ); ?></td>                 
                    <td><?php echo htmlspecialchars( $description, ENT_COMPAT, 'UTF-8', FALSE ); ?></td>                    
                  </tr>               
                </tbody>
              </table>        
            </div>
            <!-- /.box-body -->
          </form>        
         
          <!-- form start -->
        <form role="form" action="/admin/stockordersitem-output/additem/<?php echo htmlspecialchars( $idproduct, ENT_COMPAT, 'UTF-8', FALSE ); ?>/<?php echo htmlspecialchars( $idstockorder, ENT_COMPAT, 'UTF-8', FALSE ); ?>" method="post">
               
          <div class="box-body">    
            <div class="form-group">
              <label for="requestedquantity">Quantidade Solicitada</label>
              <input type="number" class="form-control" id="requestedquantity" name="requestedquantity" placeholder="Quantidade" style="width: 140px;" required>
            </div>
            <div class="form-group">
              <label for="unitaryprice">Preço Unitário</label>
              <input type="number" class="form-control" id="unitaryprice" name="unitaryprice" placeholder="Preço" style="width: 140px;"  required>
            </div>                        
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-success">Adicionar</button>            
          </div>

          <?php if( $errorQuantityNotAvailable != '' ){ ?>
          <div style="margin-top: 15px;" class="alert alert-danger">
              <?php echo htmlspecialchars( $errorQuantityNotAvailable, ENT_COMPAT, 'UTF-8', FALSE ); ?>
          </div>
        <?php } ?> 

        </form>
          
          
          <!-- form start -->
          <form role="form">
            <div class="box-body">
            
              <table class="table table-striped">
                <thead>
                 <h3>Itens Adicionados</h3>
                  <tr>
                    <th>Código Item</th>                                   
                    <th>Status</th>                                        
                    <th>Código Pedido</th> 
                    <th>Código Produto</th> 
                    <th>Nome Produto</th> 
                    <th>Quantidade Solicitada</th> 
                    <th>Preço Unitário</th> 
                    <th>Valor Total</th> 
                  </tr>
                </thead>
                <tbody>
                  <?php $counter1=-1;  if( isset($itens) && ( is_array($itens) || $itens instanceof Traversable ) && sizeof($itens) ) foreach( $itens as $key1 => $value1 ){ $counter1++; ?>
                  <tr>                 
                    <td><?php echo htmlspecialchars( $value1["idstockorderitem"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td><?php echo htmlspecialchars( $value1["namestatus"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td><?php echo htmlspecialchars( $value1["idstockorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>  
                    <td><?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>  
                    <td><?php echo htmlspecialchars( $value1["nameproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>  
                    <td><?php echo htmlspecialchars( $value1["requestedquantity"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>  
                    <td><?php echo htmlspecialchars( $value1["unitaryvalue"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>  
                    <td><?php echo htmlspecialchars( $value1["totalvalue"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>                      
                    <td><a href="/admin/stockordersitem-output/deleteitem/<?php echo htmlspecialchars( $idstockorder, ENT_COMPAT, 'UTF-8', FALSE ); ?>/<?php echo htmlspecialchars( $value1["idstockorderitem"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" onclick="return confirm('Deseja realmente excluir este registro?')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Cancelar Pedido</a></td> 
                  </tr>
                  <?php } ?>
                </tbody>
                <tfoot>
                  <th>Soma do Valor Total dos Itens: R$ <?php echo htmlspecialchars( $totalvalueitems, ENT_COMPAT, 'UTF-8', FALSE ); ?> </th> 
                </tfoot>
              </table>        
            </div>            
          </form> 

          <a href="/admin/stockorders-output/create/checkout/<?php echo htmlspecialchars( $idbranch, ENT_COMPAT, 'UTF-8', FALSE ); ?>/<?php echo htmlspecialchars( $iduser, ENT_COMPAT, 'UTF-8', FALSE ); ?>/<?php echo htmlspecialchars( $idclient, ENT_COMPAT, 'UTF-8', FALSE ); ?>/<?php echo htmlspecialchars( $idstockorder, ENT_COMPAT, 'UTF-8', FALSE ); ?>" style="width: 90px; margin-top: 50px;" class="btn btn-primary">Concluir</a>
          <a href="/admin/stockorders-output/create/<?php echo htmlspecialchars( $idbranch, ENT_COMPAT, 'UTF-8', FALSE ); ?>/<?php echo htmlspecialchars( $iduser, ENT_COMPAT, 'UTF-8', FALSE ); ?>/<?php echo htmlspecialchars( $idclient, ENT_COMPAT, 'UTF-8', FALSE ); ?>" style="width: 90px; margin-top: 50px;" class="btn btn-danger">Cancelar</a>

          <?php if( $errorNotItens != '' ){ ?>
            <div style="margin-top: 15px;" class="alert alert-danger">
                <?php echo htmlspecialchars( $errorNotItens, ENT_COMPAT, 'UTF-8', FALSE ); ?>
            </div>
          <?php } ?> 

        </div>
      </div>
    </div>




  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->