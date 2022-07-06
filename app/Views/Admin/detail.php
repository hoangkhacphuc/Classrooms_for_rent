<?= $header ?>

<div class="page-detail">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel-heading">
                    <h3 class="panel-title">Thống kê doanh thu tháng này</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Người thuê</th>
                            <th>Tên phòng</th>
                            <th>Số người</th>
                            <th>Thuê ngày</th>
                            <th>Ca thuê</th>
                            <th>Doanh thu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!isset($rooms) || count($rooms) == 0): ?>
                            <tr>
                                <td colspan="6">Không có dữ liệu</td>
                            </tr>
                        <?php else: ?>
                        <?php foreach ($rooms as $key => $value) { ?>
                            <tr>
                                <td><?= $value['name'] ?></td>
                                <td><?= $value['room_name'] ?></td>
                                <td><?= $value['size'] ?></td>
                                <td><?= date('d/m/Y', strtotime($value['date_hire'])) ?></td>
                                <td><?= $value['shift_id'] ?></td>
                                <td><?= number_format($value['rentCost']) ?> VNĐ</td>
                            </tr>
                        <?php } 
                        endif; ?>
                    </tbody>
                </table>
        </div>
    </div>
</div>

<?= $footer ?>