<?php

Class Controller_Admin_CodeGenerator Extends Controller_Admin_Base 
{	
	function indexAction() 
	{
		
		//get all tables from database
		$stmt = $this->registry->db->query('SHOW TABLES');
		while ($row = $stmt->fetch(PDO::FETCH_NUM)) 
		{
			$tables[] = $row[0];
		}
						
				
		$this->registry->smarty->assign(array( 'tables' => $tables	
												));
		
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');
		
		$this->registry->smarty->assign(array(	'pageTitle'	=> 'Code Generator',
												'contents' 	=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
		
	} 
	
	function generateAction() 
	{
		$success = $error = $information = $formData = array();
		$table = $this->registry->router->getArg('table');
		
		$columnData = array();
		$indexColumnData = array();

		if($table == '')
		{
			$error[] = 'Table not found.';
		}
		else
		{
			
			//check directory to save files
			$directories['model'] = SITE_PATH . 'classes/core/';
			$directories['controlleradmin'] = SITE_PATH . 'controllers/{{CONTROLLER_GROUP}}/';
			$directories['languageadmin'] = SITE_PATH . 'language/' . $this->registry->langCode . '/{{CONTROLLER_GROUP}}/';
			$directories['templateadmin'] = SITE_PATH . $this->registry->smarty->template_dir . '/_controller/{{CONTROLLER_GROUP}}/';
			$formData['directories'] = $directories;
			
			//template files
			$source_basedir = SITE_PATH . $this->registry->smarty->template_dir . '/' . $this->registry->smartyControllerContainer . 'generate_format/';
			$source['model'] = $source_basedir . 'model.tpl';
			$source['controlleradmin'] = $source_basedir . 'controller_admin.tpl';
			$source['languageadmin'] = $source_basedir . 'language_admin.tpl';
			$source['controlleradminindex'] = $source_basedir . 'controller_admin_index.tpl';
			$source['controlleradminadd'] = $source_basedir . 'controller_admin_add.tpl';
			$source['controlleradminedit'] = $source_basedir . 'controller_admin_edit.tpl';


			$tableWithoutPrefix = str_replace(TABLE_PREFIX, '', $table);
			
			//default Classname
			$formData['fmodule'] = $formData['fadmincontroller'] = $this->getDefaultClassName($table);
			$formData['MODULE_LOWER'] = strtolower($formData['fmodule']);
			$formData['ftablealias'] = $this->getDefaultTableAlias($tableWithoutPrefix);
			
			
			
			//get table fields detail
			$sql = 'SHOW COLUMNS FROM ' . $table;
			try{
				$stmt = $this->registry->db->query($sql);
				$columnData = $stmt->fetchAll();
			}catch(Exception $e)
			{
				$error[] = $e->getMessage();
			}

			//get table index detail
			$sql = 'SHOW INDEX FROM ' . $table;
			try{
				$stmt = $this->registry->db->query($sql);
				$indexData = $stmt->fetchAll();

				if(count($indexData) > 0)
				{
					foreach($indexData as $indexInfo)
					{
						$indexColumnData[] = $indexInfo['Column_name'];
					}
				}
			}catch(Exception $e)
			{
				$error[] = $e->getMessage();
			}

			
			
			//get column prefix, based on PRIMARY KEY name
			$primaryField = '';
			foreach($columnData as $columnDetail)
			{
				foreach($columnDetail as $key => $value )
				{
					if($key == 'Key' && $value == 'PRI')
					{
						$primaryField = $columnDetail['Field'];
					}
				}
			}
			//check if primaryField had the underscore _
			$primaryParts = explode('_', $primaryField);
			if($primaryParts[0] != $primaryField)
			{
				$columnPrefix = $primaryParts[0] . '_';
			}
			else
			{
				$columnPrefix = '';
			}
			
			//tracking text field in column base on data type
			//to enable in search text
			$formData['textfield'] = array();
			
			//build the Default Property after remove the columnPrefix
			foreach($columnData as $columnDetail)
			{
				//remove column Prefix for Model Property
				$propValue = str_replace($columnPrefix, '', $columnDetail['Field']);
				
				//remove remain underscores in property name
				$propValue = str_replace('_', '', $propValue);
				
				$formData['fprop'][$columnDetail['Field']] = $propValue;

				$labeltmpvalue = ucfirst($propValue);
				switch($propValue)
				{
					case 'id': $labeltmpvalue = 'ID'; break;
					case 'ipaddress': $labeltmpvalue = 'IP Address'; break;
					case 'displayorder': $labeltmpvalue = 'Display Order'; break;
					case 'datecreated' : $labeltmpvalue = 'Date Created'; break;
					case 'datemodified': $labeltmpvalue = 'Date Modified'; break;
				}

				$formData['flabel'][$columnDetail['Field']] = $labeltmpvalue;
				
				
				if(stripos($columnDetail['Type'], 'char') !== false || stripos($columnDetail['Type'], 'text') !== false)
				{
					$formData['textfield'][] = $columnDetail['Field'];
				}
			}
			
		}
		
		
		//start generating
		if(isset($_POST['fsubmit']))
		{
			$formData = array_merge($formData, $_POST);
			
			$directories['model'] = SITE_PATH . 'classes/core/';
			$directories['controlleradmin'] = SITE_PATH . 'controllers/'.strtolower($formData['fcontrollergroup']).'/';
			$directories['languageadmin'] = SITE_PATH . 'language/' . $this->registry->langCode . '/'.strtolower($formData['fcontrollergroup']).'/';
			$directories['templateadmin'] = SITE_PATH . $this->registry->smarty->template_dir . '/_controller/' .strtolower($formData['fcontrollergroup']).'/';
			
			
			$formData['directories'] = $directories;
			$formData['tableWithoutPrefix'] = $tableWithoutPrefix;
			$formData['primaryfield'] = $primaryField;
			
			//assign default filterable
			$formData['ffilterable'][$primaryField] = 1;
			$formData['fsortable'][$primaryField] = 1;
			
			//refine prop array because there is no character outside [a-z0-9_]
			foreach($formData['fprop'] as $k => $v)
			{
				$formData['fprop'][$k] = preg_replace('/[^a-z0-9_]/ims', '_', $v);
				$formData['ftypeshort'][$k] = $this->getColumnTypeShort($formData['ftype'][$k]);
			}
			
			if($this->generateValidate($formData, $error))
			{
				//Process directory of model, bacause can put model class file in subfolder
				if(strlen(trim($formData['fmodulesubdirectory'])) > 0)
				{
					//Refine subdirectory string, not include double // and not start with /
					$formData['fmodulesubdirectory'] = preg_replace('/(\/){2,}/', '/', strtolower(trim($formData['fmodulesubdirectory'])));
					if($formData['fmodulesubdirectory'][0] == '/')
						$formData['fmodulesubdirectory'] = substr($formData['fmodulesubdirectory'], 1);
					if($formData['fmodulesubdirectory'][strlen($formData['fmodulesubdirectory'])-1] != '/')
						$formData['fmodulesubdirectory'] .= '/';

					//Prefix for Class name to indicate correct directory of model file
					$formData['fmodelclassprefix'] = '';
					$modulesubdirectoryParts = explode('/', $formData['fmodulesubdirectory']);
					foreach($modulesubdirectoryParts as $modulesubdirectoryName)
					{
						if(strlen($modulesubdirectoryName) > 0)
							$formData['fmodelclassprefix'] .= ucfirst($modulesubdirectoryName) . '_';
					}

					$directories['model'] .= $formData['fmodulesubdirectory'];
				}

				//destination
				$destination['model'] = $directories['model'] . 'class.'.strtolower($formData['fmodule']) . '.php';
				
				//check enable generating Admin Controller
				if(isset($formData['fadmincontrollertoggler']))
				{
					$adminmodule = strtolower($formData['fadmincontroller']);
					
					$destination['controlleradmin'] = $directories['controlleradmin'] . 'class.'.$adminmodule.'.php';
					$destination['languageadmin'] = $directories['languageadmin'] . $adminmodule . '.xml';
					
					//create Admin template directory to save generated TPL files.
					$savetplfiles = false;
					$admintemplatedirectory = $directories['templateadmin'] . $adminmodule;
					if(!file_exists($admintemplatedirectory))
					{
						if(!mkdir($admintemplatedirectory))
						{
							$error[] = 'Error while creating directory <code>'.$directories['templateadmin'] . $adminmodule.'</code> to store Admin template files.';
						}
						else
						{
							$savetplfiles = true;
						}
					}
					else
					{
						if(!is_writable($admintemplatedirectory))
						{
							$error[] = 'Directory <code>'.$admintemplatedirectory.'</code> is not writable to save generated tpl files.';
						}
						else
						{
							$savetplfiles = true;
						}
					}
					
					if($savetplfiles)
					{
						$destination['controlleradminindex'] = $directories['templateadmin'] . $adminmodule . '/index.tpl';
						$destination['controlleradminadd'] = $directories['templateadmin'] . $adminmodule . '/add.tpl';
						$destination['controlleradminedit'] = $directories['templateadmin'] . $adminmodule . '/edit.tpl';
					}
					
				}
				
				
				//looping through source file
				foreach($destination as $index => $destpath)
				{
					$overwrite = false;
					if(!file_exists($destpath) || (file_exists($destpath) && isset($formData['foverwrite'])))
					{
						$overwrite = true;
					}
					
					//start writing
					if($overwrite)
					{
						$sourcecontent = file_get_contents($source[$index]);
						$replaceData = $this->getSearchReplaceInfo($formData);
						
						
						$sourcecontent = str_replace($replaceData['search'], $replaceData['replace'], $sourcecontent);
						
						if(file_put_contents($destpath, $sourcecontent) !== false)
						{
							$success[] = 'Saved file <code>'.$destpath.'</code> successfully.';
						}
						else
						{
							$error[] = 'Error while saving file <code>'. $destpath . '</code>.';
						}
					}
					else
					{
						$information[] = 'File <code>'.$destpath.'</code> Existed, check Overwrite to save new file.';
					}
					
				}
			}
			

		}				
				
		$this->registry->smarty->assign(array( 	'success' => $success,
												'error'	=> $error,
												'information' => $information,
												'formData' => $formData,
												'table' => $table,
												'tableWithoutPrefix' => $tableWithoutPrefix,
												'columnData' => $columnData,
												'indexColumnData' => $indexColumnData
												));
		
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'generate.tpl');
		
		$this->registry->smarty->assign(array(	'pageTitle'	=> 'Code Generating',
												'contents' 	=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
		
	}
	
	
	
	
	####################################################################################################
	####################################################################################################
	####################################################################################################
	
	private function generateValidate($formData, &$error)
	{
		$pass = true;
		
		//validate MODEL settings
		if(strlen($formData['fmodule']) == 0)
		{
			$pass = false;
			$error[] = 'Model Class Name is not valid. Please input the Class name';
		}
		
		if(strlen($formData['ftablealias']) == 0)
		{
			$pass = false;
			$error[] = 'Table prefix is requirement.';
		}
		
		foreach($formData['fprop'] as $k => $v)
		{
			if(strlen($v) == 0)
			{
				$pass = false;
				$error[] = 'Model Mapping Key <code>' . $k . '</code> is required.';
			}
		}
		
		if(!is_writable($formData['directories']['model']))
		{
			$pass = false;
			$error[] = 'Directory <code>'.$formData['directories']['model'].'</code> is not writable for saving generated MODEL.';
		}
		
		
		
		//validate ADMIN CONTROLLER settings
		if(isset($formData['fadmincontrollertoggler']))
		{
			if(!in_array($formData['fcontrollergroup'], array('Cms', 'Crm', 'Erp', 'Admin', 'Profile', 'Stat')))
			{
				$pass = false;
				$error[] = 'Controller Group Not valid.';
			}
			
			foreach($formData['flabel'] as $k => $v)
			{
				if(strlen($v) == 0)
				{
					$pass = false;
					$error[] = 'Admin Language Label Mapping Key <code>' . $k . '</code> is required.';
				}
			}
			
			foreach($formData['directories'] as $k => $directory)
			{
				if(!is_writable($directory) && $k != 'model')
				{
					$pass = false;
					$error[] = 'Directory <code>'.$directory.'</code> is not writable.';
				}
			}
		}
		
		return $pass;
	}
	
	/**
	 * Return default valid Model Class Name based on table name
	 */
	private function getDefaultClassName($table)
	{
		//remove TABLE_PREFIX
		$table = str_replace(TABLE_PREFIX, '', $table);
		
		//explode to get table parts (if had)
		$parts = explode('_', $table);
		
		$classname = '';
		foreach($parts as $part)
		{
			$classname .= ucfirst($part);
		}
		
		return $classname;
	}
	
	/**
	 * Return alias from table.
	 * default is the first letter of each word in table name. Words are seperated by underscore.
	 */
	private function getDefaultTableAlias($table)
	{
		$alias = '';
		$words = explode('_', $table);
		foreach($words as $word)
		{
			$alias .= $word[0];
		}
		
		return $alias;
	}
	
	/**
	 * Create search/replace pattern data to build the final generated files.
	 */
	private function getSearchReplaceInfo($formData)
	{
		
		$s = array();
		
		############################################
		############################################
		##	MODEL.TPL
		############################################
		############################################
		$s['{{MODULE_PREFIX}}'] = $formData['fmodelclassprefix'];
		$s['{{DB_OBJECT}}'] = isset($formData['fdbobject']) ? $formData['fdbobject'] : 'db'; 
		$s['{{MODULE_SUBDIRECTORY}}'] = $formData['fmodulesubdirectory'];

		$s['{{MODULE}}'] = $formData['fmodelclassprefix'] . $formData['fmodule'];
		$s['{{MODULE_SIMPLIFY}}'] = $formData['fmodule'];
		$s['{{MODULE_LOWER}}'] = strtolower($formData['fmodule']);
		
		//{{DATECREATED_ASSIGN}}
		$tmp = '';
		foreach ($formData['fprop'] as $k => $v) 
		{
			if($v == 'datecreated')
			{
				$tmp = "\$this->datecreated = time();\n\n";
				
				//add to exclude list to prevent add/edit in TPL
				$formData['fexclude'][$k] = 1;
			}
		}
		$s['{{DATECREATED_ASSIGN}}'] = $tmp;
		//end---
		
		//{{DATEMODIFIED_ASSIGN}}
		$tmp = '';
		foreach ($formData['fprop'] as $k => $v) 
		{
			if($v == 'datemodified')
			{
				$tmp = "\$this->datemodified = time();\n\n";
				
				//add to exclude list to prevent add/edit in TPL
				$formData['fexclude'][$k] = 1;
			}
		}
		$s['{{DATEMODIFIED_ASSIGN}}'] = $tmp;
		//end---
		
		//{{PROPERTY}}

		if(isset($formData['fconstantable']) && count($formData['fconstantable']) > 0)
		{
			foreach($formData['fprop'] as $k => $v)
			{

			}
		}

		$tmp = "\n";
		$constantData = array();
		foreach($formData['fprop'] as $k => $v)
		{
			$tmp .= "\t" . 'public $'.$v.' = ' . $this->getDefaultValueFromColumnType($formData['ftypeshort'][$k]) . ';' . "\n";

			//check this is constant
			if(isset($formData['fconstantable'][$k]) && strlen($formData['fconstantable'][$k]) > 0)
			{
				//Constant format: CONSTANT1:value1:text,CONSTANT2:value2:text2,...
				$constantGroups = explode(',', $formData['fconstantable'][$k]);
				foreach($constantGroups as $constantGroup)
				{
					$constantInfo = explode(':', $constantGroup);
					if(count($constantInfo) == 3)
					{
						$constantData[$k][] = $constantInfo;
					}
				}
			}
		}

		$tmpConstant = '';
		$tmpFunctionConstantFull = '';

		//append ConstantData before Property define
		if(!empty($constantData))
		{
			foreach($constantData as $k => $constantGroups)
			{
				//////////////////////////
				//DEFINE CONSTANT
				foreach($constantGroups as $constantInfo)
				{
					$tmpConstant .= "\n\tconst " . $constantInfo[0] . " = " . $constantInfo[1] . ";";
				}
				$tmpConstant .= "\n";

				//////////////////////////
				// RELATED METHODS FOR CONSTANT
				$filetemplatefunctionConstant = SITE_PATH . $this->registry->smarty->template_dir . '/' . $this->registry->smartyControllerContainer . 'generate_format/model_function_constant.tpl';
				if(file_exists($filetemplatefunctionConstant))
				{
					$st = array();
					
					$st['{{PROPERTYCONSTANTUCFIRST}}'] = ucfirst($formData['fprop'][$k]);
					$st['{{PROPERTYCONSTANT}}'] = $formData['fprop'][$k];
					$st['{{PROPERTYCONSTANT_LIST}}'] = '';
					$st['{{PROPERTYCONSTANT_GETNAME}}'] = '';
					$st['{{PROPERTYCONSTANT_CHECK}}'] = '';

					foreach($constantGroups as $constantInfo)
					{
						$st['{{PROPERTYCONSTANT_LIST}}'] .= "\$output[self::".$constantInfo[0]."] = '".$constantInfo[2]."';\n\t\t";
						$st['{{PROPERTYCONSTANT_GETNAME}}'] .= "case self::".$constantInfo[0].": \$name = '".$constantInfo[2]."'; break;\n\t\t\t";

						if($st['{{PROPERTYCONSTANT_CHECK}}'] != '')
							$st['{{PROPERTYCONSTANT_CHECK}}'] .= "\n\t\t\t || ";
						$st['{{PROPERTYCONSTANT_CHECK}}'] .= "(\$this->".$formData['fprop'][$k]." == self::".$constantInfo[0]." && \$name == '".strtolower($constantInfo[2])."')";
					}

					$tmpFunctionConstant = file_get_contents($filetemplatefunctionConstant);

					if($tmpFunctionConstant != '')
					{
						$tmpFunctionConstant = strtr($tmpFunctionConstant, $st);
						$tmpFunctionConstant = strtr($tmpFunctionConstant, $s);

						//Assign for output
						$tmpFunctionConstantFull .= $tmpFunctionConstant;
					}
					else
						throw new Exception('Can not OPEN tpl file for generate related methods for constant property (Not found file tpl at '.$filetemplatefunctionConstant.').');		
				}
				else
				{
					throw new Exception('Can not FIND tpl file for generate related methods for constant property (Not found file tpl at '.$filetemplatefunctionConstant.').');
				}
				

			}
		}

		$s['{{PROPERTY}}'] = $tmpConstant . $tmp;
		$s['{{FUNCTION_CONSTANT}}'] = $tmpFunctionConstantFull;

		//end---
		
		$s['{{PRIMARY_FIELD}}'] = $formData['primaryfield'];
		$s['{{PRIMARY_PROPERTY}}'] = $formData['fprop'][$formData['primaryfield']];
		$s['{{TABLE_WITHOUT_PREFIX}}'] = $formData['tableWithoutPrefix'];
		
		//{{PROPERTY_ADD_LIST}}
		//{{PROPERTY_ADD_QUESTIONMARK}}
		//{{PROPERTY_ADD_BINDING}}
		//{{FUNCTION_GETMAXDISPLAYORDER}}


		$tmpColumn = array();
		$tmpQuestionmark = array();
		$tmpBinding = array();
		$tmpFunctionGetMaxDisplayOrder = '';
		foreach($formData['fprop'] as $k => $v)
		{
			if($k != $formData['primaryfield'] && $v != 'datemodified')
			{
				
				$tmpColumn[] = $k;
				$tmpQuestionmark[] = '?';
				
				if($formData['ftypeshort'][$k] == 'int')
				{
					if(isset($formData['fipaddressable'][$k]))
						$tmpBinding[] = '(int)Helper::getIpAddress(true)';
					elseif(isset($formData['fdisplayorderable'][$k]))
					{
						$tmpBinding[] = '(int)$this->getMaxDisplayOrder()';

						
						$filetemplatefunctionGetMaxDisplayOrder = SITE_PATH . $this->registry->smarty->template_dir . '/' . $this->registry->smartyControllerContainer . 'generate_format/model_function_getmaxdisplayorder.tpl';
						if(file_exists($filetemplatefunctionGetMaxDisplayOrder))
						{
							$st = array();
							//generate function getMaxDisPlayOrder()
							$st['{{FUNCTION_DISPLAYORDER_COLUMN}}'] = $k;
							$st['{{FUNCTION_DISPLAYORDER_GROUPWHERE}}'] = '';
							$st['{{FUNCTION_DISPLAYORDER_GROUPBINDING}}'] = '';

							if(isset($formData['fdisplayordergroup'][$k]) && $formData['fdisplayordergroup'][$k] != '')
							{
								$st['{{FUNCTION_DISPLAYORDER_GROUPWHERE}}'] = 'WHERE '.$formData['fdisplayordergroup'][$k].' = ?';
								$st['{{FUNCTION_DISPLAYORDER_GROUPBINDING}}'] = '$this->'.$formData['fprop'][$formData['fdisplayordergroup'][$k]];
							}

							$tmpFunctionGetMaxDisplayOrder = file_get_contents($filetemplatefunctionGetMaxDisplayOrder);

							if($tmpFunctionGetMaxDisplayOrder != '')
							{
								$tmpFunctionGetMaxDisplayOrder = strtr($tmpFunctionGetMaxDisplayOrder, $st);
								$tmpFunctionGetMaxDisplayOrder = strtr($tmpFunctionGetMaxDisplayOrder, $s);
							}
							else
								throw new Exception('Can not OPEN tpl file for generate function getMaxDisplayOrder() (Not found file tpl at '.$filetemplatefunctionGetMaxDisplayOrder.').');		
						}
						else
						{
							throw new Exception('Can not FIND tpl file for generate function getMaxDisplayOrder() (Not found file tpl at '.$filetemplatefunctionGetMaxDisplayOrder.').');
						}
						

					}
					else
						$tmpBinding[] = '(int)$this->' . $v;
				}
				elseif($formData['ftypeshort'][$k] == 'float')
					$tmpBinding[] = '(float)$this->' . $v;
				else
					$tmpBinding[] = '(string)$this->'.$v;
			}

		}
		$s['{{PROPERTY_ADD_LIST}}'] = implode(",\n\t\t\t\t\t", $tmpColumn);
		$s['{{PROPERTY_ADD_QUESTIONMARK}}'] = implode(', ', $tmpQuestionmark);
		$s['{{PROPERTY_ADD_BINDING}}'] = implode(",\n\t\t\t\t\t", $tmpBinding);
		$s['{{FUNCTION_GETMAXDISPLAYORDER}}'] = $tmpFunctionGetMaxDisplayOrder;

		//end---



		
		
		//{{PROPERTY_UPDATE_LIST}}
		//{{PROPERTY_UPDATE_BINDING}}
		$tmpColumn = array();
		$tmpBinding = array();
		foreach($formData['fprop'] as $k => $v)
		{
			if($k != $formData['primaryfield'] && $v != 'datecreated' && !isset($formData['fipaddressable'][$k]))
			{
				
				$tmpColumn[] = $k . ' = ?';
				if($formData['ftypeshort'][$k] == 'int')
					$tmpBinding[] = '(int)$this->' . $v;
				elseif($formData['ftypeshort'][$k] == 'float')
					$tmpBinding[] = '(float)$this->' . $v;
				else
					$tmpBinding[] = '(string)$this->'.$v;
					
			}
		}
		$s['{{PROPERTY_UPDATE_LIST}}'] = implode(",\n\t\t\t\t\t", $tmpColumn);
		$s['{{PROPERTY_UPDATE_BINDING}}'] = implode(",\n\t\t\t\t\t", $tmpBinding);
		//end---
		
		//{{PROPERTY_ASSIGN_DATA_THIS}} 
		//{{PROPERTY_ASSIGN_DATA_CLASS}}
		$tmp = '';
		$tmp2 = '';
		foreach($formData['fprop'] as $k => $v)
		{
			//Custom assign for IP ADDRESS FIELD
			if(isset($formData['fipaddressable'][$k]))
			{
				$tmp .= '$this->' . $v . ' = (string)long2ip($row[\''.$k.'\']);' . "\n\t\t";
				$tmp2 .= '$my'.$formData['fmodule'].'->' . $v . ' = (string)long2ip($row[\''.$k.'\']);' . "\n\t\t\t";
			}
			else
			{
				$tmp .= '$this->' . $v . ' = ('.$formData['ftypeshort'][$k].')$row[\''.$k.'\'];' . "\n\t\t";
				$tmp2 .= '$my'.$formData['fmodule'].'->' . $v . ' = ('.$formData['ftypeshort'][$k].')$row[\''.$k.'\'];' . "\n\t\t\t";
			}
			
		}
		$s['{{PROPERTY_ASSIGN_DATA_THIS}}'] = $tmp;
		$s['{{PROPERTY_ASSIGN_DATA_CLASS}}'] = $tmp2;
		//end---
		
		$s['{{TABLE_ALIAS_NODOT}}'] = $formData['ftablealias'];
		$s['{{TABLE_ALIAS_DOT}}'] = $formData['ftablealias'] . '.';
		
		//{{MODULE_FILTERABLE}}
		$filterable = '';
		foreach($formData['fprop'] as $k => $v)
		{
			if(isset($formData['ffilterable'][$k]))
			{
				$defaultValue = $this->getDefaultValueFromColumnType($formData['ftypeshort'][$k]);
				
				if($formData['ftypeshort'][$k] == 'int')
				{
					//custom for IP Address search
					if(isset($formData['fipaddressable'][$k]))
					{
						$a = '!= \'\'';
						$assign = "'.(int)ip2long(\$formData['f{$v}']).'";
					}
					else
					{
						$a = '> 0';
						$assign = "'.(int)\$formData['f{$v}'].'";
					}
				}
				elseif($formData['ftypeshort'][$k] == 'float')
				{
					$a = '> 0';
					$assign = "'.(float)\$formData['f{$v}'].'";
				}
				else
				{
					$a = '!= \'\'';
					$assign = "\"'.Helper::unspecialtext((string)\$formData['f{$v}']).'\"";
				}
				

				if($formData['ftypeshort'][$k] == 'int')
					$b = '(int)';
				elseif($formData['ftypeshort'][$k] == 'float')
					$b = '(float)';
				else
					$b = '(string)';
				
				$filterable .= "\n\t\tif(\$formData['f$v'] $a)\n\t\t\t\$whereString .= (\$whereString != '' ? ' AND ' : '') . '{$formData['ftablealias']}.$k = {$assign} ';\n";
				
			}
		}
		$s['{{MODULE_FILTERABLE}}'] = $filterable;
		//end---
		
		//{{MODULE_SEARCHABLETEXT}}
		$searchabletext = array();
		foreach($formData['fprop'] as $k => $v)
		{
			if(isset($formData['fsearchabletext'][$k]))
			{
				$searchabletext[] = array($k, $v);
			}
		}
		$searchabletextString = '';
		
		if(count($searchabletext) > 0)
		{
			$searchabletextString .= "\n\t\tif(strlen(\$formData['fkeywordFilter']) > 0)\n\t\t{\n\t\t\t\$formData['fkeywordFilter'] = Helper::unspecialtext(\$formData['fkeywordFilter']);\n";
			
			for($i = 0; $i < count($searchabletext); $i++)
			{
				$searchabletextString .= "\n\t\t\t";
				if($i > 0)
					$searchabletextString .= 'else';
				$searchabletextString .= "if(\$formData['fsearchKeywordIn'] == '".$searchabletext[$i][1]."')\n\t\t\t\t\$whereString .= (\$whereString != '' ? ' AND ' : '') . '".$formData['ftablealias'].".".$searchabletext[$i][0]." LIKE \'%'.\$formData['fkeywordFilter'].'%\'';";
				
				$combinegroup[] = "(".$formData['ftablealias'].".".$searchabletext[$i][0]." LIKE \'%'.\$formData['fkeywordFilter'].'%\')";
			}
			
			//else, combine all
			
			$searchabletextString .= "\n\t\t\telse\n\t\t\t\t\$whereString .= (\$whereString != '' ? ' AND ' : '') . '( ".implode(' OR ', $combinegroup)." )';";
			
			$searchabletextString .= "\n\t\t}";
			
		}
		
		$s['{{MODULE_SEARCHABLETEXT}}'] = $searchabletextString;
		//end---
		
		//{{MODULE_SORTABLE}}
		$sortable = array();
		foreach($formData['fprop'] as $k => $v)
		{
			if(isset($formData['fsortable'][$k]))
			{
				$sortable[] = array($k, $v);
			}
		}
		
		$sortableString = '';
		for($i = 0; $i < count($sortable);$i++)
		{
			$sortableString .= "\n\t\t";
			if($i > 0)
				$sortableString .= 'else';
			$sortableString .= "if(\$sortby == '".$sortable[$i][1]."')\n\t\t\t\$orderString = '".$sortable[$i][0]." ' . \$sorttype; ";
		}
		
		if(count($sortable) > 0)
			$sortableString .= "\n\t\telse\n\t\t\t";
		else
			$sortableString .= "\n\t\t";
		$sortableString .= "\$orderString = '".$formData['primaryfield']." ' . \$sorttype;";

		$s['{{MODULE_SORTABLE}}'] = $sortableString;
		//end---
		
		
		
		
		############################################
		############################################
		##	CONTROLLER_ADMIN.TPL
		############################################
		############################################
		//{{CONTROLLERGROUP}}
		$s['{{CONTROLLERGROUP}}'] = $formData['fcontrollergroup'];
		
		//{{FILTERABLE_GET_ARGUMENTS}}
		//{{FILTERABLE_APPLY_FORMDATA}}
		$tmpArgs = '';
		$tmpApply = '';
		foreach($formData['ffilterable'] as $k => $v)
		{
			$defaultValue = $this->getDefaultValueFromColumnType($formData['ftypeshort'][$k]);
			
			$prop = $formData['fprop'][$k];
			
			if($formData['ftypeshort'][$k] == 'int')
				$typename = '(int)';
			elseif($formData['ftypeshort'][$k] == 'float')
				$typename = '(float)';
			else
				$typename = '(string)';
			
			$tmpArgs .= "\n\t\t\$".$prop."Filter = ".$typename."(\$this->registry->router->getArg('".$prop."'));";
			
			if($defaultValue === 0)
			{
				$applyCondition = '> 0';
			}
			else
			{
				$applyCondition = '!= ""';
			}
			
			$tmpApply .= "\n\n\t\tif(\$".$prop."Filter ".$applyCondition.")\n\t\t{\n\t\t\t\$paginateUrl .= '".$prop."/'.\$".$prop."Filter . '/';\n\t\t\t\$formData['f".$prop."'] = \$".$prop."Filter;\n\t\t\t\$formData['search'] = '".$prop."';\n\t\t}";
			
		}
		$s['{{FILTERABLE_GET_ARGUMENTS}}'] = $tmpArgs;
		$s['{{FILTERABLE_APPLY_FORMDATA}}'] = $tmpApply;
		//end---
		
		//{{SEARCHABLETEXT_GET_ARGUMENTS}}
		//{{SEARCHABLETEXT_APPLY_FORMDATA}}
		$tmpArgs = '';
		$tmpApply = '';
		if(count($formData['fsearchabletext']) > 0)
		{
			$tmpArgs = "\n\t\t\$keywordFilter = (string)\$this->registry->router->getArg('keyword');\n\t\t\$searchKeywordIn= (string)\$this->registry->router->getArg('searchin');";
		
			//build if conditional for searchkeyword in
			$i = 0;
			foreach($formData['fsearchabletext'] as $k => $v)
			{
				$tmpApply .= "\n\t\t\t";
				if($i > 0)
					$tmpApply .= 'else';
				$tmpApply .= "if(\$searchKeywordIn == '".$formData['fprop'][$k]."')\n\t\t\t{\n\t\t\t\t\$paginateUrl .= 'searchin/".$formData['fprop'][$k]."/';\n\t\t\t}";
				$i++;
			}
			
			$tmpApply = "\n\t\tif(strlen(\$keywordFilter) > 0)\n\t\t{\n\t\t\t\$paginateUrl .= 'keyword/' . \$keywordFilter . '/';\n".$tmpApply."\n\t\t\t\$formData['fkeyword'] = \$formData['fkeywordFilter'] = \$keywordFilter;\n\t\t\t\$formData['fsearchin'] = \$formData['fsearchKeywordIn'] = \$searchKeywordIn;\n\t\t\t\$formData['search'] = 'keyword';\n\t\t}";
		}
		$s['{{SEARCHABLETEXT_GET_ARGUMENTS}}'] = $tmpArgs;
		$s['{{SEARCHABLETEXT_APPLY_FORMDATA}}'] = $tmpApply;
		//end---
		
		//{{CONSTANT_CONTROLLER_ASSIGN}}
		$tmp = '';
		if(!empty($constantData))
		{
			foreach($constantData as $k => $constantGroups)
			{
				$tmp .= "\n\t\t\t\t\t\t\t\t\t\t\t\t'".$formData['fprop'][$k]."Options' => Core_".$formData['fmodule']."::get".ucfirst($formData['fprop'][$k])."List(),";
			}
		}
		$s['{{CONSTANT_CONTROLLER_ASSIGN}}'] = $tmp;
		//end---


		//{{{{ADD_ASSIGN_PROPERTY}}}}
		$tmp = '';
		if(!is_array($formData['fexclude']))
			$formData['fexclude'] = array();
		foreach($formData['fprop'] as $k => $v)
		{
			if(!isset($formData['fexclude'][$k]) && $k != $formData['primaryfield'])
			{
				$tmp .= "\n\t\t\t\t\t\$my".$formData['fmodule']."->".$v." = \$formData['f".$v."'];";
			}
		}
		$s['{{ADD_ASSIGN_PROPERTY}}'] = $tmp;
		//end---
		
		//{{EDIT_FORMDATA_INIT}}
		$tmp = '';
		foreach($formData['fprop'] as $k => $v)
		{
			$tmp .= "\n\t\t\t\$formData['f".$v."'] = \$my".$formData['fmodule']."->".$v.";";
		}
		$s['{{EDIT_FORMDATA_INIT}}'] = $tmp;
		//end--
		
		//{{{{EDIT_ASSIGN_PROPERTY}}}}
		$tmp = '';
		if(!is_array($formData['fexclude']))
			$formData['fexclude'] = array();
		foreach($formData['fprop'] as $k => $v)
		{
			if(!isset($formData['fexclude'][$k]) && $k != $formData['primaryfield'])
			{
				$tmp .= "\n\t\t\t\t\t\t\$my".$formData['fmodule']."->".$v." = \$formData['f".$v."'];";
			}
		}
		$s['{{EDIT_ASSIGN_PROPERTY}}'] = $tmp;
		//end---
		
		//{{ADD_VALIDATOR}}
		//{{EDIT_VALIDATOR}}
		$tmp = '';
		foreach($formData['fvalidating'] as $k => $v)
		{
			if($v == 'notempty')
			{
				$tmp .= "\n\n\t\tif(\$formData['f".$formData['fprop'][$k]."'] == '')\n\t\t{\n\t\t\t\$error[] = \$this->registry->lang['controller']['err".ucfirst($formData['fprop'][$k])."Required'];\n\t\t\t\$pass = false;\n\t\t}";
			}
			elseif($v == 'greaterthanzero')
			{
				$tmp .= "\n\n\t\tif(\$formData['f".$formData['fprop'][$k]."'] <= 0)\n\t\t{\n\t\t\t\$error[] = \$this->registry->lang['controller']['err".ucfirst($formData['fprop'][$k])."MustGreaterThanZero'];\n\t\t\t\$pass = false;\n\t\t}";
			}
			elseif($v == 'email')
			{
				$tmp .= "\n\n\t\tif(Helper::ValidatedEmail(\$formData['f".$formData['fprop'][$k]."']))\n\t\t{\n\t\t\t\$error[] = \$this->registry->lang['controller']['err".ucfirst($formData['fprop'][$k])."InvalidEmail'];\n\t\t\t\$pass = false;\n\t\t}";
			}
		}
		$s['{{ADD_VALIDATOR}}'] = $s['{{EDIT_VALIDATOR}}'] = $tmp;
		//end--
		
		############################################
		############################################
		##	LANGUAGE_ADMIN.TPL
		############################################
		############################################
		//{{FORM_FIELD_LABEL}}
		$tmp = '';
		foreach($formData['flabel'] as $k => $v)
		{
			$tmp .= "\n\t" . '<lines name="label'.ucfirst($formData['fprop'][$k]).'" descr=""><![CDATA['.$v.']]></lines>';
		}
		//searchable
		if(count($formData['fsearchabletext']) > 0)
		{
			$tmp .= "\n\t" . '<lines name="formKeywordLabel" descr=""><![CDATA[Keyword]]></lines>';
			$tmp .= "\n\t" . '<lines name="formKeywordInLabel" descr=""><![CDATA[- Search keyword in -]]></lines>';
		}
		
		$s['{{FORM_FIELD_LABEL}}'] = $tmp;
		//end---
		
		//{{FORM_FIELD_VALIDATING}}
		$tmp = '';
		foreach ($formData['fvalidating'] as $k => $v) 
		{
			if($v == 'notempty')
			{
				$tmp .= "\n\t" . '<lines name="err'.ucfirst($formData['fprop'][$k]).'Required" descr=""><![CDATA['.$formData['flabel'][$k].' is required.]]></lines>';
			}
			elseif($v == 'greaterthanzero')
			{
				$tmp .= "\n\t" . '<lines name="err'.ucfirst($formData['fprop'][$k]).'MustGreaterThanZero" descr=""><![CDATA['.$formData['flabel'][$k].' must be greater than zero.]]></lines>';
			}
			elseif($v == 'email')
			{
				$tmp .= "\n\t" . '<lines name="err'.ucfirst($formData['fprop'][$k]).'InvalidEmail" descr=""><![CDATA['.$formData['flabel'][$k].' is not valid format.]]></lines>';
			}
		}
		$s['{{FORM_FIELD_VALIDATING}}'] = $tmp;
		//END---
		
		
		############################################
		############################################
		##	CONTROLLER_ADMIN_INDEX.TPL
		############################################
		############################################
		//{{FIELD_TABLE_HEAD}}, {FIELD_TABLE_DATA}}
		$fieldHead = '';
		$fieldData = '';
		foreach($formData['flabel'] as $k => $v)
		{
			$prop = $formData['fprop'][$k];
			
			if($k != $formData['primaryfield'])
			{	
				
				
				//check if filter
				if(isset($formData['fsortable'][$k]))
				{
					$headlabel = '<a href="{$filterUrl}sortby/'.$formData['fprop'][$k].'/sorttype/{if $formData.sortby eq \''.$formData['fprop'][$k].'\'}{if $formData.sorttype|upper neq \'DESC\'}DESC{else}ASC{/if}{/if}">{$lang.controller.label'.ucfirst($prop).'}</a>';
				}
				else
				{
					$headlabel = '{$lang.controller.label'.ucfirst($prop).'}';
				}
				
				$fieldHead .= "\n\t\t\t\t\t\t\t<th>".$headlabel."</th>";
				
				//check addon for int(10) ~ timestamp
				if($formData['ftype'][$k] == "int(10)")
					$modifier = "|date_format";
				else
					$modifier = "";
				
				//check "enable" property
				if($formData['fprop'][$k] == 'enable')
				{
					$fieldData .= "\n\t\t\t\t\t\t\t<td>{if \$".$formData['MODULE_LOWER']."->enable == 1}<span class=\"label label-success\">{\$lang.default.formYesLabel}</span>{else}<span class=\"label label-important\">{\$lang.default.formNoLabel}</span>{/if}</td>";
				}
				elseif(isset($constantData[$k]))
				{
					$fieldData .= "\n\t\t\t\t\t\t\t<td>{\$".$formData['MODULE_LOWER']."->get".ucfirst($formData['fprop'][$k])."Name()}</td>";
				}
				else
					$fieldData .= "\n\t\t\t\t\t\t\t<td>{\$".$formData['MODULE_LOWER']."->".$formData['fprop'][$k].$modifier."}</td>";
			}
			else
			{
				$primaryHeadLanguage = '{$lang.controller.label'.ucfirst($prop).'}';
			}
		}
		$s['{{FIELD_TABLE_HEAD}}'] = $fieldHead;
		$s['{{FIELD_TABLE_HEAD_PRIMARY}}'] = $primaryHeadLanguage;
		$s['{{FIELD_TABLE_DATA}}'] = $fieldData;
		//end---
		
		//{{FILTERABLE_CONTROLGROUP}}
		//{{FILTERABLE_JS}}
		$tmpControl = '';
		$tmpJs = '';
		foreach ($formData['ffilterable'] as $k => $v) 
		{
			$prop = $formData['fprop'][$k];

			//If constant field, must be select box
			if(isset($constantData[$k]))
			{
				$tmpControl .= '{$lang.controller.label'.ucfirst($prop).'}: 
					<select name="f'.$prop.'" id="f'.$prop.'">
						<option value="0">- - - - -</option>
						{html_options options=$'.$prop.'Options selected=$formData.f'.$prop.'}
					</select>' . "\n\n\t\t\t\t";
			}
			else
				$tmpControl .= '{$lang.controller.label'.ucfirst($prop).'}: <input type="text" name="f'.$prop.'" id="f'.$prop.'" value="{$formData.f'.$prop.'|@htmlspecialchars}" class="input-mini" /> - ' . "\n\n\t\t\t\t";
			
			//JS condition string
			$defaultValue = $this->getDefaultValueFromColumnType($formData['ftype'][$k]);
			if($defaultValue === 0)
				$condition = 'parseInt('.$prop.') > 0';
			else
				$condition = $prop . '.length > 0';
			
			//Append output
			$tmpJs .= "\n\n\t\tvar ".$prop." = \$('#f".$prop."').val();\n\t\tif(".$condition.")\n\t\t{\n\t\t\tpath += '/".$prop."/' + ".$prop.";\n\t\t}";
		}
		$s['{{FILTERABLE_CONTROLGROUP}}'] = $tmpControl;
		$s['{{FILTERABLE_JS}}'] = $tmpJs;
		//end---
		
		//{{SEARCHABLETEXT_CONTROLGROUP}}
		//{{SEARCHABLETEXT_JS}}
		$tmpControl = '';
		$tmpJs = '';
		if(count($formData['fsearchabletext']) > 0)
		{
			$keywordinoption = '';
			foreach($formData['fsearchabletext'] as $k => $v)
			{
				$prop = $formData['fprop'][$k];
				$keywordinoption .= "\n\t\t\t\t\t" . '<option value="'.$prop.'" {if $formData.fsearchin eq "'.$prop.'"}selected="selected"{/if}>{$lang.controller.label'.ucfirst($prop).'}</option>';
			}
			
			$tmpControl = '{$lang.controller.formKeywordLabel}:'."\n\t\t\t\t".
							'<input type="text" name="fkeyword" id="fkeyword" size="20" value="{$formData.fkeyword|@htmlspecialchars}" class="" />' . "\n\t\t\t\t" . 
							'<select name="fsearchin" id="fsearchin">' . "\n\t\t\t\t\t" . 
								'<option value="">{$lang.controller.formKeywordInLabel}</option>' . $keywordinoption . 
							'</select>';
							
			$tmpJs = "\n\t\t" . 'var keyword = $("#fkeyword").val();' . "\n\t\t" . 
						'if(keyword.length > 0)' . "\n\t\t" . 
						'{' . "\n\t\t\t" . 
							'path += "/keyword/" + keyword;' . "\n\t\t" . 
						'}' . "\n\n\t\t" . 

						'var keywordin = $("#fsearchin").val();' . "\n\t\t" . 
						'if(keywordin.length > 0)' . "\n\t\t" . 
						'{' . "\n\t\t\t" . 
							'path += "/searchin/" + keywordin;' . "\n\t\t" . 
						'}';
		}
		$s['{{SEARCHABLETEXT_CONTROLGROUP}}'] = $tmpControl;
		$s['{{SEARCHABLETEXT_JS}}'] = $tmpJs;
		//end---
		
		############################################
		############################################
		##	CONTROLLER_ADMIN_ADD.TPL
		##	CONTROLLER_ADMIN_EDIT.TPL
		############################################
		############################################
		//{{FORM_ADD_CONTROLGROUP}}, {{FORM_EDIT_CONTROLGROUP}}
		$tmp = '';
		foreach ($formData['fprop'] as $k => $v) 
		{
			if(!isset($formData['fexclude'][$k]) && $k != $formData['primaryfield'])
			{
				if(isset($formData['fvalidating'][$k]) && $formData['fvalidating'][$k] != 'notneed')
					$requireString = ' <span class="star_require">*</span>';
				else
					$requireString = '';
					
				//detect correct input
				if($v == 'enable')
				{
					$inputstring = '<select class="input-mini" name="fenable" id="fenable"><option value="1">{$lang.default.formYesLabel}</option><option value="0" {if $formData.fenable == \'0\'}selected="selected"{/if}>{$lang.default.formNoLabel}</option></select>';
				}
				elseif(isset($constantData[$k]))
				{
					//constant must used in Select box
					$inputstring = '<select class="" name="f' . $v . '" id="f'.$v.'">{html_options options=$'.$v.'Options selected=$formData.f'.$v.'}</select>';
				}
				elseif($this->getDefaultValueFromColumnType($formData['ftypeshort'][$k]) === 0)
				{
					$inputstring = '<input type="text" name="f'.$v.'" id="f'.$v.'" value="{$formData.f'.$v.'|@htmlspecialchars}" class="input-mini">';
				}
				else
				{
					if($formData['ftype'][$k] == 'text')
					{
						$inputstring = '<textarea name="f'.$v.'" id="f'.$v.'" rows="7" class="input-xxlarge">{$formData.f'.$v.'}</textarea>';
					}
					else
					{
						$inputstring = '<input type="text" name="f'.$v.'" id="f'.$v.'" value="{$formData.f'.$v.'|@htmlspecialchars}" class="input-xlarge">';
					}
				}
				
				$tmp .= "\n\n\t".'<div class="control-group">'."\n\t\t".'<label class="control-label" for="f'.$v.'">{$lang.controller.label'.ucfirst($formData['fprop'][$k]).'}'.$requireString.'</label>'."\n\t\t".'<div class="controls">'.$inputstring.'</div>'."\n\t".'</div>';
			}
		}
		$s['{{FORM_ADD_CONTROLGROUP}}'] = $s['{{FORM_EDIT_CONTROLGROUP}}'] = $tmp;
		//end---
		
		return array('search' => array_keys($s), 'replace' => array_values($s));
	}
	
	private function getDefaultValueFromColumnType($typeshort)
	{
		$defaultValue = "''";

		if($typeshort == 'int' || $typeshort == 'float' || $typeshort == 'double' || $typeshort == 'decimal' || $typeshort == 'real')
		{
			$defaultValue = 0;
		}
		
		return $defaultValue;
	}
	
	/**
	 * Only support 3 type, Int, float, string
	 */
	private function getColumnTypeShort($type)
	{
		$type = strtolower($type);
		
		if(stripos($type, 'int') !== false)
			$typeshort = 'int';
		elseif(in_array($type, array('decimal', 'float', 'double', 'real')))
			$typeshort = 'float';
		else
			$typeshort = 'string';
			
		return $typeshort;
	}
	
}


