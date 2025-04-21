<?php
/* @var $this PembayaranController */
/* @var $pembayaran Pembayaran */
/* @var $tindakan array of TindakanPasien */
/* @var $obat array of ResepDetail */

$this->breadcrumbs=array(
    'Pembayaran'=>array('index'),
    'Kwitansi',
);
?>

<div class="receipt-container">
    <div class="receipt-header">
        <div class="logo">
            <h2>KLINIK INOVA MEDIKA SOLUSI</h2>
            <p>Jl. Contoh No. 123, Kota, Telp: (021) 123-4567</p>
        </div>
        <div class="receipt-title">
            <h1>KWITANSI PEMBAYARAN</h1>
            <h3>No: <?php echo $pembayaran->id.'/KW/'.date('Y', strtotime($pembayaran->tanggal_bayar)); ?></h3>
        </div>
    </div>
    
    <div class="receipt-info">
        <table>
            <tr>
                <td width="25%"><strong>Tanggal</strong></td>
                <td width="5%">:</td>
                <td width="70%"><?php echo date('d-m-Y', strtotime($pembayaran->tanggal_bayar)); ?></td>
            </tr>
            <tr>
                <td><strong>No. Registrasi</strong></td>
                <td>:</td>
                <td><?php echo $pembayaran->pendaftaran->no_registrasi; ?></td>
            </tr>
            <tr>
                <td><strong>Nama Pasien</strong></td>
                <td>:</td>
                <td><?php echo $pembayaran->pendaftaran->nama_pasien; ?></td>
            </tr>
            <tr>
                <td><strong>Jenis Kunjungan</strong></td>
                <td>:</td>
                <td><?php echo $pembayaran->pendaftaran->jenis_kunjungan; ?></td>
            </tr>
        </table>
    </div>
    
    <div class="receipt-details">
        <h3>Rincian Biaya</h3>
        
        <!-- Tindakan -->
        <table class="receipt-items">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="60%">Uraian</th>
                    <th width="10%">Jumlah</th>
                    <th width="25%">Biaya</th>
                </tr>
            </thead>
            <tbody>
                <!-- Tindakan Medis -->
                <?php if (!empty($tindakan)): ?>
                <tr>
                    <td colspan="4" class="category-header">Tindakan Medis</td>
                </tr>
                <?php foreach($tindakan as $index => $t): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo $t->tindakan ? $t->tindakan->nama : 'N/A'; ?></td>
                    <td class="center">1</td>
                    <td class="price"><?php echo 'Rp ' . number_format($t->tindakan ? $t->tindakan->tarif : 0, 0, ',', '.'); ?></td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3" class="subtotal-label">Subtotal Tindakan</td>
                    <td class="price"><?php echo 'Rp ' . number_format($pembayaran->pendaftaran->total_biaya_tindakan, 0, ',', '.'); ?></td>
                </tr>
                <?php endif; ?>
                
                <!-- Obat -->
                <?php if (!empty($obat)): ?>
                <tr>
                    <td colspan="4" class="category-header">Obat-obatan</td>
                </tr>
                <?php foreach($obat as $index => $o): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo $o->obat ? $o->obat->nama : 'N/A'; ?></td>
                    <td class="center"><?php echo $o->jumlah; ?></td>
                    <td class="price"><?php echo 'Rp ' . number_format($o->subtotal, 0, ',', '.'); ?></td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3" class="subtotal-label">Subtotal Obat</td>
                    <td class="price"><?php echo 'Rp ' . number_format($pembayaran->pendaftaran->total_biaya_resep, 0, ',', '.'); ?></td>
                </tr>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="total-label">TOTAL</td>
                    <td class="total-price"><?php echo 'Rp ' . number_format($pembayaran->total_tagihan, 0, ',', '.'); ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
    
    <div class="receipt-payment">
        <table>
            <tr>
                <td width="30%"><strong>Metode Pembayaran</strong></td>
                <td width="5%">:</td>
                <td width="65%"><?php echo $pembayaran->metode_pembayaran; ?></td>
            </tr>
            <tr>
                <td><strong>Total Dibayar</strong></td>
                <td>:</td>
                <td><?php echo 'Rp ' . number_format($pembayaran->total_dibayar, 0, ',', '.'); ?></td>
            </tr>
            <tr>
                <td><strong>Kembalian</strong></td>
                <td>:</td>
                <td><?php echo 'Rp ' . number_format($pembayaran->kembalian, 0, ',', '.'); ?></td>
            </tr>
            <?php if(!empty($pembayaran->keterangan)): ?>
            <tr>
                <td><strong>Keterangan</strong></td>
                <td>:</td>
                <td><?php echo $pembayaran->keterangan; ?></td>
            </tr>
            <?php endif; ?>
        </table>
    </div>
    
    <div class="receipt-footer">
        <div class="signature">
            <p>Petugas</p>
            <div class="sign-name"><?php echo $pembayaran->petugas ? $pembayaran->petugas->nama : 'Admin'; ?></div>
        </div>
        
        <div class="receipt-notes">
            <p>Kwitansi ini adalah bukti pembayaran yang sah.</p>
            <p>Terimakasih atas kunjungan Anda.</p>
        </div>
    </div>
    
    <div class="actions">
        <button onclick="printReceipt()" class="btn-print">Cetak Kwitansi</button>
        <a href="<?php echo $this->createUrl('index'); ?>" class="btn-back">Kembali</a>
    </div>
