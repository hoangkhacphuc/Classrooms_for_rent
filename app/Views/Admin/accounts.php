<?= $header ?>

<div class="accounts-manager-page">
    <!-- Model create account -->
    <div class="modal fade" id="createAccountModal" tabindex="-1" role="dialog" aria-labelledby="createAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createAccountModalLabel">Tạo tài khoản</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createAccountForm">
                        <div class="form-group">
                            <label for="createAccountUsername">Tên tài khoản</label>
                            <input type="text" class="form-control" id="createAccountUsername" placeholder="Tên tài khoản">
                        </div>
                        <div class="form-group">
                            <label for="createAccountPassword">Mật khẩu</label>
                            <input type="password" class="form-control" id="createAccountPassword" placeholder="Mật khẩu">
                        </div>
                        <div class="form-group">
                            <label for="createAccountRePassword">Nhập lại mật khẩu</label>
                            <input type="password" class="form-control" id="createAccountRePassword" placeholder="Nhập lại mật khẩu">
                        </div>
                        <div class="form-group">
                            <label for="createAccountName">Họ tên</label>
                            <input type="text" class="form-control" id="createAccountName" placeholder="Tên">
                        </div>
                        <div class="form-group">
                            <label for="createAccountPhone">Số điện thoại</label>
                            <input type="text" class="form-control" id="createAccountPhone" placeholder="Số điện thoại">
                        </div>
                        <div class="form-group">
                            <label for="createAccountBirthday">Ngày sinh</label>
                            <input type="date" class="form-control" id="createAccountBirthday" placeholder="Ngày sinh">
                        </div>
                        <div class="form-group">
                            <label for="createAccountGender">Giới tính</label>
                            <select class="form-control" id="createAccountGender">
                                <option value="1">Nam</option>
                                <option value="0">Nữ</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="createAccountRole">Vai trò</label>
                            <select class="form-control" id="createAccountRole">
                                <option value="1">Super Admin</option>
                                <option value="2">Khách hàng</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="createAccountSubmit">Tạo</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End model create account -->
    <div class="container">
        <div class="accounts-manager-page-header">
            <div class="accounts-manager-page-header-title form-header-rooms-manager">
                <h3>Quản lý tài khoản</h3>
                <div class="btnAdd"><button class="btn btn-success" data-toggle="modal" data-target="#createAccountModal" >Thêm tài khoản</button></div>
            </div>
            <div class="row">
                <div class="list-account-header-table">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên tài khoản</th>
                                <th>Họ tên</th>
                                <th>Số điện thoại</th>
                                <th>Giới tính</th>
                                <th>Ngày sinh</th>
                                <th>Ngày tạo</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="accountsTable">
                            <?php foreach ($listUser as $key => $value): ?>
                                <tr id="row_<?= $value['id'] ?>">
                                    <td><?= $key + 1 ?></td>
                                    <td><?= $value['user'] ?></td>
                                    <td><?= $value['name'] ?></td>
                                    <td><?= $value['phone_number'] ?></td>
                                    <td><?= $value['gender'] == 0 ? 'Nữ' : 'Nam' ?></td>
                                    <td><?= $value['birth'] ?></td>
                                    <td><?= $value['created'] ?></td>
                                    <td><button class="btn btn-danger" id="btn-remove-account" data-id="<?= $value['id'] ?>">Xóa</button></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $footer ?>