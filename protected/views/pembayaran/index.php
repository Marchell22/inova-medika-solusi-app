<?php
/* @var $this PembayaranController */
/* @var $pasien array of PendaftaranPasien */
/* @var $tanggal string */
/* @var $query string */

$this->breadcrumbs=array(
    'Pembayaran',
);
?>

<h1>Daftar Tagihan Pasien</h1>

<?php if(Yii::app()->user->hasFlash('success')): ?>
<div class="flash-success">
    <?php echo Yii::app()->user->getFlash('success'); ?>
</div>
<?php endif; ?>

<?php if(Yii::app()->user->hasFlash('error')): ?>
<div class="flash-error">
    <?php echo Yii::app()->user->getFlash('error'); ?>
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
                <a href="<?php echo $this->createUrl('index'); ?>" class="btn-default">Reset</a>
            </div>
        </form>
    </div>
    <div class="action-buttons">
        <a href="<?php echo $this->createUrl('riwayat'); ?>" class="btn-info">Lihat Riwayat Pembayaran</a>
    </div>
</div>

<?php if(empty($pasien)): ?>
<div class="empty-data">
    <p>Tidak ada tagihan pasien yang perlu dibayar.</p>
</div>
<?php else: ?>

<table class="items table-striped">
    <thead>
        <tr>
            <th>No. Registrasi</th>
            <th>Nama Pasien</th>
            <th>Tanggal</th>
            <th>Jenis Kunjungan</th>
            <th>Total Tagihan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($pasien as $data): ?>
        <tr>
            <td><?php echo CHtml::encode($data->no_registrasi); ?></td>
            <td><?php echo CHtml::encode($data->nama_pasien); ?></td>
            <td><?php echo CHtml::encode($data->tanggal_pendaftaran); ?></td>
            <td><?php echo CHtml::encode($data->jenis_kunjungan); ?></td>
            <td class="price"><?php echo 'Rp ' . number_format($data->total_biaya, 0, ',', '.'); ?></td>
            <td>
                <a href="<?php echo $this->createUrl('detail', array('id'=>$data->id)); ?>" class="btn-action">Bayar</a>
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
    background-color: #4CAF50;
    color: white;
    text-decoration: none;
    border-radius: 3px;
}

.btn-action:hover {
    background-color: #45a049;
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