<?
if(!check_perms('admin_donor_log')) { error(403); }

include(SERVER_ROOT.'/sections/donate/config.php');

show_header('Bitcoin donation balance');

$Balance = btc_balance() . " BTC";
$Receiveds = btc_received();
$DB->query("SELECT i.UserID, i.BitcoinAddress FROM users_info AS i JOIN users_main AS m ON m.ID = i.UserID
			WHERE BitcoinAddress IS NOT NULL ORDER BY m.Username ASC");
?>
<div class="thin">
	<h3><?=$Balance?></h3>
	<table>
	<tr>
		<th>Username</th>
		<th>Receiving bitcoin address</th>
		<th>Amount</th>
	</tr>
<?
while ($row = $DB->next_record()) {
	$amount = false;
	foreach ($Receiveds as $R) {
		if ($R->address == $row['BitcoinAddress']) {
			$amount = $R->amount . ' BTC';
		}
	}
	if ($amount === false) { continue; }
	?>
	<tr>
		<td><?=format_username($row['UserID'], true, false, false, false)?></td>
		<td><tt><?=$row['BitcoinAddress']?></tt></td>
		<td><?=$amount?></td>
	</tr>
	<?
}
?>
	</table>
</div>
<? show_footer(); ?>
