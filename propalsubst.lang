<?php
/**
 * Module PropalSubst - Variables de substitution pour les propositions commerciales
 * Ajoute __PROPAL_DATE_FIN_VALIDITE__ et d'autres variables manquantes sur les propales
 */

include_once DOL_DOCUMENT_ROOT.'/core/modules/DolibarrModules.class.php';

class modPropalSubst extends DolibarrModules
{
    public function __construct($db)
    {
        global $langs, $conf;

        $this->db              = $db;
        $this->numero          = 500001; // Numéro unique du module
        $this->rights_class    = 'propalsubst';
        $this->family          = 'technic';
        $this->module_position = 500;
        $this->name            = preg_replace('/^mod/i', '', get_class($this));
        $this->description     = 'Ajoute des variables de substitution manquantes pour les propositions commerciales (devis) : date de fin de validité, etc.';
        $this->version         = '1.0.0';
        $this->const_name      = 'MAIN_MODULE_'.strtoupper($this->name);
        $this->picto           = 'propal';

        $this->module_parts = array(
            'substitutions' => 1, // Active le système de substitution
        );

        $this->dirs  = array();
        $this->boxes = array();
        $this->const = array();
        $this->tabs  = array();
        $this->dictionaries = array();
        $this->cronjobs = array();
        $this->rights = array();
        $this->menus = array();
    }

    public function init($options = '')
    {
        $result = $this->_load_tables('/propalsubst/sql/');
        return $this->_init(array(), $options);
    }

    public function remove($options = '')
    {
        return $this->_remove(array(), $options);
    }
}
