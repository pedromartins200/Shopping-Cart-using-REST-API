<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<div class="container">
    <table class="table">
        <thead class="thead bg-transparent">
        <tr>
            <th style="text-align:left;">Items</th>
            <th style="text-align:left;">Created at</th>
            <th style="text-align:left;">Total price</th>
            <th style="text-align:left;">Voucher discount</th>
        </tr>

        <tbody>
        <?php foreach ($orders as $order) : ?>
            <tr>
                <td>
                    <input type="button" id="show_items<?php echo  $order['id']; ?>"
                            onclick="showOrderItems('<?php echo $user_id ?>','<?php echo $api_key; ?>', '<?php echo $order['id'] ?>', '<?php echo base_url('assets/'); ?>');"
                            class="btn btn-primary" value="Show Items">
                </td>
                <td>
                    <?= $order['created_at']; ?>
                </td>
                <td>
                    <?= $order['total']; ?>,00€
                </td>
                <td>
                    <?php if ($order['voucher_discount'] == 0) : ?>
                        No discount
                    <?php else : ?>
                        <?= $order['voucher_discount']; ?>.00% discount
                    <?php endif; ?>

                </td>
            </tr>
        <tr>
            <td colspan="4">
                <div id="order_items<?php echo $order['id']; ?>" class="d-none">
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
        </thead>
    </table>
</div>

