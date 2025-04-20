<?php
/* @var $this TindakanResepController */
/* @var $index integer */
/* @var $tindakan TindakanPasien */

// Default values
$tindakanId = '';
$tindakanName = '';
$catatan = '';
$tarif = 0;

// If tindakan is provided, use its values
if (isset($tindakan) && $tindakan instanceof TindakanPasien) {
    $tindakanId = $tindakan->tindakan_id;
    $tindakanName = $tindakan->tindakan ? $tindakan->tindakan->nama : '';
    $catatan = $tindakan->catatan;
    $tarif = $tindakan->tindakan ? $tindakan->tindakan->tarif : 0;
}
?>

<tr class="tindakan-row">
    <td><?php echo $index + 1; ?></td>
    <td>
        <input type="hidden" name="tindakan_id[]" id="tindakan-id-<?php echo $index; ?>" value="<?php echo $tindakanId; ?>" />
        <input type="hidden" name="tindakan_tarif[]" id="tindakan-tarif-<?php echo $index; ?>" class="tindakan-tarif" value="<?php echo $tarif; ?>" />
        <input type="text" class="tindakan-input" id="tindakan-name-<?php echo $index; ?>" data-index="<?php echo $index; ?>" value="<?php echo $tindakanName; ?>" placeholder="Masukkan nama tindakan..." />
    </td>
    <td>
        <input type="text" name="tindakan_catatan[]" id="tindakan-catatan-<?php echo $index; ?>" value="<?php echo $catatan; ?>" placeholder="Catatan..." />
    </td>
    <td>
        <span id="tarif-display-<?php echo $index; ?>"><?php echo 'Rp ' . number_format($tarif, 0, ',', '.'); ?></span>
    </td>
    <td>
        <button type="button" class="btn-remove remove-tindakan">✕</button>
    </td>
</tr>