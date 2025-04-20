<?php
/* @var $this TindakanResepController */
/* @var $pasien array of PendaftaranPasien */
/* @var $tanggal string */

$this->breadcrumbs=array(
    'Tindakan & Resep'=>array('index'),
    'Daftar Pasien',
);
?>

<h1>Daftar Pasien untuk Tindakan & Resep</h1>

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


<div class="patient-list">
    <?php if(empty($pasien)): ?>
        <div class="empty-message">
            Tidak ada pasien yang menunggu atau dalam proses penanganan untuk tanggal yang dipilih.
        </div>
    <?php else: ?>
        <table class="items table-striped">
            <thead>
                <tr>
                    <th>No. Registrasi</th>
                    <th>Nama Pasien</th>
                    <th>Jenis Kelamin</th>
                    <th>Jenis Kunjungan</th>
                    <th>Status</th>
                    <th>Tindakan & Resep</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($pasien as $data): ?>
                <tr class="<?php echo $data->status_kunjungan == 'Menunggu' ? 'status-waiting' : 'status-process'; ?>">
                    <td><?php echo CHtml::encode($data->no_registrasi); ?></td>
                    <td><?php echo CHtml::encode($data->nama_pasien); ?></td>
                    <td><?php echo CHtml::encode($data->jenis_kelamin); ?></td>
                    <td><?php echo CHtml::encode($data->jenis_kunjungan); ?></td>
                    <td>
                        <span class="status-label status-<?php echo strtolower($data->status_kunjungan); ?>">
                            <?php echo CHtml::encode($data->status_kunjungan); ?>
                        </span>
                    </td>
                    <td>
                        <span class="status-label status-<?php echo strtolower($data->status_tindakan_resep); ?>">
                            <?php echo CHtml::encode($data->status_tindakan_resep); ?>
                        </span>
                    </td>
                    <td>
                        <?php echo CHtml::link('Tindakan & Resep', array('form', 'id'=>$data->id), array('class'=>'btn-action')); ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<style>
.filter-form {
    margin-bottom: 20px;
    padding: 15px;
    background-color: #f9f9f9;
    border-radius: 5px;
    border: 1px solid #ddd;
}

.filter-form label {
    margin-right: 10px;
    font-weight: bold;
}

.filter-form button {
    margin-left: 10px;
}

.patient-list {
    margin-top: 20px;
}

.items {
    width: 100%;
    border-collapse: collapse;
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

.items tr:nth-child(even) {
    background-color: #f2f2f2;
}

.status-label {
    padding: 3px 8px;
    border-radius: 3px;
    font-size: 12px;
    font-weight: bold;
}

.status-menunggu {
    background-color: #FFC107;
    color: #333;
}

.status-proses {
    background-color: #2196F3;
    color: white;
}

.status-selesai {
    background-color: #4CAF50;
    color: white;
}

.status-belum {
    background-color: #F44336;
    color: white;
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
    padding: 5px 10px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}

.btn-primary:hover {
    background-color: #45a049;
}

.empty-message {
    padding: 20px;
    background-color: #f2f2f2;
    border-radius: 5px;
    text-align: center;
    color: #666;
}
</style>