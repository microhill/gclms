<?
/**
 * Created: Sun May 13 11:38:53 CEST 2007
 * 
 * A CakePHP behavior to bring the cold war to CakePHP : ). It also you to define which associations should be retrieved
 * within a Model::find* query by calling Model::contain(). Credits for inspiration go to Tom OReilly, Mariano Iglesias
 * and whoever else was involved in the early pioneer days of expects, unbindAllExcept, etc..
 * 
 * PHP versions 4 and 5
 *
 * Copyright (c) Felix Geisendörfer <felix@fg-webdesign.de>
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright        Copyright (c) 2007, Felix Geisendörfer
 * @link            http://www.fg-webdesign.de/
 * @link            http://www.thinkingphp.org/ 
 * @license            http://www.opensource.org/licenses/mit-license.php The MIT License
 * @version         2.0 BETA
 */
class ContainableBehavior extends ModelBehavior {
    var $runtime = array();
    
    /**
     * Unbinds an array of $associations recursively from the $model it's being initiated from. Also automatically set's
     * Model::recursive to the required value for fetching all 'contained' associations.
     * 
     * Note: Desipte the function definition you can pass any amount of arguments, either strings or arrays beginning from the 2nd
     * parameter. Just make sure you never set the 2nd one to false as this will mess things up.
     *
     * @param object $model
     * @param array $associations
     * @param boolean $__rootLevel
     * @return boolean
     */
    function contain(&$model, $associations = array()) {
        $args = func_get_args();
        $models = call_user_func_array('am', array_slice($args, 1));
        
        $containments = $this->containments($model, $models);
        
        $query = ife(isset($containments['_query']), @$containments['_query'], array());
        
        foreach ($containments as $key => $containment) {
            if (strpos($key, '_') === 0) {
                continue;
            }
            
            $assocs = $containment['assocs'];
            $assocModel = $containment['_instance'];
            $unbind = array();
                    
            $assocTypes = array_keys($assocModel->__associationKeys);
            foreach ($assocTypes as $assocType) {
                foreach ($assocModel->{$assocType} as $assoc => $assocCfg) {
                    if (!in_array($assoc, $assocs)) {
                        $unbind[$assocType][] = $assoc;
                    } elseif (isset($containments[$assoc]['fields'])) {
                        $assocModel->{$assocType}[$assoc]['fields'] = $this->_requiredFields($containments, $assoc);
                    }
                }
            }

            $assocModel->unbindModel($unbind);
        }
        
        $containments['_backRecursive'] = $model->recursive;
        $model->recursive = $containments['_recursions'];        
        $this->runtime[$model->name] = $containments;
        
        return $containments;
    }
    
    /**
     * Enter description here...
     *
     * @param object $model Reference to the model that we want to apply our containments to
     * @param mixed $models A string or array of associations to use
     * @param boolean $__rootLevel Ignore this parameter and pass any assococations (arrays) as parameter - just do not pass false.
     * @return array
     */
    function containments(&$model, $models = array(), $__rootLevel = true) {        
        static $r = array();
                
        if (!is_bool($__rootLevel)) {
            $__rootLevel = true;
        }
        
        if ($__rootLevel === true) {
            $args = func_get_args();
            $models = call_user_func_array('am', array_slice($args, 1));
            $r = array();
            $query = array();
        }

        if (!isset($r[$model->name])) {
            $r[$model->name] = array('_instance' =>& $model, 'assocs' => array());
        }
        
        $depths = array();
        foreach ((array)$models as $name => $children) {
            if (is_numeric($name)) {
                $name = $children;
                $children = array();
            }
            
            if (strpos($name, '.') !== false) {
                $chain = explode('.', $name);
                $name = array_shift($chain);
                $children = array(join('.', $chain) => $children);
            }
            
            if ($name != 'fields' && preg_match('/^[a-z]/', $name) && (!isset($model->{$name}) || !is_object($model->{$name}))) {
                $children = array($name);
                $name = 'fields';
            }
            
            if ($name == 'fields') {
                if ($__rootLevel == false) {
                    $r[$model->name]['fields'] = $this->_mergeFields(@$r[$model->name]['fields'], $children);
                } else {
                    $query['fields'] = $this->_mergeFields(@$query['fields'], $children);
                }
                unset($models['fields']);
                continue;
            }
                        
            if (!in_array($name, $r[$model->name]['assocs'], true)) {
                $r[$model->name]['assocs'][] = $name;
            }
                        
            $depths[] = $this->containments($model->{$name}, $children, false) + 1;
        }
        
        $recursions = empty($depths) ? 0 : max($depths);
                
        if ($__rootLevel === true) {
            if (!empty($query)) {
                $r['_query'] = $query;
            }
            $r['_recursions'] = $recursions;
            return $r;
        }
        
        return $recursions;
    }
    
    function _mergeFields($arr1, $arr2) {
        $arr1 = ife(!empty($arr1), $arr1, array());
        return array_values(array_unique(am($arr1, $arr2)));
    }
    
    /**
     * @Needs Test
     *
     * @param unknown_type $containments
     * @param unknown_type $model
     * @return unknown
     */
    function _requiredFields($containments, $model, $fields = null) {
        $model =& $containments[$model]['_instance'];
        $fields = ife(!empty($fields), $fields, @$containments[$model->name]['fields']);
        
        $assocTypes = array_keys($model->__associationKeys);
        foreach($containments[$model->name]['assocs'] as $assoc) {
            foreach ($assocTypes as $assocType) {
                if ($assocType == 'belongsTo' && isset($model->{$assocType}[$assoc])) {
                    if (!empty($fields)) {
                        $fields = $this->_mergeFields($fields, $model->{$assocType}[$assoc]['foreignKey']);
                    }
                }
            }
        }
        
        return $fields;
    }
    
    /**
     * Applies query containments as neccessary
     *
     * @param object $model
     * @param array $query
     * @return array
     */
    function beforeFind(&$model, $query) {
        if (!isset($this->runtime[$model->name])) {
            return $query;
        }
        
        $containments = $this->runtime[$model->name];
        if (!isset($containments['_query'])) {
            return $query;
        }
        
        if (isset($containments['_query']['fields'])) {
            $containments['_query']['fields'] = $this->_requiredFields($containments, $model->name, $containments['_query']['fields']);
        }
        
        return am($query, $containments['_query']);
    }
    
    
    /**
     * Resets the association on all models affected by the last find for the primary model
     * @NeedsTest
     *
     * @param object $model
     * @param array $results
     * @param boolean $primary
     */
    function afterFind(&$model, $results, $primary) {
        if ($primary !== true) {
            return;
        }
        
        if (!isset($this->runtime[$model->name])) {
            return;
        }
        
        $containments = $this->runtime[$model->name];
        foreach ($containments as $key => $val) {
            if (!isset($this->runtime[$model->name][$key]['_instance'])) {
                continue;
            }
            $assocModel =& $containments[$key]['_instance'];
            if (!empty($assocModel->__backAssociation)) {
                $assocModel->__resetAssociations();
            }
        }
        
        if (isset($containments['_backRecursive'])) {
            $model->recursive = $containments['_backRecursive'];
        }
        unset($this->runtime[$model->name]);
    }
}