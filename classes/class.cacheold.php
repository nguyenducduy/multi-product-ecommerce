<?php
/**
 * ReallySimpleContentCache
 * As the name suggests, this is class is for really simple content caching
 *
 * Copyright 2007 Rob Searles
 * http://www.ibrow.com
 * Please give me credit if you use this. Thanks
 *
 * History:
 * I originally built this for caching XML which had been constructed
 * out of database calls. I had a Flash front end talking to PHP in the
 * backend, the PHP would then go and interrogate the database, construct
 * some more XML which it would return. There were many calls being made to
 * the database, so I decided to cache the final reply XML.
 *
 * It's not bullet proof, and doesn't have a great deal of functionality,
 * but it is a quick and dirty solution to a little scratch I had to itch
 * Play around with it, learn, improve and enjoy. I hope you find it useful
 *
 * copyright 2007 rob searles
 * Licenced under the GNU Lesser General Public License (Version 3)
 * http://www.gnu.org/licenses/lgpl.html
 */
/**
 * ReallySimpleContentCache
 * As the name suggests, this is class is for really simple content caching
 *
 * Usage:
 *
 * $Cache = new ReallySimpleContentCache('mycache.html');
 * $content = $Cache->get();
 * if(!$content) {
 * 		// get your content here
 * 		$content = ....;
 *  	$Cache->save($content);
 * }
 * echo $content;
 */
class cache{
	/**
	 * content to cache. For this I have been using an XML string
	 */
	private $content;
	/**
	 * ID of the cached file/file to cache. Essentially this is a filename
	 */
	private $id;
	/**
	 * The time limit for cached files to expire, specified in minutes
	 * default is 30 minutes;
	 */
	private $limit_in_minutes = 30;
	
	/**
	* The path to cach directory
	*/
	public $path_to_directory;

	/**
	 * The path to the actual cache file
	 */
	private $path_to_file;
	
	private $isCacheVariable;

	/**
	 * ReallySimpleContentCache::Constructor
	 * Initiate the class, if an ID has been passed, set the ID property
	 * @param string $id
	 * @access protected
	 */
	function __construct($id = false, $cacheDir = '', $limit_in_minutes = false, $isCacheVariable = false) {
		if($id) {
			$this->set_id($id);
		}
		
		if($limit_in_minutes)
		{
			$this->set_limit($limit_in_minutes);
		}
		
		if($cacheDir == '')
		{
			throw new Exception('Cache dir is invalid. Please set the directory'); 
		}
		else
		{
			$this->path_to_directory = $cacheDir;
		}
		
		$this->isCacheVariable = $isCacheVariable;
		
	}
	/**
	 * ReallySimpleContentCache::get_cache()
	 * Tries to get the cached version of the ripple specified
	 * If successfully gets the cache, returns the contents of the cached file
	 * as a string. If cache has expired, clears cache and returns false, if
	 * no cache file at all, returns false as well
	 * @return string|false
	 */
	public function get($id = false, $limit_in_minutes = false){
		global $registry;
		
		/**
		 * based on the ID of the cache, get the path to the cache
		 */
		$this->get_path_to_file($id);
 
		/**
		 * If no cache file, no cache, return false
		 */
		if(!file_exists($this->path_to_file)) {
			return false;
		}
		
		//force create new data
		if(isset($_GET['live']) || !$registry->setting['cache']['enable'])
		{
			return false;
		}

		   
		
		/**
		 * Check to see if this cache has expired, clear cache if it has
		 * and return false
		 */
		if(filemtime($this->path_to_file) < $this->get_expires($limit_in_minutes)) {
			$this->clear($id);
			return false;
		}
		
		
		/**
		 * This cache is valid and current, get and return its contents
		 */
		$this->content = file_get_contents($this->path_to_file);
		
		if($this->isCacheVariable)
		{
			$this->content = unserialize($this->content);
		}
		return $this->content;
	}
	/**
	 * ReallySimpleContentCache::save_cache()
	 * Tries to saved passed content to a cache file of the passed if
	 * @return true on success
	 */
	public function save($content = false, $id = false){
		/**
		 * based on the ID of the cache, get the path to the cache
		 */
		$this->get_path_to_file($id);
		/**
		 * Set the content of the cache
		 */
		$this->set_content($content);
		
		if($this->isCacheVariable)
		{
			$this->content = serialize($this->content);
		}
		
		/**
		 * Write the content to the cache file
		 */
		if(!file_put_contents($this->path_to_file, $this->content)) {
			throw new Exception('Could not write the content to the cache file');
		}
		return true;
	}
	/**
	 * ReallySimpleContentCache::clear_cache()
	 * Clears the cache - deletes the cache file
	 * @return boole true on success
	 */
	function clear($id = false){
		/**
		 * based on the ID of the cache, get the path to the cache
		 */
		$this->get_path_to_file($id);
		return @unlink($this->path_to_file);
	}
	/**
	 * ReallySimpleContentCache::set_content()
	 * Sets the content for this cache
	 * @param string $content
	 * @access protected
	 */
	public function set_content($content = false) {
		if(!$content) {
			throw new Exception('You have not specified any content for this cache');
		}
		$this->content = $content;
	}
	/**
	 * ReallySimpleContentCache::set_id()
	 * Sets the ID property for the cache class
	 * @param string $id
	 * @access protected
	 */
	public function set_id($id = false) {
		if(!$id) {
			throw new Exception('You have not specified an ID');
		}
		$this->id = $id;
	}
	/**
	 * ReallySimpleContentCache::set_limit()
	 * Sets the time limit (in hours) for this cache to expire
	 * @param int $limit_in_hours
	 * @access protected
	 */
	public function set_limit($limit_in_minutes = false) {
		if(!$limit_in_minutes) {
			throw new Exception('You have not specified any time limit for this cache');
		}
		$this->limit_in_minutes = $limit_in_minutes;
	}
	/**
	 * ReallySimpleContentCache::get_path_to_file()
	 * Gets the file path to the actual cache file
	 * @return string
	 */
	private function get_path_to_file($id = false) {
		if($id) { $this->set_id($id); }
		$this->path_to_file = $this->path_to_directory.DIRECTORY_SEPARATOR.$this->id;
		return $this->path_to_file;
	}
	/**
	 * ReallySimpleContentCache::get_expires()
	 * Gets the time that this cache expires. Well, not really. What this does
	 * is get the time the cache file should have been CREATED before it
	 * expires. If the cache file was created before the time, it is expired
	 * if created after the time, it is fine
	 * @param int
	 * @return timestamp
	 */
	private function get_expires($limit_in_minutes = false) {
		/**
		 * if a time limit has been passed, set the time limit of cache
		 */
		if($limit_in_minutes) {
			$this->set_limit($limit_in_minutes);
		}
		return time() - $this->limit_in_minutes * 60;
	}
}
