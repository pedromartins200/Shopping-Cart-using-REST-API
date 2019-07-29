<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<div id="cartModal" class="modal">
    <!-- BEGIN MODAL -->
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">My Shopping Cart</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php $this->load->view('templates/parts/cart.php'); ?>
            </div>
        </div>
    </div>
</div>

<footer>

    <div class="container">
        Copyright © 2019-2020 <a href="https://github.com/pedromartins200"><strong>Pedro Martins <i class="fa fa-github"></i></strong></a>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="<?= base_url('assets/js/jquery-3.1.1.min.js') ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/js/challenge_js.js') ?>"></script>

    <script>var controller_url = '<?php echo site_url('') ?>'</script>
</footer>




</body>
</html>
