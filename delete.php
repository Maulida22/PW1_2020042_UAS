<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check that the contact ID exists
if (isset($_GET['id'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM kontak WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Contact doesn\'t exist with that ID!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM kontak WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'Anda telah menghapus kontak!';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: read.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>


<?=template_header('Hapus')?>

<div class="Hapus Kontak">
	<h2>Hapus Kontak #<?=$contact['id']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Yakin ingin menghapus kontak #<?=$contact['id']?>?</p>
    <div class="iyatidak">
        <a href="delete.php?id=<?=$contact['id']?>&confirm=yes">Iya</a>
        <a href="delete.php?id=<?=$contact['id']?>&confirm=no">Tidak</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>