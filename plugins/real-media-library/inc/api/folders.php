<?php
use MatthiasWeb\RealMediaLibrary\attachment;
use MatthiasWeb\RealMediaLibrary\general;
use MatthiasWeb\RealMediaLibrary\metadata;
use MatthiasWeb\RealMediaLibrary\order;
use MatthiasWeb\RealMediaLibrary\folder;
use MatthiasWeb\RealMediaLibrary\api;

if (!function_exists('is_rml_folder')) {
    /**
     * Checks, if a given variable is an implementation of the
     * IFolder interface.
     * 
     * @param int|mixed $obj Object or int (ID)
     * @returns boolean
     */
    function is_rml_folder($obj) {
        return is_int($obj) ? is_rml_folder(wp_rml_get_object_by_id($obj)) : $obj instanceof api\IFolder;
    }
}

if (!function_exists('wp_rml_get_parent_id')) {
    /**
     * Get the parent ID of a given folder id.
     * 
     * @param int $id The id of the folder, collection, ...
     * @returns int or null
     */
    function wp_rml_get_parent_id($id) {
        $folder = wp_rml_get_object_by_id($id);
        return is_rml_folder($folder) ? $folder->getParent() : null;
    }
}

if (!function_exists('wp_rml_objects')) {
    /**
     * Get all available folders, collections, galleries, ...
     * 
     * @returns IFolder[]
     */
    function wp_rml_objects() {
        return attachment\Structure::getInstance()->getParsed();
    }
}

if (!function_exists('wp_rml_root_childs')) {
    /**
     * Gets the first level childs of the media library.
     * 
     * @returns IFolder[]
     */
    function wp_rml_root_childs() {
        return attachment\Structure::getInstance()->getTree();
    }
}

if (!function_exists('wp_rml_select_tree')) {
    /**
     * Returns a .rml-root-list with an given tree. The selected folder id is
     * saved automatically in a hidden input type.
     * 
     * <strong>Note #1</strong> The select tree has a javascript callback when it
     * is initalized. You can bind it with this snippet:
     * 
     * <code>window.rml.hooks.register("tree/custom", function(obj, $) {
     *       //if (obj.hasClass("my-extra-class")) {
     *            alert(obj.html());
     *       //}
     * });</code>
     * 
     * <strong>Note #2</strong> If you want to use the select tree after a DOM change (ajax,
     * for example: Modal dialog in visual editor) please call the javascript function
     * <code>window.rml.library.customLists()</code> to affect the initalization referred to Note #1.
     * 
     * <strong>Note #3</strong> You can use a sub class of IFolder to customize your tree.
     * 
     * @param string $inputName the name for the hidden input type and the name for the list
     * @param int $selected the selected folder id (saved also in hidden input type)
     * @param IFolder $tree The root view
     * @param string $extraClasses classes for the rml root list container
     * @returns string Formatted HTML string
     */
    function wp_rml_select_tree($inputName, $selected, $tree = null, $extraClasses = "") {
        $output = '<div class="aio-tree rml-root-list rml-custom-list ' . $extraClasses . '" id="rml-list-' . $inputName . '" data-id="' . $inputName . '">
                <input type="hidden" name="' . $inputName . '" value="' . $selected . '" />
                
                <div class="aio-list-standard">
                    <div class="aio-nodes">
                        ' . attachment\Structure::getInstance()->getView()->treeHTML($selected, $tree, $inputName) . '
                    </div>
                </div>
            </div>';
        return $output;
    }
}

if (!function_exists('wp_rml_create')) {
    /**
     * Creates a folder. At first it checks if a folder in parent already exists.
     * Then it checks if the given type is allowed in the parent.
     * 
     * It is highly recommenend, to use {@link wp_rml_structure_reset} after you created your folders.
     * 
     * @param string $name String Name of the folder
     * @param int $parent int ID of the parent (_wp_rml_root() for root)
     * @param int $type integer 0|1|2 @see Folder.class.inc
     * @param string[] $restrictions Restrictions for this folder
     * @param boolean $supress_validation Supress the permission validation
     * @param boolean $return_existing_id If true and the folder already exists, then return the ID of the existing folder
     * @returns int|string[] int (ID) when successfully array with error strings
     */
    function wp_rml_create($name, $parent, $type, $restrictions = array(), $supress_validation = false, $return_existing_id = false) {
        return attachment\Structure::getInstance()->createFolder($name, $parent, $type, $restrictions, $supress_validation, $return_existing_id);
    }
}

if (!function_exists('wp_rml_create_or_return_existing_id')) {
    /**
     * Wrapper function for {@link wp_rml_create}.
     */
    function wp_rml_create_or_return_existing_id($name, $parent, $type, $restrictions = array(), $supress_validation = false) {
        return wp_rml_create($name, $parent, $type, $restrictions, $supress_validation, true);
    }
}

