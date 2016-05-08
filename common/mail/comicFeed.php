<?php

use yii\helpers\Url;
use yii\helpers\Html;

$lastComicTitle = null;
?>
<?php foreach($strips as $strip){ 
	if($strip->comic->title != $lastComicTitle){ 
		echo Html::tag('h1', $strip->comic->title); 
		$lastComicTitle = $strip->comic->title;
	} ?>
<div style='margin:10px 0;'>
<?php if($strip->skip){ ?>
<a href="<?= $strip->url ?>" target="_blank">This strip is not compatible with c!y but you can click here to view it on their site</a>
<?php }elseif(is_array($strip->img)){ 
?><a href="<?= $strip->url ?>" rel="nofollow" target="_blank"><?php 
	foreach($strip->img as $k => $img){ ?>
	<img src="<?= Url::to(['comic/render-image', 'id' => (String)$strip->_id . '_' . $k], 'http') ?>" style="border:0;" />
	<?php } 
?></a><?php 
}else{ ?>
<a href="<?= $strip->comic->indexUrl($strip->index, 'http') ?>" rel="nofollow" target="_blank">
<img src="<?= Url::to(['comic/render-image', 'id' => (String)$strip->_id], 'http') ?>" style="border:0;" />
</a>
<?php } ?>
</div>
<?php } ?>