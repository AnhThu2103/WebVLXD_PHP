<?php
spl_autoload_register(function ($class) {
    require "../class/{$class}.php";
});
require '../inc/init.php';

$db = new Database();
$pdo = $db->connect();
$data = Delivery::getAll($pdo)
?>
<?php require 'inc/header.php'; ?>
<div class="container mt-3">
    <div class="row">
        <h1 class="text-center">QUẢN LÝ ĐƠN HÀNG</h1>
        <div class="col">
            <table class="table align-middle bg-light">
                <thead>
                    <tr class="text-center text-white bg-secondary">
                        <th>Ngày lập đơn hàng</th>
                        <th>Mã giỏ hàng</th>
                        <th>Tên tài khoản</th>
                        <th>Số điện thoại</th>
                        <th>Thành tiền</th>
                        <th>Địa chỉ </th>
                        <th>Tình trạng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($data){
                        $i = 1;
                        foreach($data as $row){
                            $ctgh = chitietCart::getAll($pdo, $row->magiohang);
                            $total = 0;
                            foreach ($ctgh as $cart)
                            $total += $cart->gia * $cart->soluong;
                             ?>
                        <tr class="text-center">
                            <td><?= $row->ngaylapdonhang ?></td>
                            <td><?= $row->magiohang ?></td>
                            <td><?= $row->username ?></td>
                            <td><?= $row->sodienthoai ?></td>
                            <td><?= number_format($total, 0, ',', '.') ?> VNĐ</td>
                            <td><?= $row->diachi ?></td>
                            <td><?php if(!$row->tinhtrang ){
                                echo "<select disabled = "."disabled".">
                                <option> Đã giao </option>
                                </select>";                            
                            }else{?><select>
                              <option value="<?= $row->magiohang ?>">Đã giao</option>  
                              <option selected>Chưa giao</option> 
                            </select> 
                            </td>
                        </tr>
                    <?php }}} ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require 'inc/footer.php'; ?>