if (!function_exists('wp_rml_rename')) {
    /**
     * Renames a folder and then checks, if there is no duplicate folder in the
     * parent folder.
     * 
     * @param string $name String New name of the folder
     * @param int $id The ID of the folder
     * @param boolean $supress_validation Supress the permission validation
     * @return boolean|string[] true or array with error strings
     */
    function wp_rml_rename($name, $id, $supress_validation = false) {
        return attachment\Structure::getInstance()->renameFolder($name, $id, $supress_validation);
    }
}

if (!function_exists('wp_rml_delete')) {
    /**
     * Deletes a folder by ID.
     * 
     * @param int $id The ID of the folder
     * @param boolean $supress_validation Supress the permission validation
     * @returns boolean|string[] True or array with error string
     */
    function wp_rml_delete($id, $supress_validation = false) {
        return attachment\Structure::getInstance()->deleteFolder($id, $supress_validation);
    }
}

if (!function_exists('wp_rml_update_count')) {
    /**
     * Handle the count cache for the folders. This should avoid
     * a lack SQL subquery which loads data from the postmeta table.
     * 
     * @param int[] $folders Array of folders ID, if null then all folders with cnt NULL are updated
     * @param int[] $attachments Array of attachments ID, is merged with $folders if given
     */
    function wp_rml_update_count($folders = null, $attachments = null) {
        attachment\CountCache::getInstance()->updateCountCache($folders, $attachments);
    }
}

if (!function_exists('wp_rml_dropdown')) {
    /**
     * This functions returns a HTML formatted string which contains
     * options-tag elements with all folders, collections and galleries.
     * 
     * @param mixed $selected The selected item, "" => "All Files", _wp_rml_root() => "Root", int => Folder ID. Can also be an array for multiple select (since 3.1.2)
     * @param int[] $disabled Which folder types are disabled. Default disabled is RML_TYPE_COLLECTION
     * @param boolean $useAll boolean Defines, if "All Files" should be showed
     * @returns string
     */
    function wp_rml_dropdown($selected, $disabled, $useAll = true) {
        return attachment\Structure::getInstance()->optionsFasade($selected, $disabled, $useAll);
    }
}

if (!function_exists('wp_rml_dropdown_collection')) {
    /**
     * This functions returns a HTML formatted string which contains
     * <code><options></code> elements with all folders, collections and galleries.
     * Note: Only COLLECTIONS are SELECTABLE!
     * 
     * @param mixed $selected The selected item, "" => "All Files", _wp_rml_root() => "Root", int => Folder ID. Can also be an array for multiple select (since 3.1.2)
     * @returns string
     */
    function wp_rml_dropdown_collection($selected) {
        return wp_rml_dropdown($selected, array(0,2,3,4));
    }
}

if (!function_exists('wp_rml_dropdown_gallery')) {
    /**
     * This functions returns a HTML formatted string which contains
     * option-tag elements with all folders, collections and galleries.
     * Note: Only GALLERIES are SELECTABLE!
     * 
     * @param mixed $selected The selected item, "" => "All Files", _wp_rml_root() => "Root", int => Folder ID. Can also be an array for multiple select (since 3.1.2)
     * @returns string
     */
    function wp_rml_dropdown_gallery($selected) {
        return wp_rml_dropdown($selected, array(0,1,3,4));
    }
}

if (!function_exists('wp_rml_dropdown_gallery_or_collection')) {
    /**
     * This functions returns a HTML formatted string which contains
     * option-tag elements with all folders, collections and galleries.
     * Note: Only GALLERIES AND COLLECTIONS are SELECTABLE!
     * 
     * @param mixed $selected The selected item, "" => "All Files", _wp_rml_root() => "Root", int => Folder ID. Can also be an array for multiple select (since 3.1.2)
     * @returns string
     */
    function wp_rml_dropdown_gallery_or_collection($selected) {
        return wp_rml_dropdown($selected, array(0,3,4));
    }
}

if (!function_exists('wp_rml_is_type')) {
    /**
     * Determines if a Folder is a special folder type.
     * 
     * @param IFolder|int $folder The folder object
     * @param int[] $allowed Which folder types are allowed
     * @returns boolean
     */
    function wp_rml_is_type($folder, $allowed) {
        if (!is_rml_folder($folder)) {
            $folder = wp_rml_get_by_id($folder, null, true);
            
            if (!is_rml_folder($folder)) {
                return false;
            }
        }
        
        return in_array($folder->getType(), $allowed);
    }
}

if (!function_exists('wp_rml_get_object_by_id')) {
    /**
     * A shortcut function for the {@link wp_rml_get_by_id) function that ensures, that 
     * a IFolder object is returned. For -1 the root instance is returned.
     * 
     * @returns IFolder Null if not found
     */
    function wp_rml_get_object_by_id($id, $allowed = null) {
        return wp_rml_get_by_id($id, $allowed, true, false);
    }
}

