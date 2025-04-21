<?php
/* @var $this PembayaranController */
/* @var $pembayaran array of Pembayaran */
/* @var $tanggal string */
/* @var $query string */

$this->breadcrumbs=array(
    'Pembayaran'=>array('index'),
    'Riwayat Pembayaran',
);
?>

<h1>Riwayat Pembayaran</h1>

<?php if(Yii::app()->user->hasFlash('success')): ?>
<div class="flash-success">
    <?php echo Yii::app()->user->getFlash('success'); ?>
</div>
<?php endif; ?>

<div class="search-box">
    <div class="filter-form">
        <form method="get">
            <div class="row">
                <label>Tanggal:</label>
                <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'name'=>'tanggal',
                    'value'=>$tanggal,
                    'options'=>array(
                        'showAnim'=>'fold',
                        'dateFormat'=>'yy-mm-dd',
                        'changeMonth'=>true,
                        'changeYear'=>true,
                    ),
                    'htmlOptions'=>array(
                        'class'=>'form-control',
                        'style'=>'width: 120px;',
                    ),
                ));
                ?>
            </div>
            <div class="row">
                <label>Pencarian:</label>
                <input type="text" name="query" value="<?php echo CHtml::encode($query); ?>" placeholder="Cari nama/nomor registrasi..." style="width: 200px;"/>
            </div>
            <div class="row">
                <button type="submit" class="btn-primary">Cari</button>
                <a href="<?php echo $this->createUrl('riwayat'); ?>" class="btn-default">Reset</a>
            </div>
        </form>
    </div>
    <div class="action-buttons">
        <a href="<?php echo $this->createUrl('index'); ?>" class="btn-info">Kembali ke Daftar Tagihan</a>
    </div>
</div>

<?php if(empty($pembayaran)): ?>
<div class="empty-data">
    <p>Tidak ada data pembayaran untuk periode yang dipilih.</p>
</div>
<?php else: ?>

<table class="items table-striped">
    <thead>
        <tr>
            <th>No.</th>
            <th>Tanggal Bayar</th>
            <th>No. Registrasi</th>
            <th>Nama Pasien</th>
            <th>Total Tagihan</th>
            <th>Total Dibayar</th>
            <th>Kembalian</th>
            <th>Metode</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($pembayaran as $index => $p): ?>
        <tr>
            <td><?php echo $index + 1; ?></td>
            <td><?php echo CHtml::encode($p->tanggal_bayar); ?></td>
            <td><?php echo $p->pendaftaran ? CHtml::encode($p->pendaftaran->no_registrasi) : 'N/A'; ?></td>
            <td><?php echo $p->pendaftaran ? CHtml::encode($p->pendaftaran->nama_pasien) : 'N/A'; ?></td>
            <td class="price"><?php echo 'Rp ' . number_format($p->total_tagihan, 0, ',', '.'); ?></td>
            <td class="price"><?php echo 'Rp ' . number_format($p->total_dibayar, 0, ',', '.'); ?></td>
            <td class="price"><?php echo 'Rp ' . number_format($p->kembalian, 0, ',', '.'); ?></td>
            <td><?php echo CHtml::encode($p->metode_pembayaran); ?></td>
            <td>
                <a href="<?php echo $this->createUrl('kwitansi', array('id'=>$p->id)); ?>" class="btn-action">Kwitansi</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php endif; ?>

<style>
.search-box {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
    background-color: #f5f5f5;
    padding: 15px;
    border-radius: 5px;
}

.filter-form .row {
    margin-bottom: 10px;
}

.filter-form label {
    display: inline-block;
    width: 80px;
    font-weight: bold;
}

.action-buttons {
    align-self: flex-end;
}

.items {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.items th {
    background-color: #4CAF50;
    color: white;
    padding: 10px;
    text-align: left;
}

.items td {
    padding: 8px;
    border-bottom: 1px solid #ddd;
}

.table-striped tr:nth-child(even) {
    background-color: #f2f2f2;
}

.price {
    text-align: right;
    font-weight: bold;
}

.btn-action {
    display: inline-block;
    padding: 5px 10px;
    background-color: #2196F3;
    color: white;
    text-decoration: none;
    border-radius: 3px;
}

.btn-action:hover {
    background-color: #0b7dda;
    text-decoration: none;
    color: white;
}

.btn-primary {
    background-color: #4CAF50;
    color: white;
    padding: 5px 12px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}

.btn-default {
    background-color: #f1f1f1;
    color: #333;
    padding: 5px 12px;
    border: 1px solid #ccc;
    border-radius: 3px;
    text-decoration: none;
    margin-left: 5px;
}

.btn-info {
    background-color: #2196F3;
    color: white;
    padding: 8px 15px;
    border: none;
    border-radius: 3px;
    text-decoration: none;
}

.empty-data {
    padding: 20px;
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 5px;
    text-align: center;
    margin-top: 20px;
}
</style>