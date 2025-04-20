<?php
/* @var $this TindakanResepController */
/* @var $index integer */
/* @var $detail ResepDetail */

// Default values
$obatId = '';
$obatName = '';
$jumlah = 1;
$dosis = '';
$keterangan = '';
$harga = 0;
$subtotal = 0;

// If detail is provided, use its values
if (isset($detail) && $detail instanceof ResepDetail) {
    $obatId = $detail->obat_id;
    $obatName = $detail->obat ? $detail->obat->nama : '';
    $jumlah = $detail->jumlah;
    $dosis = $detail->dosis;
    $keterangan = $detail->keterangan;
    $harga = $detail->obat ? $detail->obat->harga : 0;
    $subtotal = $detail->subtotal;
}
?>

<tr class="obat-row">
    <td><?php echo $index + 1; ?></td>
    <td>
        <input type="hidden" name="obat_id[]" id="obat-id-<?php echo $index; ?>" value="<?php echo $obatId; ?>" />
        <input type="hidden" name="obat_harga[]" id="obat-harga-<?php echo $index; ?>" value="<?php echo $harga; ?>" />
        <input type="hidden" name="subtotal_obat[]" id="subtotal-obat-<?php echo $index; ?>" class="subtotal-obat" value="<?php echo $subtotal; ?>" />
        <input type="text" class="obat-input" id="obat-name-<?php echo $index; ?>" data-index="<?php echo $index; ?>" value="<?php echo $obatName; ?>" placeholder="Masukkan nama obat..." />
    </td>
    <td>
        <input type="number" name="obat_jumlah[]" id="obat-jumlah-<?php echo $index; ?>" class="obat-jumlah" data-index="<?php echo $index; ?>" value="<?php echo $jumlah; ?>" min="1" />
    </td>
    <td>
        <input type="text" name="obat_dosis[]" id="obat-dosis-<?php echo $index; ?>" value="<?php echo $dosis; ?>" placeholder="Dosis..." />
    </td>
    <td>
        <input type="text" name="obat_keterangan[]" id="obat-keterangan-<?php echo $index; ?>" value="<?php echo $keterangan; ?>" placeholder="Keterangan..." />
    </td>
    <td>
        <span id="subtotal-display-<?php echo $index; ?>"><?php echo 'Rp ' . number_format($subtotal, 0, ',', '.'); ?></span>
    </td>
    <td>
        <button type="button" class="btn-remove remove-obat">✕</button>
    </td>
</tr>