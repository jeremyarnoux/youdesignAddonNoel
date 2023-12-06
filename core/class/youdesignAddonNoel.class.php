<?php

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

/* * ***************************Includes********************************* */
require_once __DIR__  . '/../../../../core/php/core.inc.php';

class youdesignAddonNoel extends eqLogic {

	public static function dependancy_info() {

    }

    public static function dependancy_install() {
    }
    
	
	  // Fonction exécutée automatiquement avant la création de l'équipement
	  public function preInsert() {
	  }

	  // Fonction exécutée automatiquement après la création de l'équipement
	  public function postInsert() {
	  }

	  // Fonction exécutée automatiquement avant la mise à jour de l'équipement
	  public function preUpdate() {
	  }

	  // Fonction exécutée automatiquement après la mise à jour de l'équipement
	  public function postUpdate() {
	  }

	  // Fonction exécutée automatiquement avant la suppression de l'équipement
	  public function preRemove() {
	  }

	  // Fonction exécutée automatiquement après la suppression de l'équipement
	  public function postRemove() {
	  }
	   /*
	  * Permet de crypter/décrypter automatiquement des champs de configuration des équipements
	  * Exemple avec le champ "Mot de passe" (password)
	  public function decrypt() {
		$this->setConfiguration('password', utils::decrypt($this->getConfiguration('password')));
	  }
	  public function encrypt() {
		$this->setConfiguration('password', utils::encrypt($this->getConfiguration('password')));
	  }
	  */

	  /*
	  * Permet de modifier l'affichage du widget (également utilisable par les commandes)
	  public function toHtml($_version = 'dashboard') {}
	  */

	  /*
	  * Permet de déclencher une action avant modification d'une variable de configuration du plugin
	  * Exemple avec la variable "param3"
	  public static function preConfig_param3( $value ) {
		// do some checks or modify on $value
		return $value;
	  }
	  */

	  /*
	  * Permet de déclencher une action après modification d'une variable de configuration du plugin
	  * Exemple avec la variable "param3"
	  public static function postConfig_param3($value) {
		// no return value
	  }
	  */	
    public function preSave() {
    }
	public function postSave() {

		$this->setConfiguration('lienMusique','/plugins/youdesignAddonNoel/core/template/Christmas%20Village%20-%20Aaron%20Kenny.mp3');
		//$eq = $this->getEqlogic();
		$content = file_get_contents(__DIR__ . '/../config/devices/youdesignAddonNoel.json');
		if (!is_json($content)) {
			log::add('youdesignAddonNoel','debug', 'no json content ' . $this->getConfiguration('type'));
		}
		$device = json_decode($content, true);
		if (!is_array($device) || !isset($device['commands'])) {
			log::add('youdesignAddonNoel','debug', 'no array : ' . $this->getName());

		}
		$link_cmds = array();
		$tableau_cmds_actions=array();
		$tableau_cmds_info=array();
		foreach ($device['commands'] as $command) {
			$youdesignAddonNoelCmd = $this->getCmd(null, $command['logicalId']);
			if ( !is_object($youdesignAddonNoelCmd) ) {
				$youdesignAddonNoelCmd = new youdesignAddonNoelCmd();
				$youdesignAddonNoelCmd->setEqLogic_id($this->getId());			
			}
			utils::a2o($youdesignAddonNoelCmd, $command);
			$youdesignAddonNoelCmd->save();
			if($youdesignAddonNoelCmd->getType()=='action'){
				if($youdesignAddonNoelCmd->getValue() != '') $tableau_cmds_actions[$youdesignAddonNoelCmd->getLogicalId()]=$youdesignAddonNoelCmd->getValue();
			}
			if($youdesignAddonNoelCmd->getType()=='info'){
				$tableau_cmds_info[$youdesignAddonNoelCmd->getLogicalId()]=$youdesignAddonNoelCmd->getName();
			}		
		}
		foreach ($tableau_cmds_actions as $cmdAction_logicalId => $cmdInfo_value) {
			$cmdAction = $this->getCmd(null, $cmdAction_logicalId);
			$cmdInfo = $this->getCmd(null, $cmdInfo_value);
			if (is_object($cmdAction) && is_object($cmdInfo)) { 
				$cmdAction->setValue($cmdInfo->getId());
				$cmdAction->save();
				log::add('youdesignAddonNoel', 'debug', 'mise à jour de la commande action ('.$cmdAction_logicalId.') avec value: '.$cmdInfo_value,true);
			}
		}
		//$this->setIsEnable();  
		//log::add('youdesignAddonNoel','debug', 'postInsert: '.print_r($this,true));
		$cmd = $this->getCmd(null, 'repetition_musique_info');
		$repetition_musique_info = $cmd->execCmd();
		if($repetition_musique_info==''){
			$this->checkAndUpdateCmd('repetition_musique_info', '0');
			$this->checkAndUpdateCmd('musique', '0');
			$this->checkAndUpdateCmd('neige', '0');
		}	
	}

