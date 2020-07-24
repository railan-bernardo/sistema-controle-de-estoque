<?php
  $page_title = 'Orçamento de Produto';
  require_once('inc/load.php');
    include_once('views/header_inc.php');
    $all_categories = find_all('categories');
    $all_photo = find_all('media');
?>
    
    <div class="product-big-title-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="product-bit-title text-center">
                    <h2>Orçamento</h2>
                </div>
            </div>
        </div>
    </div>
</div> <!-- End Page title area -->

<div class="single-product-area">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">
            
            <div class="col-md-12">
                <div class="product-content-right">
                    <div class="woocommerce">
                    <div class="col-md-12">
                            <img class="pull-right" src="img/print-outline.svg" style="width: 35px; height: 35px; cursor: pointer; margin-bottom: 15px;"/>
                            </div>
                        <form action="/checkout">
                            
                            <!-- <div class="alert alert-danger" role="alert">
                            Error!
                            </div> -->

                            <table cellspacing="0" class="shop_table cart">
                                <thead>
                                    <tr>
                                        <th class="product-remove">&nbsp;</th>
                                        <th class="product-thumbnail">&nbsp;</th>
                                        <th class="product-name">Produto</th>
                                        <th class="product-price">Preço</th>
                                        <th class="product-quantity">Quantidade</th>
                                        <th class="product-subtotal">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <tr class="cart_item">
                                        <td class="product-remove">
                                            <a title="Remove this item" class="remove" href="#">×</a> 
                                        </td>

                                        <td class="product-thumbnail">
                                            <a href="#"><img width="145" height="145" alt="poster_1_up" class="shop_thumbnail" src="img/product-thumb-2.jpg"></a>
                                        </td>

                                        <td class="product-name">
                                            <a href="#">Iphone zx</a> 
                                        </td>

                                        <td class="product-price">
                                            <span class="amount">R$ 700.00</span> 
                                        </td>

                                        <td class="product-quantity">
                                            <div class="quantity buttons_added">
                                                <input type="button" class="minus" value="-" onclick="window.location.href = '#'">
                                                <input type="number" size="4" class="input-text qty text" title="Qty" value="1" min="0" step="1">
                                                <input type="button" class="plus" value="+" onclick="window.location.href = '#'">
                                            </div>
                                        </td>

                                        <td class="product-subtotal">
                                            <span class="amount">R$ 700.00</span> 
                                        </td>
                                    </tr>
                                    
                                </tbody>
                            </table>

                                <div class="cart_totals ">

                                    <h2>Total</h2>

                                    <table cellspacing="0">
                                        <tbody>
                                            <tr class="cart-subtotal">
                                                <th>Avista</th>
                                                <td><span class="amount">R$ 700.00</span></td>
                                            </tr>

                                            <tr class="order-total">
                                                <th>No cartão</th>
                                                <td><strong><span class="amount">R$ 705.00</span></strong> </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </form>

                    </div>                        
                </div>                    
            </div>
        </div>
    </div>
</div>

    <?php
    include_once('views/footer.php');
?>