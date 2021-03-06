<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<div class="container">

    <?php echo form_open('Auth/login/', array('method' => 'POST', 'id' => 'form_login_user')); ?>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <h2>Login to your account</h2>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 field-label-responsive">
            <label for="email">E-Mail Address</label>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                    <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-at"></i></div>
                    <input type="text" name="email" class="form-control" id="email"
                           placeholder="you@example.com" required autofocus>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-control-feedback">
                        <span class="text-danger align-middle">
                            <?php echo form_error('email'); ?>
                        </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 field-label-responsive">
            <label for="password">Password</label>
        </div>
        <div class="col-md-6">
            <div class="form-group has-danger">
                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                    <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-key"></i></div>
                    <input type="password" name="password" class="form-control" id="password"
                           placeholder="Password" required>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-control-feedback">
                        <span class="text-danger align-middle">
                            <?php echo form_error('password'); ?>
                        </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <button type="submit" class="btn btn-success"><i class="fa fa-user-plus"></i> Login</button>
        </div>
    </div>
    </form>
</div>