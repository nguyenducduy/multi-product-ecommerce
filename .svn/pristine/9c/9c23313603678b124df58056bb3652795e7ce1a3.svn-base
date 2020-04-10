<?php
	Class EpubParser
	{
		const ERROR_OK = 1;
		const ERROR_UNZIP = 2;
		const ERROR_MIMETYPE = 3;
		const ERROR_EPUB_NOTVALID = 4;
		const ERROR_UNKNOWN = 10;
		
		//path of EPUB file to parsing
		public $filepath = '';
		
		//directory to store all resource extracted from EPUB file
		public $tempExtractDirectory = '';	//must be end with slash
		
		public $ebookData = null;
		
		public function __construct($filepath, $tempExtractDirectory)
		{
			$this->filepath = $filepath;
			$this->tempExtractDirectory = $tempExtractDirectory;
			
			if(substr($this->tempExtractDirectory, -1) != '/' || substr($this->tempExtractDirectory, -1) != '\\')
				$this->tempExtractDirectory .= '/';
			
			$this->ebookData = new epubData();
		}
		
		/**
		* Because EPUB is just a zipped html, css, ...
		* 
		* So, first, we need to extract all the resource
		* 
		*/
		public function extractArchive()
		{
			if(!file_exists($this->tempExtractDirectory))
			{
				mkdir($this->tempExtractDirectory, 0777, true);
			}
			
			
			if(file_exists($this->tempExtractDirectory) && is_dir($this->tempExtractDirectory))
			{
				//unzip file
				$zip = new ZipArchive();
				$res = $zip->open($this->filepath);
				if($res === TRUE)
				{
					$zip->extractTo($this->tempExtractDirectory);
					$zip->close();
					
					return true;
				}
				return false;
			}
			else
				return false;
		}
		
		public function processEpub()
		{
			if(!$this->extractArchive())
				return self::ERROR_UNZIP;
			
			/////////////////////////////////
			//check mimetype
			$mimetypeContents = file_get_contents($this->tempExtractDirectory . 'mimetype');
			if(!preg_match('(application\/epub\+zip)', $mimetypeContents))
			{
				//trigger_error("This eBook is not of mimetype application/epub+zip", E_USER_WARNING);
				return self::ERROR_MIMETYPE;
            	
			}
				
            /////////////////////////////////
            //read container.xml
            $containerPath = $this->tempExtractDirectory . 'META-INF' . DIRECTORY_SEPARATOR . 'container.xml';
            if(!file_exists($containerPath))
            {
            	trigger_error("EPUB file is not valid. Container.xml is not found.", E_USER_ERROR);
            	return self::ERROR_EPUB_NOTVALID;
            	
			}else
				$containerContents = file_get_contents($containerPath);
			
			//parsing container.xml
			$xml = simplexml_load_string($containerContents);
        
            //Process the container.xml file and set the path to the opf file.
            $this->ebookData->opfPath = (string)$xml->rootfiles->rootfile->attributes()->{'full-path'};
            
            
			
            $this->loadReqOPF();
            $this->loadOptionalOPF();
           
            //Find and load other important files.
			$this->ebookData->toc = $this->fildFileByExt($this->tempExtractDirectory . $this->ebookData->contentFolder, "ncx");
			$this->ebookData->xpgt = $this->fildFileByExt($this->tempExtractDirectory . $this->ebookData->contentFolder, "xpgt");
			$this->ebookData->css = $this->fildFileByExt($this->tempExtractDirectory . $this->ebookData->contentFolder, "css");
			
            $this->loadTOC();
            $this->removeSimpleXML();
            
            //everything ok
            return self::ERROR_OK;
            
            /*echo '<pre>';
            print_r($this->ebookData->spineData);
            print_r($this->ebookData->manifestData);
            print_r($this->ebookData->tocData);*/
		}
		
		/**
		 * Gives you the path of the file(s) with the extenshion you are looking for. **Recursive Function**
		 * @param $input the directory to search.
		 * @param string $ext The extenshion you will be looking for.
		 * @return string Will return a string of a single file location if only one file with that extenshion exists,
		 * or an array of file locations if more then one exists, or null if none exist.
		 **/
		private function fildFileByExt($input, $ext){
			$results = null;
			if($ext == 'ncx')
			{
				$results = glob($input . "*.".$ext);
				$results = $results[0];
			}
			elseif(is_dir($input)){
				//**Recursive Function part**
				$results = glob($input."*.".$ext);
				foreach(scandir($input) as $item){
					if($item != "." && $item != ".." && is_dir($input.$item)){
						$results = array_merge($results, $this->fildFileByExt($input.$item.DIRECTORY_SEPARATOR, $ext));
					}
				}
			}
			
				
			return $results;
		}
		
		private function loadReqOPF()
		{
			//Read the opf file information
            $contents = file_get_contents($this->tempExtractDirectory . $this->ebookData->opfPath);
            if(!isset($contents))
            	trigger_error("can't read the opf file", E_USER_ERROR);
            	
            //Format the file for our use.
            $ourFileName = $this->formatXML($contents);
            //Load our XML
            $xml = simplexml_load_string($ourFileName);
            
            //Load the metadata
            $this->ebookData->metadata = $this->getTag($xml, 'metadata');
            if(!isset($this->ebookData->metadata))
            	trigger_error("can't read the metadata from the opf file", E_USER_ERROR);
            	
            $this->ebookData->title = $this->getTag($this->ebookData->metadata, 'dctitle');
            if(!isset($this->ebookData->title))
            	trigger_error("can't find the dublin core title data inside the opf file", E_USER_ERROR);
            	
            $this->ebookData->language = $this->getTag($this->ebookData->metadata, 'dclanguage');
            if(!isset($this->ebookData->language))
            	trigger_error("can't find the dublin core language data inside the opf file", E_USER_ERROR);
                    
            $this->ebookData->identifier = $this->getTag($this->ebookData->metadata, "dcidentifier");
            $this->ebookData->identifierId = (string)$this->optAttributeExist($this->ebookData->identifier, "id");
            if(!isset($this->ebookData->identifier))
            	trigger_error("can't find the dublin core identifier data inside the opf file", E_USER_ERROR);
            	
            //Load the manifest
            $this->ebookData->manifest = $this->getTag($xml, 'manifest');
            if(!isset($this->ebookData->manifest))
            	trigger_error("can't find the manifest inside the opf file", E_USER_ERROR);
            $this->loadManifest();
            //Finds where the content is, based on the manifest
            $this->findContentLoc();

            //Load the spine. TODO: make it work with linear = "no"
            $this->ebookData->spine = $this->getTag($xml, 'spine');
            if(!isset($this->ebookData->spine))
            	trigger_error("can't find the spine inside the opf file", E_USER_ERROR);
            $this->ebookData->spineData = $this->xmlFindData($this->ebookData->spine, 'itemref');
            $this->ebookData->spineData = $this->optAttributeExist($this->ebookData->spineData, 'idref');
            
		}
		
		/**
		 * Loads all the optional tags and attributes epub data into variables
		 **/
		private function loadOptionalOPF(){
			//Read the opf file information
            $contents = file_get_contents($this->tempExtractDirectory . $this->ebookData->opfPath);
            if(!isset($contents))
            	trigger_error("can't read the opf file", E_USER_ERROR);
            	
            //Format the file for our use.
            $ourFileName = $this->formatXML($contents);
            //Load our XML
            $xml = simplexml_load_string($ourFileName);
	
			//Load the guide if it exists
			$this->ebookData->guide = $this->getTag($xml, 'guide');
			if(isset($this->ebookData->guide))
				$this->loadGuide();
	
			//Load the spine's pointer to the TOC file in the manifest, if it exists.
			$tempSpine = $this->getTag($this->ebookData->spine, 'spine');
			$this->ebookData->spineToc = (string)$this->optAttributeExist($tempSpine, "toc");
	
			//Optional tags
			$this->ebookData->creator = $this->getTag($this->ebookData->metadata, 'dccreator');
			$this->ebookData->contributor = $this->getTag($this->ebookData->metadata, 'dccontributor');
			$this->ebookData->publisher = $this->getTag($this->ebookData->metadata, 'dcpublisher');
			$subject = $this->getTag($this->ebookData->metadata, 'dcsubject');
			$this->ebookData->subject = $this->getTag($this->ebookData->metadata, 'dcsubject');
			$this->ebookData->description = $this->getTag($this->ebookData->metadata, 'dcdescription');
			$this->ebookData->eBookDate = $this->getTag($this->ebookData->metadata, 'dcdate');
			$this->ebookData->type = $this->getTag($this->ebookData->metadata, 'dctype');
			$this->ebookData->format = $this->getTag($this->ebookData->metadata, 'dcformat');
			$this->ebookData->source = $this->getTag($this->ebookData->metadata, 'dcsource');
			$this->ebookData->relation = $this->getTag($this->ebookData->metadata, 'dcrelation');
			$this->ebookData->coverage = $this->getTag($this->ebookData->metadata, 'dccoverage');
			$this->ebookData->rights = $this->getTag($this->ebookData->metadata, 'dcrights');
			$this->ebookData->meta = $this->getTag($this->ebookData->metadata, 'meta');
	
			//Optional tag attributes
//			$this->ebookData->tocManifestId = $this->ebookData->spineToc;
			$this->ebookData->titleXmlLang = (string)$this->optAttributeExist($this->ebookData->title, "xmllang");
			$this->ebookData->languageXsiType = (string)$this->optAttributeExist($this->ebookData->language, "xsitype");
			$this->ebookData->identifierScheme = (string)$this->optAttributeExist($this->ebookData->identifier, "opfscheme");
			$this->ebookData->identifierXsiType = (string)$this->optAttributeExist($this->ebookData->identifier, "xsitype");
			$this->ebookData->creatorRole = (string)$this->optAttributeExist($this->ebookData->creator, "opfrole");
			$this->ebookData->creatorXmlLang = (string)$this->optAttributeExist($this->ebookData->creator, "xmllang");
			$this->ebookData->creatorOpfFileAs = (string)$this->optAttributeExist($this->ebookData->creator, "opffile-as");
			$this->ebookData->contributorRole = (string)$this->optAttributeExist($this->ebookData->contributor, "opfrole");
			$this->ebookData->contributorXmlLang = (string)$this->optAttributeExist($this->ebookData->contributor, "xmllang");
			$this->ebookData->contributorOpfFileAs = (string)$this->optAttributeExist($this->ebookData->contributor, "opffile-as");
			$this->ebookData->publisherXmlLang = (string)$this->optAttributeExist($this->ebookData->publisher, "xmllang");
			$this->ebookData->subjectXmlLang = (string)$this->optAttributeExist($this->ebookData->subject, "xmllang");
			$this->ebookData->descriptionXmlLang = (string)$this->optAttributeExist($this->ebookData->description, "xmllang");
			$this->ebookData->eBookdateEvent = (string)$this->optAttributeExist($this->ebookData->eBookDate, "opfevent");
			$this->ebookData->eBookdateXsiType = (string)$this->optAttributeExist($this->ebookData->eBookDate, "xsitype");
			$this->ebookData->typeXsiType = (string)$this->optAttributeExist($this->ebookData->type, "xsitype");
			$this->ebookData->formatXsiType = (string)$this->optAttributeExist($this->ebookData->format, "xsitype");
			$this->ebookData->sourceXmlLang = (string)$this->optAttributeExist($this->ebookData->source, "xmllang");
			$this->ebookData->relationXmlLang = (string)$this->optAttributeExist($this->ebookData->relation, "xmllang");
			$this->ebookData->coverageXmlLang = (string)$this->optAttributeExist($this->ebookData->coverage, "xmllang");
			$this->ebookData->rightsXmlLang = (string)$this->optAttributeExist($this->ebookData->rights, "xmllang");
		}
		
		/**
		 * Loads all the manifest data into the manifestData array
		 * attributes of this can be accessed in the maner of
		 * $this->ebookData->manifestData[x]->id; for the id attribute.
		 * $this->ebookData->manifestData[x]->href; for the href attribute.
		 * $this->ebookData->manifestData[x]->type; for the media type attribute.
		 * 
		 * TODO: fix length calculation for some books (E.g.: The Raven)
		 * 
		 **/
		private function loadManifest(){
			$this->ebookData->manifestData = array();
			foreach($this->ebookData->manifest->children() as $child){
				$manifestItem = new manifest();
				$manifestItem->id = (string)$child->attributes()->id;
				$manifestItem->href = (string)$child->attributes()->href;
				$manifestItem->type = (string)$child->attributes()->{'media-type'};
				$manifestItem->fallback = (string)$child->attributes()->fallback;
				
				//length
				//TODO: tim hieu cai nay la cai gi
				//$manifestItem->length = strlen(strip_tags($this->readEpubFile($this->ebookData->epub, dirname($this->ebookData->opfPath).'/'.$manifestItem->href)));
				
				array_push($this->ebookData->manifestData, $manifestItem);
				
				
			}
		}
		
		/**
		 * Loads all the guide data into the guideData array
		 * attributes of this can be accessed in the maner of
		 * $this->ebookData->guideData[x]->title; for the id attribute.
		 * $this->ebookData->guideData[x]->href; for the href attribute.
		 * $this->ebookData->guideData[x]->type; for the media type attribute.
		 **/
		private function loadGuide(){
			$this->ebookData->guideData = array();
			foreach($this->ebookData->guide->children() as $child){
				$guideItem = new guide();
				$guideItem->title = (string)$child->attributes()->title;
				$guideItem->href = (string)$child->attributes()->href;
				$guideItem->type = (string)$child->attributes()->type;
				array_push($this->ebookData->guideData, $guideItem);
			}
		}
		
		/**
		 * SimpleXML has problems with being serialized and this limits how this class can be used,
		 * so when we are done reading the data from it, we will erace all instances of the simpleXML
		 * objects from the ebookData object.
		 */
		private function removeSimpleXML(){
			$this->ebookData->metadata = null;
			$this->ebookData->manifest = null;
			$this->ebookData->spine = null;
			$this->ebookData->guide = null;
			//Convert all simpleXML to strings.
			$this->ebookData->title = (string)$this->ebookData->title;
			$this->ebookData->language = (string)$this->ebookData->language;
			$this->ebookData->identifier = (string)$this->ebookData->identifier;
			$this->ebookData->creator = (string)$this->ebookData->creator;
			$this->ebookData->contributor = (string)$this->ebookData->contributor;
			$this->ebookData->publisher = (string)$this->ebookData->publisher;
			$this->ebookData->subject = (!is_array($this->ebookData->subject)) ? (string)$this->ebookData->subject : implode(' / ', $this->ebookData->subject);
			$this->ebookData->description = (string)$this->ebookData->description;
			
			//date
			if (!is_array($this->ebookData->eBookDate))
			{
				$this->ebookData->eBookDate = (string)$this->ebookData->eBookDate;
			}
			else 
			{
				$dateTypes = (array)$this->optAttributeExist($this->ebookData->eBookDate, "opfevent");
				foreach ($dateTypes as $typeKey => $dateType)
				{
					if ((string)$dateType == 'publication') $publicationDateIndex = $typeKey;
					break;
				}
				$tempDate = (array)$this->ebookData->eBookDate[$publicationDateIndex];
				$this->ebookData->eBookDate = (isset($publicationDateIndex)) ? $tempDate[0] : '';
//				Debugger::VarDump($this->ebookData->eBookDate);
			}
			
			$this->ebookData->type = (string)$this->ebookData->type;
			$this->ebookData->format = (string)$this->ebookData->format;
			$this->ebookData->source = (string)$this->ebookData->source;
			$this->ebookData->relation = (string)$this->ebookData->relation;
			$this->ebookData->coverage = (string)$this->ebookData->coverage;
			$this->ebookData->rights = (string)$this->ebookData->rights;
			$this->ebookData->tocManifestId = (string)$this->ebookData->tocManifestId;
			
			//meta parsing
			if (count($this->ebookData->meta) > 1)
			{
				$meta = $this->ebookData->meta;
			}
			else if (is_object($this->ebookData->meta))
			{
				$meta[0] = $this->ebookData->meta;
			}
			else 
			{
				$meta = null;
			}
			$this->ebookData->meta = array();
			
			if ($meta != null)
			{
				foreach ($meta as $metaKey => $metaItem)
				{
					foreach ($metaItem->attributes() as $key => $value)
					{
						$this->ebookData->meta[$metaKey][$key] = (string)$value;
					}
				}
			}
	
			for($x = 0;$x<count($this->ebookData->spineData);$x+=1){
				$this->ebookData->spineData[$x] = (string)$this->ebookData->spineData[$x];
			}
		}
		
		/**
		 *	Reads the .ncx file if there is one.
		 *  TODO: sort by play order
		 */
		private function loadTOC(){
			if(isset($this->ebookData->toc)){
				//Read the toc file information
				$contents = file_get_contents($this->ebookData->toc);
				$xml = simplexml_load_string($contents);
				$navPoint = $this->getTag($xml, "navPoint");
				$names = array();
				$href = array();
				$ids = array();
				$parent = array();
				
				//loop through all navPoints
				if (!empty($navPoint))
				{
					foreach($navPoint as $key => $nav)
					{
						//nav points
						$navPoints = $this->getTag($nav, "navPoint");
						
						//if 1-level point
						if (!is_array($navPoints))
						{
							//title
							$texts = $this->getTag($nav, "text");
							array_push($names, $texts);
							
							//source
							$contents = $this->getTag($nav, "content");
							array_push($href, $this->optAttributeExist($contents, "src"));
							
							//id
							$id = $this->optAttributeExist($nav, "id");
							array_push($ids, $id);
						}
						//if multi-level point
						else 
						{
							//title
							$texts = $this->getTag($nav, "text");
							array_push($names, $texts[0]);
							
							//source
							$contents = $this->getTag($nav, "content");
							array_push($href, $this->optAttributeExist($contents[0], "src"));
							
							//id
							$id = $this->optAttributeExist($nav[0], "id");
							array_push($ids, $id);
							
							//fills the TOC structure with child elements
							foreach ($navPoints as $navKey => $navItem)
							{
								if ($navKey == 0) continue;
								$tempId = (string)$this->optAttributeExist($nav[0], "id");
								$tempIdChild = (string)$this->optAttributeExist($navItem, "id");
								$children[$tempId][] = $tempIdChild;
							}
						}
						
						//adds parent reference
						$hasParent = false;
						if (!empty($children))
						{
							foreach ($children as $parentKey => $child)
							{
								if (in_array((string)$id, $child))
								{
									array_push($parent, $parentKey);
									$hasParent = true;
									break;
								}
							}
						}
						if (!$hasParent) array_push($parent, null);
					}
					
					//final arrangement
					$finToc = array();
					for($x=0; $x < count($names);$x+=1)
					{
						$ch = new tocItem();
						$ch->id = (string)$ids[$x];
						$ch->name = (string)$names[$x];
						$ch->fileName = (string)$href[$x];
						$ch->parent = (string)$parent[$x];
						array_push($finToc, $ch);
					}
					
					$this->ebookData->tocData = $finToc;
				}
				else 
				{
					foreach ($this->ebookData->spineData as $spineKey => $spine)
					{
						$tocItem = new tocItem();
						$tocItem->id = (string)$spine;
						$tocItem->name = $spineKey;
						$tocItem->parent = null;
						$tocItem->fileName = $this->getManifestById($spine)->href;
						$this->ebookData->tocData[$spineKey] = $tocItem;
					}
				}
			}
		}
		
		/**
		 * Sets the location of where the content of the epub is located.
		 * Can't find any documentation about content always being located with the opf file,
		 * but every epub I can find has it's content with the opf, and it's manifest points to
		 * content relative to the opf location. Setting the content path
		 * based on where the opf file is located.
		 */
		private function findContentLoc(){
			if(isset($this->ebookData->opfPath)){
				$this->ebookData->contentFolder = dirname($this->ebookData->opfPath)."/";
			}else{
				trigger_error("Can't set the contentFolder location because the opf path dosen't exist.", E_USER_ERROR);
			}
		 }
		
		/**
         * To standardize the tag structure. This removes all colons in the tags and makes all the tags lowercase
         * @param string $xmlString The XML file as a string
         * @return string that has been formatted.
         * 
         * Inherit from epub-reader at http://code.google.com/p/epub-reader/source/browse/trunk/app/includes/components/epub/ebookRead.php?r=20
         **/
        private function formatXML($xmlString){
                /**SimpleXML cant read XML tags that have colons in them so we are going to remove them here. I dont
                 * want to remove the colons from web locations. So I am just removing them from the dc tags **/
                $xmlString = str_replace("dc:", "dc", $xmlString);
                $xmlString = str_replace("xml:", "xml", $xmlString);
                $xmlString = str_replace("xsi:", "xsi", $xmlString);
                $xmlString = str_replace("opf:", "opf", $xmlString);
                //This turns all the tags to lower case. A Bug adds a \backslash before every "quote.
                $xmlString = preg_replace ('!(</?)(\w+)([^>]*?>)!e', "'\\1'.strtolower('\\2').'\\3'", $xmlString);
                //This removes all the added \ from the previous replace
                $xmlString = str_replace("\\\"", "\"", $xmlString);
                return $xmlString;
        }
        
        /**
		 * Tests if a optional attribute exists and then returns it. If an array of tags is sent in then it returns
		 * an array of the optional tags.
		 * @param SimpleXMLElement $tag The tag being checked for a particular attribute.
		 * @param string $attribute the attribute being searched for.
		 * @return SimpleXMLElement returns a attribute if given a single tag, else return an array of attributes if given an array of
		 * tags, else return null.
		 **/
		private function optAttributeExist($tag, $attribute){
			if(isset($tag)){
				if(is_array($tag)){
					$array = array();
					foreach($tag as $element){
						$data = $element->attributes()->$attribute;
						array_push($array, $data);
					}
					return $array;
				}
				return $tag->attributes()->$attribute;
			}else{
				return NULL;
			}
		}
		
		
        /**
		 * Find the specified data.
		 * @param SimpleXMLElement $input is the xml document.
		 * @param string $tag is the tag with the data being searched for.
		 * @return SimpleXMLElement If we only have one result from the xmlFindData function then we return
		 * it else we send back the whole array.
		 **/
		private function getTag(SimpleXMLElement $input, $tag){
			$data = $this->xmlFindData($input, $tag);
			if(count($data) < 1){
				return NULL;
			}else if(count($data) == 1){
				return $data[0];
			}else{
				return $data;
			}
		}
		
		/**
		 * Find the specified data. **Recursive Function**
		 * @param SimpleXMLElement $xmlInput is the xml document
		 * @param string $tag is the tag with the data being searched for
		 * @return SimpleXMLElement an array of the results.
		 **/
		private function xmlFindData(SimpleXMLElement $xmlInput, $tag){
			$array = array();
			//If we find a match, save it.
			if($xmlInput->getName() == $tag){
				array_push($array, $xmlInput);
			}
			//If there are no children then this don't run.
			foreach($xmlInput->children() as $child){
				$recurse = $this->xmlFindData($child, $tag);
				//Save each submatch.
				$array = array_merge($array, $recurse);
			}
			//Return all submatches to the next higher level.
			return $array;
		}
		
		/**
		* Use recursive to create toc tree base on linear toc array
		* 
		*/
		public function getTocTree()
		{
			return $this->getTocTreeHelper($this->ebookData->tocData, 0);
		}
		
		private function getTocTreeHelper($myTocArray, $parentId)
		{
			$result = array();
			foreach($myTocArray as $tocEntry)
			{
				if($tocEntry->parent == $parentId)
				{
					$newItem = array(
						'title' => $tocEntry->name,
						'src' => $tocEntry->fileName
					);
					
					//because in some case, the id can be empty ^^!, so, check id first
					if(strlen($tocEntry->id) > 0)
					{
						$children = $this->getTocTreeHelper($myTocArray, $tocEntry->id);
						if(count($children) > 0)
							$newItem['children'] = $children;
					}
					
						
					$result[] = $newItem;
				}
			}
			
			return $result;
		}
		
		
	}
	
	
	
	
	
		
	
	
	
	
	