if (!function_exists('wp_rml_get_by_id')) {
    /**
     * This functions checks if a specific folder exists by ID and is
     * a given allowed RML Folder Type. If the given folder is {@link _wp_rml_root} you will
     * get the first level folders.
     * 
     * @param int $id Folder ID
     * @param int[] $allowed Which folder types are allowed. If null all folder types are allowed.
     * @param boolean $mustBeFolderObject Defines if the function may return the wp_rml_root_childs result
     * @param boolean $nullForRoot If set to false and $id == -1 then the Root instance is returned
     * @returns IFolder Null if not found
     */
    function wp_rml_get_by_id($id, $allowed = null, $mustBeFolderObject = false, $nullForRoot = true) {
        if (!is_numeric($id)) {
            return null;
        }
        
        if ($mustBeFolderObject == false && $id == _wp_rml_root()) {
            return wp_rml_root_childs();
        }
        
        $folder = attachment\Structure::getInstance()->getFolderByID($id, $nullForRoot);
        
        if (is_array($allowed)) {
            if (!wp_rml_is_type($folder, $allowed)) {
                return null;
            }
        }
        
        return $folder;
    }
}

if (!function_exists('wp_rml_get_by_absolute_path')) {
    /**
     * This functions checks if a specific folder exists by absolute path and is
     * a given allowed RML Folder Type.
     * 
     * @param string $path Folder Absolute Path
     * @param int[] $allowed Which folder types are allowed. If null all folder types are allowed.
     * @returns IFolder Null if not found
     */
    function wp_rml_get_by_absolute_path($path, $allowed = null) {
        $folder = attachment\Structure::getInstance()->getFolderByAbsolutePath($path);
        
        if (is_array($allowed)) {
            if (!wp_rml_is_type($folder, $allowed)) {
                return null;
            }
        }
        
        return $folder;
    }
}

if (!function_exists('wp_rml_register_creatable')) {
    /**
     * Register a new folder type for RML. It does not check if the creatable type
     * is already registered.
     * 
     * @param string $qualified The qualified name of the class representing the creatable
     * @param int $type The type of the creatable. It must be the same as in yourClass::getType is returned
     * @param boolean $onRegister Calls the yourClass::onRegister function
     */
    function wp_rml_register_creatable($qualified, $type, $onRegister = false) {
        attachment\Structure::getInstance()->registerCreatable($qualified, $type, $onRegister);
    }
}

if (!function_exists('_wp_rml_root')) {
    /**
     * Get the parent root folder for a given blog id.
     * 
     * @returns int Folder id
     */
    function _wp_rml_root() {
        /*f
         * Get the root folder id which is showed in the folder tree.
         * 
         * @param {int} $folderId=-1 -1 is "/ Unorganized"
         * @param {int} $blogId The current blog id
         * @example <caption>Get the root folder</caption>
         * $root = _wp_rml_root();
         * @returns {int} The root folder id
         * @filter RML/ParentRoot
         */
        $result = apply_filters("RML/ParentRoot", -1, get_current_blog_id());
        return $result;
    }
}

if (!function_exists('_wp_rml_active')) {
    /**
     * Checks if RML is active for the current user.
     * 
     * @returns boolean
     * @since 3.2
     */
    function _wp_rml_active() {
        /*f
         * Checks if RML is active for the current user. Do not use this filter
         * yourself, instead use _wp_rml_active() function!
         * 
         * @param {boolean} True for activated and false for deactivated
         * @returns {boolean}
         * @filter RML/Active
         * @since 3.2
         */
        $result = apply_filters("RML/Active", current_user_can("upload_files"));
        return $result;
    }
}

if (!function_exists('_wp_rml_sanitize')) {
    /**
     * Sanitize to a valid folder name for a given folder name. If the
     * passed folder name contains only unvalide characters, then it falls
     * back to the base64 encode.
     * 
     * @param string $name The name of the folder
     * @returns string
     */
    function _wp_rml_sanitize($name) {
        $slug = sanitize_file_name($name);
        return empty($slug) ? base64_encode($name) : $slug;
    }
}

if (!function_exists('wp_rml_structure_reset')) {
    /**
     * Resets the structure. This function must be called when you create a new folder for example
     * and to register it to the structure.
     * 
     * ATTENTION: This function will be declared as deprecated soon, because it is
     * planned to automatically reset the structure data / reset folder data (lazy loading 
     * of Folder objects).
     * 
     * @param int $root The root folder to read the structure
     * @param boolean $fetchData Determine if the data should be refetched
     * @param int $returnId If set this folder is returned
     * @returns IFolder If $returnId is set
     */
    function wp_rml_structure_reset($root = null, $fetchData = true, $returnId = false) {
        attachment\Structure::getInstance()->resetData($root, $fetchData);
        if ($returnId !== false) {
            return wp_rml_get_object_by_id($returnId);
        }
    }
}