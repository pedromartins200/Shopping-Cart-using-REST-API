<a id="btnEmpty" href="<?php echo site_url('cart/empty_cart') ?>">
    <button type="button" class="btn btn-danger">Empty Cart</button>
</a>
<table id="table_shopping_cart" class="tbl-cart" cellpadding="12" cellspacing="1">

    <thead class="thead bg-transparent">
    <tr>
        <th style="text-align:left;">Name</th>
        <th style="text-align:left;">Category</th>
        <th style="text-align:left;" width="15%">Quantity</th>
        <th style="text-align:left;" width="10%">Price</th>
        <th style="text-align:left;" width="5%">Remove</th>
    </tr>
    </thead>

    <?php if (isset($cart) ) : ?>

        <tbody>
        <?php $i = 1; ?>

        <?php foreach ($cart as $item): ?>

            <?php echo form_hidden($i . '[rowid]', $item['id']); ?>

            <tr>
                <td><img class="cart-item-image"
                         src="<?php echo base_url('assets/' . $item['image']); ?>"><?php echo $item['name'] ?></td>
                <td><?php echo $item['cat_name']; ?></td>
                <td>
                    <?php echo form_open('cart/updateCart/', array('method' => 'POST', 'id' => 'form_update_cart')); ?>
                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>"/>
                    <input type="text" style="text-align:right;width:30px;" name="quantity"
                           value="<?php echo $item['quantity'] ?>" size="1"/>
                    <button type="submit" name="button_update_quantity" style="background-color:yellow">Update</button>
                    <?php echo form_close(); ?>

                </td>
                <td style="text-align:right"><?php echo $item['price']; ?>.00€ * (<?php echo $item['quantity']; ?>)</td>
                <td style="text-align:center;"><a href="<?php echo site_url('Cart/remove_from_cart/' . $item['id']) ?>"><img
                                src="<?php echo base_url('assets/') ?>icon-delete.png" alt="Remove Item"/></a></td>
            </tr>

            <?php $i++; ?>

        <?php endforeach; ?>

        <tr>
            <td colspan="3" align="right">Total:</td>
            <td align="right"><?php echo $total_price; ?>.00€</td>
            <td></td>
        </tr>
        </tbody>
    <?php endif; ?>
</table>

<br>

<div class="text-right">
    <?php if ($logged_in == "0") : ?>
        <a href="<?php echo site_url('Auth/login') ?>">
            <button type="button" class="btn btn-primary">Login first</button>
        </a>
    <?php else: ?>
        <a href="<?php echo site_url('order') ?>">
            <button type="button" class="btn btn-primary">Order</button>
        </a>
    <?php endif; ?>
</div>


