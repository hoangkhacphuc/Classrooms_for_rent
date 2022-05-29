<?= $header ?>
<div class="page-rent">
    <!-- Modal edit room rent -->
    <div class="modal fade" id="modalEditRoomRent" tabindex="-1" role="dialog" aria-labelledby="modalEditRoomRentLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditRoomRentLabel">Sửa thông tin phòng thuê</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formEditRoomRent">
                        <div class="form-group">
                            <label for="editRoomRentId">Mã phòng</label>
                            <input type="text" class="form-control" id="editRoomRentId" name="editRoomRentId" readonly>
                        </div>
                        <div class="form-group">
                            <label for="editRoomRentName">Tên phòng</label>
                            <input type="text" class="form-control" id="editRoomRentName" name="editRoomRentName" readonly>
                        </div>
                        <div class="form-group">
                            <label for="editRoomRentPrice">Giá phòng</label>
                            <input type="text" class="form-control" id="editRoomRentPrice" name="editRoomRentPrice" readonly>
                        </div>
                        <div class="form-group">
                            <label for="editRoomRentTime">Thời gian thuê</label>
                            <input type="text" class="form-control" id="editRoomRentTime" name="editRoomRentTime" readonly>
                        </div>
                        <div class="form-group">
                            <label for="editRoomRentDate">Ngày thuê</label>
                            <input type="text" class="form-control" id="editRoomRentDate" name="editRoomRentDate" readonly>
                        </div>
                        <div class="form-group">
                            <label for="editRoomRentShift">Ca thuê</label>
                            <input type="text" class="form-control" id="editRoomRentShift" name="editRoomRentShift" readonly>
                        </div>
                        <div class="form-group">
                            <label for="editRoomRentStatus">Trạng thái</label>
                            <input type="text" class="form-control" id="editRoomRentStatus" name="editRoomRentStatus" readonly>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="btnEditRoomRent">Sửa</button>
                </div>
            </div>
        </div>
    </div>

    

    <div class="list-room">
        <div class="list-room-header">
            <div class="list-room-header-title">
                <h3>Danh sách phòng đã đặt thuê</h3>
            </div>
            <div class="list-room-header-table">
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>Tên phòng</th>
                            <th>Bắt đầu</th>
                            <th>Kết thúc</th>
                            <th>Ngày sử dụng</th>
                            <th>Ngày đặt</th>
                            <th>Giá</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody id="t-room_rent">
                        <?php foreach ($rooms_rent as $room) { ?>
                            <tr>
                                <td><?= $room['name'] ?></td>
                                <td><?= $room['start'] ?></td>
                                <td><?= $room['end'] ?></td>
                                <td><?= $room['date_hire'] ?></td>
                                <td><?= number_format($room['rentCost']) ?></td>
                                <td><?= $room['created'] ?></td>
                                <td>
                                    <button type="button" data-toggle="modal" data-target="#modalEditRoomRent" class="btn btn-info" data-id="<?= $room['id_management'] ?>">Sửa</button>
                                    <button type="button" class="btn btn-danger" data-id="<?= $room['id_management'] ?>">Xóa</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Đăng ký thuê phòng theo ca -->
    <div class="form-rent">
        <div class="form-rent-header">
            <div class="form-rent-header-title">
                <h3>Đăng ký thuê phòng</h3>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <!-- select phòng -->
                    <div class="form-group">
                        <label for="room">Chọn phòng</label>
                        <select class="form-control" id="room_rent">
                            <?php foreach ($rooms as $room) { ?>
                                <option value="<?= $room['id'] ?>"><?= $room['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <!-- input date -->
                    <div class="form-group">
                        <label for="date">Ngày thuê</label>
                        <input type="date" class="form-control" id="date_rent">
                    </div>
                </div>
                <div class="col-md-4">
                    <!-- button search shifts -->
                    <div class="form-group">
                        <button type="button" class="btn btn-primary" id="btn-search">Tìm ca</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="list-room-header-table">
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <?php foreach ($shifts as $shift) { ?>
                                    <th><?= $shift['start'] .'<br>'. $shift['end'] ?></th>
                            <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="tr-list-btn">
                                <?php foreach ($shifts as $shift) { ?>
                                    <td><button class="btn btn-info" id="shift_<?= $shift['id'] ?>">Chọn</button></td>
                                <?php } ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $footer ?>