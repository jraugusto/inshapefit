<?php
namespace MatthiasWeb\RealMediaLibrary\api;

/**
 * This interface provides elementary methods for folder objects. All folder
 * types (Folder, Collection, Gallery, ...) have implemented this interface.
 * Also the root ("Unorganized") is a folder and implements this interface. Usually,
 * the root acts as "-1" but you should use the {@link _wp_rml_root} function to get the
 * root id.
 * 
 * If this interface does not provide an expected method, yet, have a look at the
 * other API files. For example to create a folder use {@link wp_rml_create}.
 * 
 * <strong>Check if a variable is surely a IFolder interface object:</strong>
 * <code>$folder = wp_rml_get_object_by_id(5);
 * if (is_rml_folder($folder)) {
 *      // It is an interface implementation of IFolder
 * }</code>
 * 
 * @see wp_rml_root_childs
 * @see wp_rml_get_object_by_id
 * @see wp_rml_get_by_id
 * @see wp_rml_get_by_absolute_path
 * @see wp_rml_objects
 * @see is_rml_folder
 */
interface IFolder {
    /**
     * Fetch all attachment ids currently in this folder. It uses the
     * default WP_Query to fetch the ids. You can also use the WP_Query like: <code>$query = new \WP_Query(array(
     *  	'post_status' => 'inherit',
     *  	'post_type' => 'attachment',
     *  	'rml_folder' => 4
     * ));</code>
     * 
     * @param string $order The order "ASC" or "DESC"
     * @param string $orderby Use "rml" to get ids ordered by custom order
     * @returns int[] Post ids
     */
    public function read($order = null, $orderby = null);
    
    /**
     * Checks if this folder has a children with a given name.
     *  
     * @param string $slug Slug or Name of folder
     * @param boolean $isSlug Set it to false if $slug is not slugged
     * @param boolean $returnObject If set to true and a children with this name is found, then return the object for this folder
     * @returns boolean
     */
    public function hasChildren($slug, $isSlug = true, $returnObject = false);
    
    /**
     * Return the type for the given folder. For example: 0 = Folder, 1 = Collection, 2 = Gallery
     * 
     * @returns int
     */
    public function getType();
    
    /**
     * Get all allowed children folder types.
     * 
     * @return boolean|int[] Array with allowed types or TRUE for all types allowed
     */
    public function getAllowedChildrenTypes();
    
    /**
     * Get the folder id.
     * 
     * @returns int
     */
    public function getId();
    
    /**
     * Get the parent folder id.
     * 
     * @returns int
     */
    public function getParent();
    
    /**
     * Get the folder name.
     * 
     * @returns string
     */
    public function getName();
    
    /**
     * Returns a santitized title for the folder. If the slug is empty
     * or forced to, it will be updated in the database, too.
     * 
     * @param boolean $force Forces to regenerate the slug
     * @returns string
     */
    public function getSlug($force = false);
    
    /**
     * Creates a absolute path without slugging' the names.
     * 
     * @param string $implode Delimitter for the folder names
     * @returns string
     */
    public function getPath($implode = "/");
    
    /**
     * Creates a absolute path. If the absolute path is empty
     * or forced to, it will be updated in the database, too.
     * 
     * @param boolean $force Forces to regenerate the absolute path
     * @returns string
     */
    public function getAbsolutePath($force = false);
    
    /**
     * Gets the count of the files in this folder.
     * 
     * @param boolean $forceReload If true the count cache gets reloaded
     * @returns int
     */
    public function getCnt($forceReload = false);
    
    /**
     * Get children of this folder.
     * 
     * @return IFolder[]
     */
    public function getChildren();
    
    /**
     * Get the order number.
     * 
     * @returns int
     */
    public function getOrder();
    
    /**
     * Get the restrictions of this folder.
     * 
     * @returns string[]
     */
    public function getRestrictions();
	
	/**
	 * Get the count of the restrictions.
	 * 
	 * @returns int
	 */
    public function getRestrictionsCount();
    
    /**
     * Returns childrens of this folder.
     * 
     * @deprecated Use {@link IFolder::getChildren()}!
     */
    public function getChildrens();
    
    /**
     * Gets a plain array with folder properties.
     * 
     * @returns array
     */
    public function getPlain();
    
    /**
     * Set restrictions for this folder. Allowed restrictions for folders:
     * 
     * <ul>
     *  <li><strong>par</strong> Restrict to change the parent id</li>
     *  <li><strong>rea</strong> Restrict to rearrange the hierarchical levels of all subfolders (it is downwards all subfolders!) and can not be inherited</li>
     *  <li><strong>cre</strong> Restrict to create new subfolders</li>
     *  <li><strong>ins</strong> Restrict to insert/upload new attachments, automatically moved to root if upload</li>
     *  <li><strong>ren</strong> Restrict to rename the folder</li>
     *  <li><strong>del</strong> Restrict to delete the folder</li>
     *  <li><strong>mov</strong> Restrict to move files outside the folder</li>
     * </ul>
     * 
     * You can append a ">" after each permission so it is inherited in each created subfolder: "cre>", "ins>", ...
     * 
     * @param string[] $restrictions Array with restrictions
     * @returns boolean
     */
    public function setRestrictions($restrictions = array());
    
    /**
     * Check if the folder object is a given type.
     * 
     * @param int $folder_type The folder type
     * @returns boolean
     */
    public function is($folder_type);
    
    /**
     * Checks if this folder has a special restriction.
     * 
     * @param string $restriction The restriction to check
     * @returns boolean
     * @see IFolder::setRestrictions()
     */
    public function isRestrictFor($restriction);
    
    /**
     * Checks if a given folder type is allowed in this folder.
     * 
     * @param int $type The type
     * @returns boolean
     * @see IFolder::getAllowedChildrenTypes()
     */
    public function isValidChildrenType($type);
}
?>