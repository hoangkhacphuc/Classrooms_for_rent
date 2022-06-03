<?= $header ?>

<div class="rooms-manager-page">
    <!-- Model edit room -->
    <div class="modal fade" id="editRoomModal" tabindex="-1" role="dialog" aria-labelledby="editRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRoomModalLabel">Sửa thông tin phòng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editRoomForm" method="POST">
                        <input type="hidden" name="editRoomId" id="editRoomId">
                        <div class="form-group">
                            <label for="editRoomName">Tên phòng</label>
                            <input type="text" class="form-control" id="editRoomName" name="editRoomName" placeholder="Tên phòng">
                        </div>
                        <div class="form-group">
                            <label for="editRoomSize">Số ghế</label>
                            <input type="number" class="form-control" id="editRoomSize" name="editRoomSize" placeholder="Số ghế">
                        </div>
                        <div class="form-group">
                            <label for="editRoomPrice">Giá phòng</label>
                            <input type="number" class="form-control" id="editRoomPrice" name="editRoomPrice" placeholder="Giá phòng">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="editRoomSubmit">Lưu</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End model edit room -->
    <!-- Model create room -->
    <div class="modal fade" id="createRoomModal" tabindex="-1" role="dialog" aria-labelledby="createRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createRoomModalLabel">Tạo phòng mới</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createRoomForm" method="POST">
                        <div class="form-group">
                            <label for="createRoomName">Tên phòng</label>
                            <input type="text" class="form-control" id="createRoomName" name="createRoomName" placeholder="Tên phòng">
                        </div>
                        <div class="form-group">
                            <label for="createRoomSize">Số ghế</label>
                            <input type="number" class="form-control" id="createRoomSize" name="createRoomSize" placeholder="Số ghế">
                        </div>
                        <div class="form-group">
                            <label for="createRoomPrice">Giá phòng</label>
                            <input type="number" class="form-control" id="createRoomPrice" name="createRoomPrice" placeholder="Giá phòng">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="createRoomSubmit">Thêm</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End model create room -->

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="form-rent-header-title form-header-rooms-manager">
                    <h3>Quản lý phòng học</h3>
                    <div class="btnAdd"><button class="btn btn-success" data-toggle="modal" data-target="#createRoomModal" >Thêm phòng học</button></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="list-room-header-table">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên phòng</th>
                            <th>Số ghế</th>
                            <th>Tiền thuê/Ca</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="roomTable">
                        <?php foreach ($listRoom as $key => $value): ?>
                            <tr id="row_<?= $value['id'] ?>">
                                <td><?= $key + 1 ?></td>
                                <td><?= $value['name'] ?></td>
                                <td><?= $value['size'] ?></td>
                                <td><?= number_format($value['rentCost']) ?> VNĐ</td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-primary btn-edit-room" 
                                                data-toggle="modal" 
                                                data-target="#editRoomModal" 
                                                data-id="<?= $value['id'] ?>" 
                                                data-name="<?= $value['name'] ?>" 
                                                data-size="<?= $value['size'] ?>" 
                                                data-rentCost="<?= $value['rentCost'] ?>">Sửa</button>
                                        <button class="btn btn-danger btn-delete-room" data-id="<?= $value['id'] ?>">Xóa</button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $footer ?>