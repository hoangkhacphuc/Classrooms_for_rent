<?= $header ?>

<div class="page-login">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Đăng ký</h3>
                    </div>
                    <div class="panel-body">
                        <form>
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Tài khoản" name="username" type="text" value="" autofocus id="username">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Mật khẩu" name="password" type="password" value="" id="password">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Nhập lại mật khẩu" name="repassword" type="password" value="" id="repassword">
                                </div>
                                <button type="button" id="btn-register" class="btn btn-lg btn-success btn-block">Đăng ký</button>
                                <div class="form-group register">
                                    <span>Bạn đã có tài khoản ? <a href="./login">Đăng nhập ngay</a></span>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $footer ?>