<div class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 my-5">
                <div class="card my-5">
                    <div class="card-header bg-light">
                        <h5>Login Form</h5>
                    </div>
                    <div class="card-body">
                        <?php if($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger">
                                <?= $this->session->flashdata('error'); ?>
                            </div>
                        <?php endif; ?>

                        <?php if($this->session->flashdata('success')): ?>
                            <div class="alert alert-success">
                                <?= $this->session->flashdata('success'); ?>
                            </div>
                        <?php endif; ?>
                       <form action="<?= base_url('user/login') ?>" method="POST">
                       <div class="form-group">
                       <label for="mail_id">Email ID</label>
                      <input type="email" id="mail_id" name="mail_id" class="form-control" placeholder="Enter your email">
                      <small class="text-danger"><?= form_error('mail_id'); ?></small>
                    </div>

                     <div class="form-group">
                    <label for="pass_wd">Password</label>
                    <input type="password" id="pass_wd" name="pass_wd" class="form-control" placeholder="Enter password">
                    <small class="text-danger"><?= form_error('pass_wd'); ?></small>
                    </div>

                    <div class="form-group">
                     <button type="submit" class="btn btn-primary btn-block">Login</button>
                     </div>
                     </form>
                    
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
