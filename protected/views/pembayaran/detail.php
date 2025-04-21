<?php
/* @var $this PembayaranController */
/* @var $pendaftaran PendaftaranPasien */
/* @var $tindakan array of TindakanPasien */
/* @var $obat array of ResepDetail */
/* @var $model Pembayaran */

$this->breadcrumbs=array(
    'Pembayaran'=>array('index'),
    'Detail Tagihan',
);
?>

<h1>Detail Tagihan Pasien</h1>

<?php if(Yii::app()->user->hasFlash('error')): ?>
<div class="flash-error">
    <?php echo Yii::app()->user->getFlash('error'); ?>
</div>
<?php endif; ?>

<div class="patient-info-box">
    <h2>Informasi Pasien</h2>
    <table class="detail-view">
        <tr>
            <th>No. Registrasi:</th>
            <td><?php echo CHtml::encode($pendaftaran->no_registrasi); ?></td>
            <th>Tanggal:</th>
            <td><?php echo CHtml::encode($pendaftaran->tanggal_pendaftaran); ?></td>
        </tr>
        <tr>
            <th>Nama Pasien:</th>
            <td><?php echo CHtml::encode($pendaftaran->nama_pasien); ?></td>
            <th>Jenis Kelamin:</th>
            <td><?php echo CHtml::encode($pendaftaran->jenis_kelamin); ?></td>
        </tr>
        <tr>
            <th>Jenis Kunjungan:</th>
            <td><?php echo CHtml::encode($pendaftaran->jenis_kunjungan); ?></td>
            <th>Status:</th>
            <td>
                <span class="status-label status-<?php echo strtolower($pendaftaran->status_kunjungan); ?>">
                    <?php echo CHtml::encode($pendaftaran->status_kunjungan); ?>
                </span>
            </td>
        </tr>
    </table>
</div>

<div class="invoice-content">
    <!-- Tindakan Medis Section -->
    <div class="section-box">
        <h2>Rincian Tindakan Medis</h2>
        
        <table class="items">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="40%">Tindakan</th>
                    <th width="40%">Catatan</th>
                    <th width="15%">Tarif</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($tindakan)): ?>
                <tr>
                    <td colspan="4" class="empty">Tidak ada tindakan</td>
                </tr>
                <?php else: ?>
                <?php foreach($tindakan as $index => $t): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo CHtml::encode($t->tindakan ? $t->tindakan->nama : 'N/A'); ?></td>
                    <td><?php echo CHtml::encode($t->catatan); ?></td>
                    <td class="price"><?php echo 'Rp ' . number_format($t->tindakan ? $t->tindakan->tarif : 0, 0, ',', '.'); ?></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right"><strong>Total Tindakan:</strong></td>
                    <td class="price"><?php echo 'Rp ' . number_format($pendaftaran->total_biaya_tindakan, 0, ',', '.'); ?></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Resep Obat Section -->
    <div class="section-box">
        <h2>Rincian Obat</h2>
        
        <table class="items">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="35%">Obat</th>
                    <th width="10%">Jumlah</th>
                    <th width="20%">Harga</th>
                    <th width="30%">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($obat)): ?>
                <tr>
                    <td colspan="5" class="empty">Tidak ada obat</td>
                </tr>
                <?php else: ?>
                <?php foreach($obat as $index => $o): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo CHtml::encode($o->obat ? $o->obat->nama : 'N/A'); ?></td>
                    <td class="center"><?php echo CHtml::encode($o->jumlah); ?></td>
                    <td class="price"><?php echo 'Rp ' . number_format($o->obat ? $o->obat->harga : 0, 0, ',', '.'); ?></td>
                    <td class="price"><?php echo 'Rp ' . number_format($o->subtotal, 0, ',', '.'); ?></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-right"><strong>Total Obat:</strong></td>
                    <td class="price"><?php echo 'Rp ' . number_format($pendaftaran->total_biaya_resep, 0, ',', '.'); ?></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Pembayaran Form Section -->
    <div class="section-box">
        <h2>Pembayaran</h2>
        
        <div class="total-box">
            <span class="total-label">Total Tagihan:</span>
            <span class="grand-total"><?php echo 'Rp ' . number_format($pendaftaran->total_biaya, 0, ',', '.'); ?></span>
        </div>
        
        <form id="payment-form" method="post" action="<?php echo $this->createUrl('bayar'); ?>">
            <?php echo CHtml::activeHiddenField($model, 'pendaftaran_id'); ?>
            <?php echo CHtml::activeHiddenField($model, 'total_tagihan'); ?>
            <?php echo CHtml::activeHiddenField($model, 'petugas_id'); ?>
            
            <div class="form-group">
                <label for="Pembayaran_metode_pembayaran">Metode Pembayaran:</label>
                <?php echo CHtml::activeDropDownList($model, 'metode_pembayaran', 
                    array('Tunai' => 'Tunai', 'Debit' => 'Kartu Debit', 'Kredit' => 'Kartu Kredit', 'Transfer' => 'Transfer Bank'),
                    array('class' => 'form-control', 'required' => 'required')); ?>
            </div>
            
            <div class="form-group">
                <label for="Pembayaran_total_dibayar">Jumlah Dibayar:</label>
                <?php echo CHtml::activeTextField($model, 'total_dibayar', 
                    array('class' => 'form-control', 'required' => 'required', 'id' => 'payment-amount')); ?>
            </div>
            
            <div class="form-group">
                <label>Kembalian:</label>
                <input type="text" id="payment-change" value="0" readonly class="form-control" />
            </div>
            
            <div class="form-group">
                <label for="Pembayaran_keterangan">Keterangan:</label>
                <?php echo CHtml::activeTextArea($model, 'keterangan', 
                    array('class' => 'form-control', 'rows' => 3)); ?>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn-submit">Proses Pembayaran</button>
                <a href="<?php echo $this->createUrl('index'); ?>" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Hitung kembalian saat jumlah pembayaran berubah
    var paymentAmountInput = document.getElementById('payment-amount');
    var paymentChangeInput = document.getElementById('payment-change');
    var totalAmount = <?php echo $pendaftaran->total_biaya; ?>;
    
    paymentAmountInput.addEventListener('input', function() {
        var paymentAmount = parseFloat(this.value) || 0;
        var change = paymentAmount - totalAmount;
        
        if (change < 0) {
            change = 0;
            this.setCustomValidity('Jumlah pembayaran harus minimal sama dengan total tagihan');
        } else {
            this.setCustomValidity('');
        }
        
        paymentChangeInput.value = formatRupiah(change);
    });
    
    // Format rupiah
    function formatRupiah(amount) {
        return 'Rp ' + amount.toFixed(0).replace(/\d(?=(\d{3})+$)/g, '$&.');
    }
    
    // Validasi form sebelum submit
    var paymentForm = document.getElementById('payment-form');
    paymentForm.addEventListener('submit', function(event) {
        var paymentAmount = parseFloat(paymentAmountInput.value) || 0;
        
        if (paymentAmount < totalAmount) {
            event.preventDefault();
            alert('Jumlah pembayaran harus minimal sama dengan total tagihan');
        }
    });
});
</script>

