
/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */


$("#table_cmd").sortable({axis: "y", cursor: "move", items: ".cmd", placeholder: "ui-state-highlight", tolerance: "intersect", forcePlaceholderSize: true});






function callTemplate(callback){
	$.ajax({
		type: 'POST',
		url: 'plugins/youdesignAddonNoel/core/ajax/youdesignAddonNoel.ajax.php',
		async: false,
		global: false,
		data: {
			action: "getTemplate"
		},
		dataType: 'json',
		error: function (request, status, error) {
			handleAjaxError(request, status, error);
		},
		success: callback
	});		
}
$('.eqLogicAction[data-action=addEquipment]').off('click').on('click', function () {
	callTemplate(data => {
		 message = data.result;
	})  
    bootbox.confirm( message, 
		function (result) {
			if (result == false) {
				return;
			}
			if( !$('#name').val()) {
				$('#div_alert').showAlert({message: '{{Il faut renseigner un nom à l\'équipement}}', level: 'danger'});
				return;
			}
			/*alert($('#name').val());
			alert($('#sel_chatgpt').val());
			alert($('#sel_type').val());*/
			var name = $('#name').val();
			jeedom.eqLogic.save({
				type: eqType,
				eqLogics: [{name: name,configuration: {'type':'youdesignAddonNoel','type_device':'youdesignAddonNoel'}}],
				error: function (error) {
					$('#div_alert').showAlert({message: error.message, level: 'danger'});
				},
				success: function (data) {
					modifyWithoutSave = false;
					var vars = getUrlVars();
					var url = 'index.php?';
					for (var i in vars) {
						if (i != 'id' && i != 'saveSuccessFull' && i != 'removeSuccessFull') {
							url += i + '=' + vars[i].replace('#', '') + '&';
						}
					}
					url += 'id=' + data.id + '&saveSuccessFull=1';
					if (document.location.toString().match('#')) {
						url += '#' + document.location.toString().split('#')[1];
					} 
					loadPage(url);
					modifyWithoutSave = false;
				}
			});			  
    	}
	);
});

function printEqLogic(_eqLogic)  {

	if (!isset(_eqLogic)) {
		var _eqLogic = {configuration: {}};
	}
	
	if (!isset(_eqLogic.configuration)) {
	   _eqLogic.configuration = {};
	}
	
    if (isset(_eqLogic.configuration) && isset(_eqLogic.configuration.type) && _eqLogic.configuration.type == 'remoteControl') {
		$('.item-conf').empty();
        $('.item-conf').load('index.php?v=d&plugin=youdesignAddonNoel&modal=remote.configuration', function () {
            $('body').setValues(_eqLogic, '.eqLogicAttr');
            //initCheckBox();
            modifyWithoutSave = false;
        });

    } else {
		$('.item-conf').empty();
        $('.item-conf').load('index.php?v=d&plugin=youdesignAddonNoel&modal=' + _eqLogic.configuration.type_device + '.configuration', function () {
            $('body').setValues(_eqLogic, '.eqLogicAttr');
			var type = _eqLogic.configuration.type;
			  jeedom.eqLogic.getCmd({
				id: _eqLogic.id,
				error: function (error) {
				  $('#div_alert').showAlert({message: error.message, level: 'danger'});
				},
				success: function (data) {
					  $('.cmd').remove();
					  var thermo = false;
					  for (var i in data) {
						  
						if(data[i].logicalId == "refresh") {
							thermo = true;
						   
						}
						addCmdToTable(data[i]);
					  }
					 $('#iconDevice').attr('src','/plugins/youdesignAddonNoel/core/config/icones/youdesignAddonNoel.png'); 
					
				}
			  });
			$('#iconDevice').attr('src','/plugins/youdesignAddonNoel/core/config/icones/youdesignAddonNoel.png');
            //initCheckBox();
            modifyWithoutSave = false;
        });
	}
}

/*
 * Fonction pour l'ajout de commande, appellé automatiquement par plugin.template
 */
