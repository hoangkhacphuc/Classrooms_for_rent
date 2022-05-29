<?= $header ?>

<div class="page-login">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Đăng nhập</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="post" action="<?= base_url('login') ?>">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Tài khoản" name="username" type="text" value="" autofocus id="username">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Mật khẩu" name="password" type="password" value="" id="password">
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="button" id="btn-login" class="btn btn-lg btn-success btn-block">Đăng nhập</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $footer ?>