<?php
?>

<div class="container-fluid">

    <!-- Mensagem de alerta (item adicionado, item removido, etc... -->
    <!--<?php if (isset($cart_item_info['cart_item'])) : ?>
        <h3 class="text-info"><?= $cart_item_info['cart_item']; ?></h3>
    <?php endif; ?>-->

    <!-- Listar todos os produtos -->
    <div class="row">

        <!-- Listar todas as categorias -->
        <div class="col-md-2 pt-1">
            <h3>Categories</h3>
            <ul class="list-group">
                <a href="<?= site_url('home') ?>">
                    <?php if($category_id == 0) :?>
                        <li class="list-group-item active">All categories</li>
                    <?php else: ?>
                        <li class="list-group-item">All categories</li>
                    <?php endif; ?>
                </a>
                <?php foreach ($categories as $category) : ?>
                    <a class="text-dark" href="<?= site_url('home/index/' . $category['id']) ?>">
                        <?php if($category_id == $category['id']) :?>
                            <li class="list-group-item active"><?= $category['name'] ?></li>
                        <?php else: ?>
                            <li class="list-group-item"><?= $category['name'] ?></li>
                        <?php endif; ?>

                    </a>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="col-md-1">

        </div>

        <div class="col-md-9">
            <div class="row">
                <?php if (!empty($products)) : ?>
                    <?php foreach ($products as $row) : ?>
                        <div class="col-sm-4 col-lg-4 col-md-4 p-2">
                            <div class="thumbnail">
                                <img src="<?php echo base_url('assets/' . $row['image']); ?>"/>
                                <div class="caption">
                                    <h4 class="pull-right"><?php echo $row['price']; ?>,00€</h4>
                                    <h4><?php echo $row['name']; ?></h4>
                                    <p><?php echo $row['description']; ?></p>
                                </div>
                                <div class="atc">
                                    <?php echo validation_errors(); ?>
                                    <?php echo form_open('cart/cart_item_insert/', array('method' => 'POST', 'id' => 'form_add_item_cart')); ?>
                                    <input type="hidden" name="product_id" value="<?= $row['id']; ?>">
                                    <input type="text" name="quantity" value="1" size="1"/>
                                    <button type="submit"
                                            class="btn btn-success">
                                        Add to Cart
                                    </button>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Product(s) not found...</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
