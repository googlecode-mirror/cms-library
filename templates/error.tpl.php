<div class="errorblock">
	<img src="<?= lfile('images/'.$typeString[$error["number"]].'.png') ?>" alt="<?= ucfirst($typeString[$error["number"]]) ?>" class="erroricon" />
	<div class="metainfo">
		<span style="font-weight: bold;"><?= $error["file"] ?></span> on line <span style="font-weight: bold;"><?= $error["line"] ?></span>
	</div>
	<div class="errorheader"><?= ucfirst($typeString[$error["number"]]) ?></div>
	<?= $error["message"] ?>
	<div class="endfloat"></div>
	<? if (Options::debugMode()) { ?>
		<hr />
		<div class="backtrace">
			<table>
			<? foreach ($error['backtrace'] as $bt_id => $bt_info) if ($bt_id > 0) { ?>
				<tr>
					<td style="text-align: right"><?= $bt_id ?>:
					<td style="text-align:  left"><? if (isset($bt_info['file'])) { ?><?= basename($bt_info['file']) ?><? } ?>
					<td style="text-align:  left"><? if (isset($bt_info['line'])) { ?>(<?= $bt_info['line'] ?>)<? } ?>
					<td style="text-align: right"><? if (isset($bt_info['function'])) { ?><?= $bt_info['function'] ?><? } ?>
					<td style="text-align:  left"><? if (isset($bt_info['args'])) { ?>(<?= implode(', ', $bt_info['args']) ?>)<? } ?>
				</tr>
			<? } ?>
			</table>
		</div>
	<? } ?>
</div>
