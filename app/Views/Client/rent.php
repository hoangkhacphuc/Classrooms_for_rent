<?= $header ?>
<div class="page-rent">
    <div class="list-room">
        <div class="list-room-header">
            <div class="list-room-header-title">
                <h3>Danh sách phòng đã đặt thuê</h3>
            </div>
            <div class="list-room-header-table">
                <div class="fl-rent">
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th>Tên phòng</th>
                                <th>Số ghế</th>
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
                                    <td><?= $room['size'] ?></td>
                                    <td><?= $room['start'] ?></td>
                                    <td><?= $room['end'] ?></td>
                                    <td><?= $room['date_hire'] ?></td>
                                    <td><?= $room['created'] ?></td>
                                    <td><?= number_format($room['rentCost']) ?> VNĐ</td>
                                    <td>
                                        <button type="button" class="btn btn-danger" data-id="<?= $room['id_management'] ?>">Xóa</button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
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
                                <option value="<?= $room['id'] ?>"><?= $room['name'] . '  [ ' . $room['size'] . ' ghế ]' ?></option>
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
                    <div class="form-group">
                        <button type="button" class="btn btn-primary" id="btn-search">Tìm ca</button>
                        <button type="button" class="btn btn-success" id="btn-rent">Thuê phòng</button>
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
                                    <td><button class="btn" data-id="<?= $shift['id'] ?>" data-select="0" id="shift_<?= $shift['id'] ?>">Chọn</button></td>
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