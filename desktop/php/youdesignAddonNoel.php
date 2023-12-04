<?php
if (!isConnect('admin')) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
$plugin = plugin::byId('youdesignAddonNoel');
sendVarToJS('eqType', $plugin->getId());
$eqLogics = eqLogic::byType($plugin->getId());
?>

<div class="row row-overflow">
	<div class="col-xs-12 eqLogicThumbnailDisplay">
		<?php
			$affichage=true;
			try {
				$test = plugin::byId('youdesign');
				if ($test->isActive()) $affichage=true;
				?>
		<legend><i class="fas fa-cog"></i>  {{Gestion}}</legend>
		<div class="eqLogicThumbnailContainer">
			<div class="cursor eqLogicAction logoSecondary" data-action="addEquipment">
				<i class="fas fa-plus-circle"></i>
				<br>
				<span>{{Equipement}}</span>
			</div>
			<div class="cursor eqLogicAction logoSecondary" data-action="gotoPluginConf">
				<i class="fas fa-wrench"></i>
				<br>
				<span>{{Configuration}}</span>
			</div>		
		</div>
		<div class="input-group" style="margin-bottom:5px;">
			<input class="form-control roundedLeft" placeholder="{{Rechercher}}" id="in_searchEqlogic"/>
				<div class="input-group-btn">
					<a id="bt_resetObjectSearch" class="btn" style="width:30px"><i class="fas fa-times"></i></a>
					<a class="btn roundedRight hidden" id="bt_pluginDisplayAsTable" data-coreSupport="1" data-state="0"><i class="fas fa-grip-lines"></i></a>
				</div>
		</div>
		
		<legend><i class="fas fa-table"></i> {{Animation}}</legend>
		<div class="eqLogicThumbnailContainer">
			<?php
			foreach ($eqLogics as $eqLogic) {
				//if($eqLogic->getConfiguration('type_device') == 'devices') {
				$opacity = ($eqLogic->getIsEnable()) ? '' : 'disableCard';
				echo '<div class="eqLogicDisplayCard cursor '.$opacity.'" data-eqLogic_id="' . $eqLogic->getId() . '">';
				echo '<img class="lazy" src="plugins/youdesignAddonNoel/core/config/icones/youdesignAddonNoel.png"/>';
				echo '<br>';
				echo '<span class="name">' . $eqLogic->getHumanName(true, true) . '</span>';
				echo '</div>';					
				//}
			}
			?>
		</div>
		<legend><i class="fas fa-table"></i> {{Quelques fonds d'écran pour vos fêtes (libre de droits)}}</legend>
		<div class="eqLogicThumbnailContainer" style="width: 160px;float: left;margin-left: 10px;margin-right: 10px;">
			<div class=" cursor " style="min-width: 130px !important;height: 168px !important;margin-left: 10px !important;margin-right: 10px !important;">
				<a href="plugins/youdesignAddonNoel/core/config/img/fond-de-noel-1.jpg" target="_blank"><img class="lazy" src="plugins/youdesignAddonNoel/core/config/img/fond-de-noel-1.jpg" style="width: 100% !important;"/></a>
			</div>
		</div>	
		<div class="eqLogicThumbnailContainer" style="width: 160px;float: left;margin-left: 10px;margin-right: 10px;">	
			<div class=" cursor " style="min-width: 130px !important;height: 168px !important;margin-left: 10px !important;margin-right: 10px !important;">
				<a href="plugins/youdesignAddonNoel/core/config/img/fond-de-noel-2.jpg" target="_blank"><img class="lazy" src="plugins/youdesignAddonNoel/core/config/img/fond-de-noel-2.jpg" style="width: 100% !important;"/></a>
			</div>
		</div>	
		<div class="eqLogicThumbnailContainer" style="width: 160px;float: left;margin-left: 10px;margin-right: 10px;">	
			<div class=" cursor " style="min-width: 130px !important;height: 168px !important;margin-left: 10px !important;margin-right: 10px !important;">
				<a href="plugins/youdesignAddonNoel/core/config/img/fond-de-noel-3.jpg" target="_blank"><img class="lazy" src="plugins/youdesignAddonNoel/core/config/img/fond-de-noel-3.jpg" style="width: 100% !important;"/></a>
			</div>
		</div>	
		<div class="eqLogicThumbnailContainer" style="width: 160px;float: left;margin-left: 10px;margin-right: 10px;">	
			<div class=" cursor " style="min-width: 130px !important;height: 168px !important;margin-left: 10px !important;margin-right: 10px !important;">
				<a href="plugins/youdesignAddonNoel/core/config/img/fond-de-noel-4.jpg" target="_blank"><img class="lazy" src="plugins/youdesignAddonNoel/core/config/img/fond-de-noel-4.jpg" style="width: 100% !important;"/></a>
			</div>
		</div>	
		<div class="eqLogicThumbnailContainer" style="width: 160px;float: left;margin-left: 10px;margin-right: 10px;">	
			<div class=" cursor " style="min-width: 130px !important;height: 168px !important;margin-left: 10px !important;margin-right: 10px !important;">
				<a href="plugins/youdesignAddonNoel/core/config/img/fond-de-noel-5.jpg" target="_blank"><img class="lazy" src="plugins/youdesignAddonNoel/core/config/img/fond-de-noel-5.jpg" style="width: 100% !important;"/></a>
			</div>
		</div>	
		<div class="eqLogicThumbnailContainer" style="width: 160px;float: left;margin-left: 10px;margin-right: 10px;">	
			<div class=" cursor " style="min-width: 130px !important;height: 168px !important;margin-left: 10px !important;margin-right: 10px !important;">
				<a href="plugins/youdesignAddonNoel/core/config/img/fond-de-noel-6.jpg" target="_blank"><img class="lazy" src="plugins/youdesignAddonNoel/core/config/img/fond-de-noel-6.jpg" style="width: 100% !important;"/></a>
			</div>
		</div>	
		<div class="eqLogicThumbnailContainer" style="width: 160px;float: left;margin-left: 10px;margin-right: 10px;">	
			<div class=" cursor " style="min-width: 130px !important;height: 168px !important;margin-left: 10px !important;margin-right: 10px !important;">
				<a href="plugins/youdesignAddonNoel/core/config/img/fond-de-noel-7.jpg" target="_blank"><img class="lazy" src="plugins/youdesignAddonNoel/core/config/img/fond-de-noel-7.jpg" style="width: 100% !important;"/></a>
			</div>
		</div>	
		<div class="eqLogicThumbnailContainer" style="width: 160px;float: left;margin-left: 10px;margin-right: 10px;">	
			<div class=" cursor " style="min-width: 130px !important;height: 168px !important;margin-left: 10px !important;margin-right: 10px !important;">
				<a href="plugins/youdesignAddonNoel/core/config/img/fond-de-noel-8.jpg" target="_blank"><img class="lazy" src="plugins/youdesignAddonNoel/core/config/img/fond-de-noel-8.jpg" style="width: 100% !important;"/></a>
			</div>
		</div>
	</div>

	<div class="col-xs-12 eqLogic" style="display: none;">
		<div class="input-group pull-right" style="display:inline-flex">
			<span class="input-group-btn">
				<a class="btn btn-default btn-sm eqLogicAction roundedLeft" data-action="configure"><i class="fa fa-cogs"></i> {{Configuration avancée}}</a><a class="btn btn-default btn-sm eqLogicAction" data-action="copy"><i class="fas fa-copy"></i> {{Dupliquer}}</a><a class="btn btn-sm btn-success eqLogicAction" data-action="save"><i class="fas fa-check-circle"></i> {{Sauvegarder}}</a><a class="btn btn-danger btn-sm eqLogicAction roundedRight" data-action="remove"><i class="fas fa-minus-circle"></i> {{Supprimer}}</a>
			</span>
		</div>
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation"><a href="#" class="eqLogicAction" aria-controls="home" role="tab" data-toggle="tab" data-action="returnToThumbnailDisplay"><i class="fa fa-arrow-circle-left"></i></a></li>
			<li role="presentation" class="active"><a href="#eqlogictab" aria-controls="home" role="tab" data-toggle="tab"><i class="fas fa-tachometer-alt"></i> {{Equipement}}</a></li>
			<li role="presentation"><a href="#commandtab" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-list-alt"></i> {{Commandes}}</a></li>
		</ul>
		<div class="item-conf">				
		</div>	
		
		<?php
			} catch (Exception $e) {
				?>
		<div class="eqLogicThumbnailContainer"  style="height: calc(100vh - 50px);display: flex !important;flex-wrap: nowrap;flex-direction: row;justify-content: center;align-items: center;">
			<div class="eqLogicAction logoSecondary" style="width:270px;">
				<i class="icon icomoon-warning" style="font-size: 50px;"></i>
				<br>
				<span>{{Vous devez avoir le plugin Youdesign pour que ce plugin fonctionne}}</span>
			</div>
		</div>
				<?php
			}
		?>


	</div>
</div>

<?php include_file('desktop', 'youdesignAddonNoel', 'js', 'youdesignAddonNoel');?>
<?php include_file('core', 'plugin.template', 'js');?>
