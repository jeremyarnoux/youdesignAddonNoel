<div class="tab-content" style="height:calc(100% - 50px);overflow:auto;overflow-x: hidden;">
	<div role="tabpanel" class="tab-pane active row" id="eqlogictab">
	<br/>
		<div class="col-sm-6">
			<form class="form-horizontal">
				<fieldset>
					<div class="form-group">
					<label class="col-sm-3 control-label">{{Nom du design}}</label>
					<div class="col-sm-3">
						<input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display : none;" />
						<input type="text" class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom de l'équipement}}"/>
					</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label" >{{Objet parent}}</label>
						<div class="col-sm-3">
							<select id="sel_object" class="eqLogicAttr form-control" data-l1key="object_id">
								<option value=""></option>
									<?php
										$options = '';
										foreach ((jeeObject::buildTree(null, false)) as $object) {
											$options .= '<option value="' . $object->getId() . '">' . str_repeat('&nbsp;&nbsp;', $object->getConfiguration('parentNumber')) . $object->getName() . '</option>';
										}
										echo $options;
									?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{Catégorie}}</label>
						<div class="col-sm-9">
							<?php
								foreach (jeedom::getConfiguration('eqLogic:category') as $key => $value) {
									echo '<label class="checkbox-inline">';
									echo '<input type="checkbox" class="eqLogicAttr" data-l1key="category" data-l2key="' . $key . '" />' . $value['name'];
									echo '</label>';
								}
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label"></label>
						<div class="col-sm-9">
							<label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isEnable" checked/>{{Activer}}</label>
							<label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isVisible" checked/>{{Visible}}</label>
						</div>
					</div>
					<div class="form-group " >
					<label class="col-sm-3 control-label" >{{Musique}}</label>
						<div class="col-sm-9">
						<input class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="lienMusique" value="/plugins/youdesignAddonNoel/core/template/Christmas Village - Aaron Kenny.mp3" />
						</div>
					</div>
				</fieldset>
			</form>
		</div>
        <div class="col-sm-6">
            <div class="form-group">
                <div class="col-sm-6" style="text-align:center;margin-top:15px;">
                    <img id="iconDevice" src="" height="150" width="150"/>
                </div>
            </div>
        </div>	        
	</div>
	<div role="tabpanel" class="tab-pane" id="commandtab">
		<div class="table-responsive">		
			<table id="table_cmd" class="table table-bordered table-condensed">
				<thead>
				<tr>
				<th>{{Nom}}</th><th>{{Type}}</th><th>{{Paramètres}}</th><th>{{Configuration}}</th><th>{{Valeur}}</th><th>{{Action}}</th>
				</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
</div>	
<?php include_file('desktop', 'youdesignAddonNoel', 'js', 'youdesignAddonNoel');?>