<style>
.patient-info-box {
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 15px;
    margin-bottom: 20px;
}

.patient-info-box h2 {
    margin-top: 0;
    margin-bottom: 15px;
    font-size: 18px;
    border-bottom: 1px solid #ddd;
    padding-bottom: 5px;
}

.detail-view {
    width: 100%;
}

.detail-view th {
    width: 15%;
    text-align: right;
    padding: 5px 10px;
    font-weight: bold;
}

.detail-view td {
    width: 35%;
    padding: 5px 10px;
}

.section-box {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 15px;
    margin-bottom: 20px;
}

.section-box h2 {
    margin-top: 0;
    margin-bottom: 15px;
    font-size: 18px;
    border-bottom: 1px solid #ddd;
    padding-bottom: 5px;
}

.items {
    width: 100%;
    border-collapse: collapse;
}

.items th {
    background-color: #4CAF50;
    color: white;
    padding: 8px;
    text-align: left;
}

.items td {
    padding: 8px;
    border-bottom: 1px solid #ddd;
}

.items tfoot td {
    border-top: 2px solid #ddd;
    font-weight: bold;
}

.text-right {
    text-align: right;
}

.center {
    text-align: center;
}

.price {
    text-align: right;
    font-weight: bold;
}

.empty {
    text-align: center;
    font-style: italic;
    color: #777;
}

.total-box {
    margin: 15px 0;
    text-align: right;
    font-size: 20px;
    padding: 10px;
    background-color: #f5f5f5;
    border-radius: 5px;
}

.total-label {
    margin-right: 10px;
    font-weight: bold;
}

.grand-total {
    color: #4CAF50;
    font-weight: bold;
    font-size: 24px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.form-control {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box;
}

.form-actions {
    margin-top: 20px;
    text-align: right;
}

.btn-submit {
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

.btn-submit:hover {
    background-color: #45a049;
}

.btn-cancel {
    background-color: #f1f1f1;
    color: #333;
    border: 1px solid #ccc;
    padding: 9px 19px;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    font-size: 16px;
    margin-left: 10px;
}

.btn-cancel:hover {
    background-color: #e7e7e7;
    text-decoration: none;
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
</style>