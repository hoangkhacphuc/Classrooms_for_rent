<?= $header ?>
<div class="page-statistical">
    <div class="statistical-box">
        <div class="statistical-box-title">
            <h3>Thống kê doanh thu</h3>
        </div>
        <div class="list-statistical">
            <div class="item">
                <div class="desc">
                    <div class="amount"><?= number_format(array_sum(array_column($revenueToday, 'rentCost'))) ?> VNĐ</div>
                    <div class="title">Doanh thu hôm nay</div>
                </div>
                <div class="icon"><i class="fa fa-bar-chart"></i></div>
            </div>
            <div class="item">
                <div class="desc">
                    <div class="amount"><?= number_format(array_sum(array_column($revenueMonth, 'rentCost'))) ?> VNĐ</div>
                    <div class="title">Doanh thu tháng này</div>
                </div>
                <div class="icon"><i class="fa fa-bar-chart"></i></div>
            </div>
            <div class="item">
                <div class="desc">
                    <div class="amount"><?= count(array_column($revenueToday, 'rentCost')) ?></div>
                    <div class="title">Phòng thuê hôm nay</div>
                </div>
                <div class="icon"><i class="fa fa-calendar-check-o"></i></div>
            </div>
            <div class="item">
                <div class="desc">
                    <div class="amount"><?= count(array_column($listRoom, 'id')) ?></div>
                    <div class="title">Tổng số phòng học</div>
                </div>
                <div class="icon"><i class="fa fa-building-o"></i></div>
            </div>
            <div class="item">
                <div class="desc">
                    <div class="amount"><?= $getAmountUserJoinThisWeek ?></div>
                    <div class="title">Thành viên mới tham gia</div>
                </div>
                <div class="icon"><i class="fa fa-user-plus"></i></div>
            </div>
            <div class="item">
                <div class="desc">
                    <div class="amount"><?= $getTotalUser ?></div>
                    <div class="title">Tổng số thành viên</div>
                </div>
                <div class="icon"><i class="fa fa-group"></i></div>
            </div>
        </div>
    </div>

    <div class="room-statistics">
        <div class="statistical-box">
            <div class="statistical-box-title">
                <h3>Thống kê phòng</h3>
            </div>
            <div class="list-statistical">
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>Tên phòng</th>
                            <th>Số ca thuê</th>
                            <th>Tổng doanh thu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($getStatisticRoom as $room): ?>
                            <tr>
                                <td><?= $room['name'] ?></td>
                                <td><?= $room['amount_shift'] ?></td>
                                <td><?= number_format($room['revenue']) ?> VNĐ</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $footer ?>