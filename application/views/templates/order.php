<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php echo form_open(site_url('Order/order_action'), array('method' => 'POST', 'id' => 'form_post_order')); ?>

<div class="container pt-5" style="margin: 0 auto;">
    <table id="table_shopping_cart" class="tbl-cart w-100" cellpadding="12" cellspacing="1" style="">

        <thead class="thead bg-transparent">
        <tr>
            <th style="text-align:left;">Name</th>
            <th style="text-align:left;">Category</th>
            <th style="text-align:left;">Quantity</th>
            <th style="text-align:right;">Price</th>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($cart as $item) : ?>
            <tr>
                <td><img class="cart-item-image"
                         src="<?php echo base_url('assets/' . $item['image']); ?>"><?php echo $item['name'] ?></td>
                <td><?php echo $item['cat_name']; ?></td>
                <td>
                    <h5><?php echo $item['quantity']; ?></h5>

                </td>
                <td style="text-align:right"><?php echo $item['price']; ?>.00€ * (<?php echo $item['quantity']; ?>)</td>
            </tr>
        <?php endforeach; ?>

        <?php if (!empty($discount_price)) : ?>
            <tr>
                <td colspan="3" align="right">Discount price:</td>
                <td align="right"><?php echo $discount_price; ?>.00€✔</td>
                <td></td>
            </tr>

        <?php else: ?>
            <tr>
                <td colspan="3" align="right">Total:</td>
                <td align="right"><?php echo $total_price; ?>.00€</td>
                <td></td>
            </tr>
        <?php endif; ?>


        </tbody>
    </table>

    <?php if (!empty($voucher_id)) : ?>
        <input type="hidden" name="voucher_id" value="<?= $voucher_id ?>">
    <?php endif; ?>

    <br>

    <label for="shipping">Shipping address: </label>
    <input type="text" name="shipping_address" required value="" id="shipping">

    <h3>We need some billing and shipping address info</h3>

    <button type="button" onclick="addFiscalInfo()">+ Add another one</button>

    <br>

    <?php if (is_countable($fiscal_info) > 0) : ?>
        <div class="row container">
            <?php $first = 0; ?>
            <?php foreach ($fiscal_info as $data): ?>
                <div class="col-md-6"
                     style="padding-bottom: 1em !important; padding-left: 2em !important;">
                    <div class="card">
                        <div class="card-body">
                            <label class="form-check-fatura">
                                <?php if ($first == 0) : ?>
                                    <input checked type="radio" name="customer_fiscal_id"
                                           value="<?= $data['id']; ?>">
                                <?php else: ?>
                                    <input type="radio" name="nif_options" value="<?= $data['id']; ?>">
                                <?php endif; ?>
                                <span class="checkmark"></span>
                            </label>
                            <br>
                            <h5 class="card-title"><strong>Singular Person Nif</strong></h5>
                            <h6 class="card-subtitle mb-2 text-muted">
                                <strong>Name: </strong><?= $data['customer_name']; ?></h6>
                            <h6 class="card-subtitle mb-2 text-muted">
                                <strong>NIF: </strong><?= $data['nif']; ?>
                            </h6>
                            <h6 class="card-subtitle mb-2 text-muted">
                                <strong>City: </strong><?= $data['city']; ?></h6>
                            <h6 class="card-subtitle mb-2 text-muted">
                                <strong>Address: </strong><?= $data['address']; ?></h6>
                            <h6 class="card-subtitle mb-2 text-muted">
                                <strong>Zip-Code: </strong><?= $data['zip_code']; ?></h6>
                        </div>
                    </div>
                </div>
                <?php $first = $first + 1; ?>
            <?php endforeach; ?>
        </div>
        <button type="submit" class="btn btn-primary">Checkout order</button>
    <?php endif; ?>


</div>


<?php echo form_close(); ?>

<?php echo form_open(site_url('Order/create_fiscal_info/'),
    array('id' => 'form_fiscal_info', 'method' => 'post')); ?>

<!-- The Modal -->
<div class="modal" id="modal_fiscal_info">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">New billing address info</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleName">Name:</label>
                    <h6 class="text-danger"><?php echo form_error('name_fiscal_info'); ?></h6>
                    <input type="text" name="name_fiscal_info" id="name_fiscal_info"
                           class="form-control required" placeholder="Name">
                    <small id="nameHelp" class="form-text text-muted">Name associated to this billing address
                    </small>
                </div>
                <div class="form-group">
                    <label for="exampleNif">NIF</label>
                    <h6 class="text-danger"><?php echo form_error('nif_fiscal_info'); ?></h6>
                    <input type="text" class="form-control required"
                           name="nif_fiscal_info" id="nif_fiscal_info" placeholder="Your vat">
                    <small id="nameHelp" class="form-text text-muted">This nif must be valid in Portugal
                </div>
                <div class="form-group">
                    <label for="country">Country</label>
                    <h6 class="text-danger"><?php echo form_error('country_fiscal_info'); ?></h6>
                    <select name="country_fiscal_info"
                            class="form-control select_country">
                        <?php foreach ($info['countries'] as $country) : ?>
                            <?php if ($country['id'] == 178) : ?>
                                <option value="<?= $country['id']; ?>"
                                        selected><?= $country['country_name']; ?></option>
                            <?php else: ?>
                                <option value="<?= $country['id']; ?>"><?= $country['country_name']; ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleCity">City</label>
                    <h6 class="text-danger"><?php echo form_error('city_fiscal_info'); ?></h6>
                    <input type="text" onkeyup="changeBorder(this);" class="form-control required"
                           name="city_fiscal_info" id="city_fiscal_info" placeholder="City">
                </div>
                <div class="form-group">
                    <label for="exampleAdress">Address</label>
                    <h6 class="text-danger"><?php echo form_error('address_fiscal_info'); ?></h6>
                    <input type="text" onkeyup="changeBorder(this);" class="form-control required"
                           name="address_fiscal_info" id="address_fiscal_info" placeholder="Address">
                </div>
                <div class="form-group">
                    <label for="exampleZipCode">Zip-Code</label>
                    <h6 class="text-danger"><?php echo form_error('zipcode_fiscal_info'); ?></h6>
                    <input type="text" onkeyup="changeBorder(this);" class="form-control required"
                           name="zipcode_fiscal_info" id="zipcode_fiscal_info" placeholder="Your zip-code">
                </div>
            </div>
            <input type="hidden" id="customer_id" name="customer_id" value="<?php echo $customer_id; ?>">

            <!-- Modal footer -->
            <div class="modal-footer">
                <button onclick="createNewBillingAddress();" id="confirm_fiscal_info" type="button"
                        class="btn btn-primary">Confirm
                </button>
            </div>

        </div>
    </div>
</div>

<?php echo form_close(); ?>