</div>

<script>
function printReceipt() {
    var printContents = document.querySelector('.receipt-container').innerHTML;
    var originalContents = document.body.innerHTML;
    
    // Hapus tombol cetak dan kembali untuk pencetakan
    printContents = printContents.replace(/<div class="actions">[\s\S]*?<\/div>/g, '');
    
    document.body.innerHTML = '<div class="receipt-print">' + printContents + '</div>';
    
    window.print();
    
    document.body.innerHTML = originalContents;
}
</script>

<style>
body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
}

.receipt-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ddd;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.receipt-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
    border-bottom: 2px solid #000;
    padding-bottom: 10px;
}

.logo h2 {
    margin: 0;
    font-size: 20px;
}

.logo p {
    margin: 5px 0 0;
    font-size: 14px;
}

.receipt-title {
    text-align: right;
}

.receipt-title h1 {
    margin: 0;
    font-size: 24px;
}

.receipt-title h3 {
    margin: 5px 0 0;
    font-size: 16px;
}

.receipt-info {
    margin-bottom: 20px;
}

.receipt-info table {
    width: 100%;
    border-collapse: collapse;
}

.receipt-info td {
    padding: 5px 0;
}

.receipt-details h3 {
    margin-top: 0;
    font-size: 18px;
    border-bottom: 1px solid #ddd;
    padding-bottom: 5px;
}

.receipt-items {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.receipt-items th {
    background-color: #f5f5f5;
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.receipt-items td {
    border: 1px solid #ddd;
    padding: 8px;
}

.category-header {
    background-color: #f9f9f9;
    font-weight: bold;
    text-align: left;
}

.center {
    text-align: center;
}

.price {
    text-align: right;
}

.subtotal-label {
    text-align: right;
    font-weight: bold;
    padding-right: 15px;
}

.total-label {
    text-align: right;
    font-weight: bold;
    font-size: 16px;
    padding-right: 15px;
}

.total-price {
    text-align: right;
    font-weight: bold;
    font-size: 16px;
    background-color: #f5f5f5;
}

.receipt-payment {
    margin-bottom: 30px;
}

.receipt-payment table {
    width: 100%;
    border-collapse: collapse;
}

.receipt-payment td {
    padding: 5px 0;
}

.receipt-footer {
    display: flex;
    justify-content: space-between;
    margin-top: 30px;
    margin-bottom: 30px;
}

.signature {
    text-align: center;
    width: 200px;
}

.sign-name {
    margin-top: 50px;
    border-top: 1px solid #000;
    padding-top: 5px;
    font-weight: bold;
}

.receipt-notes {
    font-size: 14px;
    font-style: italic;
    text-align: center;
    margin-top: 20px;
}

.actions {
    text-align: center;
    margin-top: 20px;
    border-top: 1px dashed #ddd;
    padding-top: 20px;
}

.btn-print {
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

.btn-print:hover {
    background-color: #45a049;
}

.btn-back {
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

.btn-back:hover {
    background-color: #e7e7e7;
    text-decoration: none;
}

/* Print styles */
@media print {
    body {
        font-size: 12pt;
    }
    
    .actions {
        display: none;
    }
    
    .receipt-container {
        border: none;
        box-shadow: none;
    }
    
    .receipt-print {
        width: 100%;
    }
}
</style>