	public function toHtml($_version = 'dashboard') {
		$this->emptyCacheWidget();
		log::add('youdesignAddonNoel', 'debug', 'tohtml');
		$replace = $this->preToHtml($_version);
		if (!is_array($replace)) {
			return $replace;
		}
		$cmd = $this->getCmd(null, 'musique');
		$musique = $cmd->execCmd();
		$replace['#musique#'] = $musique;
		log::add('youdesignAddonNoel', 'debug', 'musique: '.$musique);
		$cmd = $this->getCmd(null, 'neige');
		$neige = $cmd->execCmd();
		$replace['#neige#'] = $neige;
		$cmd = $this->getCmd(null, 'repetition_musique_info');
		$repetition_musique_info = $cmd->execCmd();
		$replace['#repetition_musique#'] = $repetition_musique_info;
		
		$replace['#lienMusique#'] = $this->getConfiguration('lienMusique');
		//if($this->getConfiguration('musique')) $replace['#musique#'] = 'true'; else $replace['#musique#'] = 'true';
		//if($this->getConfiguration('neige')) $replace['#neige#'] = 'true'; else $replace['#neige#'] = 'true';
		return $this->postToHtml($_version, template_replace($replace, getTemplate('core', '', 'animationNoel' , __CLASS__)));
		//return parent::toHtml($_version,'ok');
		/*try{
			$replace = $this->preToHtml($_version);
			if (!is_array($replace)) {
				return $replace;
			}
			$version = jeedom::versionAlias($_version);
			$cmd = $this->getCmd(null, 'temperature');
			$temp = $cmd->execCmd();
			$data = explode('.',$temp);
			$replace['#intNumTemp#'] = $data[0];
			$replace['#decNumTemp#'] = $data[1];
			$cmd = $this->getCmd(null, 'humidity');
			$replace['#humidity#'] = $cmd->execCmd();
			return $this->postToHtml($_version, template_replace($replace, getTemplate('core', $version, 'WoSensorTH', 'youdesignAddonNoel')));	
		} catch(Exception $e) {
			log::add('youdesignAddonNoel', 'error', 'error :' . $e);
		}*/
	}	
}

class youdesignAddonNoelCmd extends cmd {
	  /*     * *************************Attributs****************************** */

	  /*
	  public static $_widgetPossibility = array();
	  */

	  /*     * ***********************Methode static*************************** */


	  /*     * *********************Methode d'instance************************* */

	  /*
	  * Permet d'empêcher la suppression des commandes même si elles ne sont pas dans la nouvelle configuration de l'équipement envoyé en JS
	  public function dontRemoveCmd() {
		return true;
	  }
	  */

	  // Exécution d'une commande
    public function execute($_options = array()) {
		/*log::add('youdesignAddonNoel','debug', 'requete ajax debut commande');
		log::add('youdesignAddonNoel','debug', 'getType: '.$this->getType());
		log::add('youdesignAddonNoel','debug', 'this: '.print_r($this,true));
		log::add('youdesignAddonNoel','debug', 'option: '.print_r($_options,true));
		log::add('youdesignAddonNoel','debug', 'option: '.print_r($this->getEqLogic_id(),true));
		log::add('youdesignAddonNoel','debug', 'option: '.print_r($this->logicalId,true));

		log::add('youdesignAddonNoel','debug', 'option: '.print_r($this->value,true));*/
		$eqTest = new eqLogic();
		$eqTest=$eqTest->byId($this->getEqLogic_id());
		switch($this->logicalId){
			case 'on_musique': $eqTest->checkAndUpdateCmd('musique', '1');$eqTest->refreshWidget();
							break;

			case 'off_musique': $eqTest->checkAndUpdateCmd('musique', '0');$eqTest->refreshWidget();
							break;

			case 'on_neige': $eqTest->checkAndUpdateCmd('neige', '1');$eqTest->refreshWidget();
							break;

			case 'off_neige': $eqTest->checkAndUpdateCmd('neige', '0');$eqTest->refreshWidget();
							break;
			case 'repetition_musique': $eqTest->checkAndUpdateCmd('repetition_musique_info', $_options['select']);$eqTest->refreshWidget();
							break;

		}
		/*if ($this->getLogicalId() == 'refresh') {
			$eq = $this->getEqlogic();
			$eq->refreshWidget();
			log::add('youdesignAddonNoel','debug', 'Refresh.......');
			return;
		  }*/
  


		if ($this->getType()== 'info') {
			return;
		}
		
		
    }
}


