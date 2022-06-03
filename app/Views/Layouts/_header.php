<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $Page_Title ?></title>
    <base href="<?= base_url() ?>">
    <link rel="shortcut icon" href="./Assets/Image/favicon.png" type="image/x-icon">

    <!-- Google Fonts Roboto -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">

    <!-- Google Fonts Nunito -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,500,700,900" rel="stylesheet">

    <!-- Font Awesome Icons 4.7.0 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- jQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- Plugin Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <!-- Plugin Toastr -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Plugin SweetAlert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Customer -->
    <link rel="stylesheet" href="./Assets/CSS/layout.css">
    <?php if (count($Page_Resource) > 0){
        foreach ($Page_Resource as $key => $value) {
            echo $value;
        }
    }?>
</head>
<body>
    <header>
        <div class="item">
            <a href="./">Trang Chủ</a>
            <?php if (!isset($isAdmin) || (isset($isAdmin) && !$isAdmin)): ?>
                <a href="./rent">Thuê Phòng</a>
                <a href="./pay">Thanh Toán</a>
            <?php else: ?>
                <a href="./admin">Thống kê</a>
                <a href="./admin/accounts">QL Tài khoản</a>
                <a href="./admin/rooms">QL Phòng</a>
            <?php endif; ?>
        </div>
        <div class="item">
            <?php if(!$isLogin): ?>
                <a href="./login">Đăng Nhập</a>
            <?php else : ?>
                <a href="./logout">Đăng Xuất</a>
            <?php endif; ?>
        </div>
    </header>

