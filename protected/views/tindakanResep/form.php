<?php
/* @var $this TindakanResepController */
/* @var $pendaftaran PendaftaranPasien */
/* @var $tindakanPasien array of TindakanPasien */
/* @var $resep Resep */
/* @var $resepDetails array of ResepDetail */

Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerCoreScript('jquery.ui');

$this->breadcrumbs = array(
    'Tindakan & Resep' => array('index'),
    'Daftar Pasien' => array('daftarPasien'),
    'Form Tindakan & Resep',
);

Yii::app()->clientScript->registerScript('calculate-total', "
    function calculateTindakanTotal() {
        var total = 0;
        $('.tindakan-tarif').each(function() {
            var tarif = parseFloat($(this).val()) || 0;
            total += tarif;
        });
        $('#total-tindakan').text('Rp ' + formatNumber(total));
        
        calculateGrandTotal();
    }
    
    function calculateObatTotal() {
        var total = 0;
        $('.subtotal-obat').each(function() {
            var subtotal = parseFloat($(this).val()) || 0;
            total += subtotal;
        });
        $('#total-obat').text('Rp ' + formatNumber(total));
        
        calculateGrandTotal();
    }
    
    function calculateGrandTotal() {
        var totalTindakan = 0;
        $('.tindakan-tarif').each(function() {
            var tarif = parseFloat($(this).val()) || 0;
            totalTindakan += tarif;
        });
        
        var totalObat = 0;
        $('.subtotal-obat').each(function() {
            var subtotal = parseFloat($(this).val()) || 0;
            totalObat += subtotal;
        });
        
        var grandTotal = totalTindakan + totalObat;
        $('#grand-total').text('Rp ' + formatNumber(grandTotal));
    }
    
    function formatNumber(number) {
        return number.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
    }
    
    function updateObatSubtotal(index) {
        var jumlah = parseInt($('#obat-jumlah-' + index).val()) || 0;
        var harga = parseFloat($('#obat-harga-' + index).val()) || 0;
        var subtotal = jumlah * harga;
        
        $('#subtotal-obat-' + index).val(subtotal);
        $('#subtotal-display-' + index).text('Rp ' + formatNumber(subtotal));
        
        calculateObatTotal();
    }
    
    $(document).ready(function() {
        // Initialize totals
        calculateTindakanTotal();
        calculateObatTotal();
        
        // Setup tindakan autocomplete
        $(document).on('focus', '.tindakan-input', function() {
            var index = $(this).data('index');
            $(this).autocomplete({
                source: '" . CController::createUrl('getTindakan') . "',
                minLength: 2,
                select: function(event, ui) {
                    $('#tindakan-id-' + index).val(ui.item.id);
                    $('#tindakan-tarif-' + index).val(ui.item.tarif);
                    $('#tarif-display-' + index).text('Rp ' + formatNumber(ui.item.tarif));
                    calculateTindakanTotal();
                }
            });
        });
        
        // Setup obat autocomplete
        $(document).on('focus', '.obat-input', function() {
            var index = $(this).data('index');
            $(this).autocomplete({
                source: '" . CController::createUrl('getObat') . "',
                minLength: 2,
                select: function(event, ui) {
                    $('#obat-id-' + index).val(ui.item.id);
                    $('#obat-harga-' + index).val(ui.item.harga);
                    updateObatSubtotal(index);
                }
            });
        });
        
        // Handle jumlah change
        $(document).on('change', '.obat-jumlah', function() {
            var index = $(this).data('index');
            updateObatSubtotal(index);
        });
        
        // Add tindakan row button
        $('#add-tindakan').click(function(e) {
            e.preventDefault();
            var nextIndex = $('.tindakan-row').length;
            
            $.get('" . CController::createUrl('addTindakanRow') . "', { index: nextIndex }, function(data) {
                $('#tindakan-container').append(data);
            });
        });
        
        // Add obat row button
        $('#add-obat').click(function(e) {
            e.preventDefault();
            var nextIndex = $('.obat-row').length;
            
            $.get('" . CController::createUrl('addObatRow') . "', { index: nextIndex }, function(data) {
                $('#obat-container').append(data);
            });
        });
        
        // Remove row buttons
        $(document).on('click', '.remove-tindakan', function(e) {
            e.preventDefault();
            $(this).closest('.tindakan-row').remove();
            calculateTindakanTotal();
        });
        
        $(document).on('click', '.remove-obat', function(e) {
            e.preventDefault();
            $(this).closest('.obat-row').remove();
            calculateObatTotal();
        });
    });
", CClientScript::POS_HEAD);
?>

<h1>Form Tindakan & Resep Pasien</h1>

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
        <tr>
            <th>Keluhan:</th>
            <td colspan="3"><?php echo CHtml::encode($pendaftaran->keluhan); ?></td>
        </tr>
    </table>
</div>

<form method="post" action="<?php echo $this->createUrl('save'); ?>">
    <input type="hidden" name="pendaftaran_id" value="<?php echo $pendaftaran->id; ?>" />

    <!-- Tindakan Medis Section -->
    <div class="section-box">
        <h2>
            Tindakan Medis
            <button id="add-tindakan" class="btn-add">+ Tambah Tindakan</button>
        </h2>

        <table class="items">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="40%">Tindakan</th>
                    <th width="35%">Catatan</th>
                    <th width="15%">Tarif</th>
                    <th width="5%">Aksi</th>
                </tr>
            </thead>
            <tbody id="tindakan-container">
                <?php
                if (!empty($tindakanPasien)) {
                    foreach ($tindakanPasien as $index => $tindakan) {
                        echo $this->renderPartial('_tindakan_row', array(
                            'index' => $index,
                            'tindakan' => $tindakan,
                        ));
                    }
                } else {
                    // Render one empty row if no tindakan
                    echo $this->renderPartial('_tindakan_row', array('index' => 0));
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right"><strong>Total Tindakan:</strong></td>
                    <td id="total-tindakan">Rp 0</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Resep Obat Section -->
    <div class="section-box">
        <h2>
            Resep Obat
            <button id="add-obat" class="btn-add">+ Tambah Obat</button>
        </h2>

        <table class="items">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="25%">Obat</th>
                    <th width="5%">Jumlah</th>
                    <th width="20%">Dosis</th>
                    <th width="25%">Keterangan</th>
                    <th width="15%">Subtotal</th>
                    <th width="5%">Aksi</th>
                </tr>
            </thead>
            <tbody id="obat-container">
                <?php
                if (!empty($resepDetails)) {
                    foreach ($resepDetails as $index => $detail) {
                        echo $this->renderPartial('_obat_row', array(
                            'index' => $index,
                            'detail' => $detail,
                        ));
                    }
                } else {
                    // Render one empty row if no obat
                    echo $this->renderPartial('_obat_row', array('index' => 0));
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" class="text-right"><strong>Total Obat:</strong></td>
                    <td id="total-obat">Rp 0</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Diagnosis Section -->
    <div class="section-box">
        <h2>Diagnosis</h2>
        <textarea name="diagnosis" rows="3" class="full-width"><?php echo $resep->diagnosis; ?></textarea>
    </div>

    <!-- Total and Status Section -->
    <div class="section-box">
        <div class="total-box">
            <span class="total-label">Total Keseluruhan:</span>
            <span id="grand-total" class="grand-total">Rp 0</span>
        </div>

        <div class="status-box">
            <label>Status Kunjungan:</label>
            <label class="radio-inline">
                <input type="radio" name="status_kunjungan" value="Proses" <?php echo $pendaftaran->status_kunjungan == 'Proses' ? 'checked' : ''; ?>> Proses
            </label>
            <label class="radio-inline">
                <input type="radio" name="status_kunjungan" value="Selesai" <?php echo $pendaftaran->status_kunjungan == 'Selesai' ? 'checked' : ''; ?>> Selesai
            </label>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">Simpan</button>
            <a href="<?php echo $this->createUrl('daftarPasien'); ?>" class="btn-cancel">Batal</a>
        </div>
    </div>
</form>

<style>
    .ui-autocomplete {
        z-index: 10000 !important;
        max-height: 200px;
        overflow-y: auto;
        width: auto !important;
        border: 1px solid #ccc;
        background-color: white;
    }

    .ui-menu-item {
        padding: 5px 10px;
        cursor: pointer;
    }

    .ui-menu-item:hover {
        background-color: #f0f0f0;
    }

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
        display: flex;
        justify-content: space-between;
        align-items: center;
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

    .full-width {
        width: 100%;
        box-sizing: border-box;
        padding: 8px;
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

    .btn-add {
        background-color: #2196F3;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 3px;
        cursor: pointer;
        font-size: 12px;
    }

    .btn-add:hover {
        background-color: #0b7dda;
    }

    .btn-remove {
        background-color: #F44336;
        color: white;
        border: none;
        padding: 3px 8px;
        border-radius: 3px;
        cursor: pointer;
    }

    .btn-remove:hover {
        background-color: #d32f2f;
    }

    .total-box {
        margin: 15px 0;
        text-align: right;
        font-size: 18px;
    }

    .total-label {
        margin-right: 10px;
        font-weight: bold;
    }

    .grand-total {
        color: #4CAF50;
        font-weight: bold;
    }

    .status-box {
        margin: 15px 0;
    }

    .radio-inline {
        margin-right: 20px;
    }

    .form-actions {
        margin-top: 20px;
        text-align: right;
    }

    .btn-submit {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 3px;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-submit:hover {
        background-color: #45a049;
    }

    .btn-cancel {
        background-color: #f1f1f1;
        color: #333;
        border: 1px solid #ccc;
        padding: 8px 15px;
        border-radius: 3px;
        cursor: pointer;
        text-decoration: none;
        font-size: 14px;
        margin-left: 10px;
    }

    .btn-cancel:hover {
        background-color: #e7e7e7;
        text-decoration: none;
    }

    /* Row styles */
    .tindakan-row,
    .obat-row {
        background-color: #f9f9f9;
    }

    .tindakan-row:nth-child(even),
    .obat-row:nth-child(even) {
        background-color: #fff;
    }

    /* Input styles */
    input[type="text"],
    textarea,
    select {
        border: 1px solid #ddd;
        padding: 6px;
        border-radius: 3px;
        width: 100%;
        box-sizing: border-box;
    }

    input[type="number"] {
        width: 60px;
        text-align: center;
    }
</style>