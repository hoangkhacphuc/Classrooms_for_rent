<?= $header ?>

<div class="page-information">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Thông tin cá nhân</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group">
                                <label for="username">Tên tài khoản</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?= $profile['user'] ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="name">Họ tên</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= $profile['full_name'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="phone">Số điện thoại</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="<?= $profile['phone_number'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="gender">Giới tính</label>
                                <select class="form-control" id="gender">
                                    <option value="1" <?= $profile['gender'] == 1 ? 'selected' : '' ?> >Nam</option>
                                    <option value="0" <?= $profile['gender'] == 0 ? 'selected' : '' ?> >Nữ</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="birth">Ngày sinh</label>
                                <input type="date" class="form-control" id="birth" name="birth" value="<?= $profile['birth'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="role">Tên tài khoản</label>
                                <input type="text" class="form-control" id="role" name="role" value="<?= $profile['role_name'] ?>" readonly>
                            </div>
                            <button type="button" id="btn-update" class="btn btn-lg btn-success btn-block">Cập nhật</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $footer ?>