function addCmdToTable(_cmd) {
  if (!isset(_cmd)) {
    var _cmd = {configuration: {}};
  }
  var tr = '<tr class="cmd" data-cmd_id="' + init(_cmd.id) + '">';
  tr += '<td>';
  tr += '<a class="cmdAction btn btn-default btn-sm" data-l1key="chooseIcon"><i class="fa fa-flag"></i> {{Icône}}</a>';
  tr += '<span class="cmdAttr" data-l1key="display" data-l2key="icon" style="margin-left:10px;"></span>';
  tr += '<input class="cmdAttr form-control input-sm" data-l1key="name" style="margin-left:10px; margin-bottom:2px; width:185px; float:right">';
  tr += '<select class="cmdAttr form-control input-sm" data-l1key="value" style="display : none;" title="{{La valeur de la commande vaut par défaut la commande}}">';
  tr += '<option value="">Aucune</option>';
  tr += '</select>';
  tr += '</td>';
  tr += '<td>';
  tr += '<input class="cmdAttr form-control input-sm" data-l1key="id" style="display : none;">';
  tr += '<span class="type" type="' + init(_cmd.type) + '">' + jeedom.cmd.availableType() + '</span>';
  tr += '<span class="subType" subType="' + init(_cmd.subType) + '"></span>';
  tr += '</td>';
  tr += '<td>';
  tr += '<input class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="returnStateValue" placeholder="{{Valeur retour d\'état}}" style="width:48%;display:inline-block;">';
  tr += '<input class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="returnStateTime" placeholder="{{Durée avant retour d\'état (min)}}" style="width:48%;display:inline-block;margin-left:2px;">';
  tr += '</td>';
  tr += '<td>';
  tr += '<input class="tooltips cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="minValue" placeholder="{{Min}}" title="{{Min}}" style="width:30%;display:inline-block;">';
  tr += ' <input class="tooltips cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="maxValue" placeholder="{{Max}}" title="{{Max}}" style="width:30%;display:inline-block;">';
  tr += '<input class="cmdAttr form-control input-sm" data-l1key="unite" placeholder="Unité" title="{{Unité}}" style="width:30%;display:inline-block;margin-left:2px;">';
  tr += '<span><label class="checkbox-inline"><input type="checkbox" class="cmdAttr checkbox-inline" data-l1key="isVisible" checked/>{{Afficher}}</label></span> ';
  tr += '<span><label class="checkbox-inline"><input type="checkbox" class="cmdAttr checkbox-inline" data-l1key="isHistorized" checked/>{{Historiser}}</label></span> ';
  tr += '<span><label class="checkbox-inline"><input type="checkbox" class="cmdAttr" data-l1key="display" data-l2key="invertBinary"/>{{Inverser}}</label></span> ';
  tr += '</td>';
  if(typeof _cmd.state != 'undefined'){
  tr += '<td>';
  tr += _cmd.state+_cmd.unite;
  tr += '</td>';
  }else{
  tr += '<td>';
  tr += '</td>';	  
  }  
  tr += '<td style="width:125px">';
  if (is_numeric(_cmd.id)) {
    tr += '<a class="btn btn-default btn-xs cmdAction" data-action="configure"><i class="fas fa-cogs"></i></a> ';
    tr += '<a class="btn btn-default btn-xs cmdAction" data-action="test"><i class="fa fa-rss"></i> {{Tester}}</a>';
  }
  tr += ' <i class="fas fa-minus-circle cmdAction cursor" data-action="remove"></i></td>';
  tr += '</tr>';
  $('#table_cmd tbody').append(tr);
  var tr = $('#table_cmd tbody tr').last();
  jeedom.eqLogic.buildSelectCmd({
    id: $('.eqLogicAttr[data-l1key=id]').value(),
    filter: {type: 'info'},
    error: function (error) {
      $('#div_alert').showAlert({message: error.message, level: 'danger'});
    },
    success: function (result) {
      tr.find('.cmdAttr[data-l1key=value]').append(result);
      tr.setValues(_cmd, '.cmdAttr');
      jeedom.cmd.changeType(tr, init(_cmd.subType));
    }
  });
}
var ancre= window.location.hash.replace('#','');
if(ancre=='commandtab'){
	$('#eqlogictab').removeClass( "active" );
	$('#commandtab').addClass( "active" );
}