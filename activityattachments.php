<?php

require_once 'activityattachments.civix.php';
// phpcs:disable
use CRM_Activityattachments_ExtensionUtil as E;
// phpcs:enable

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function activityattachments_civicrm_config(&$config) {
  _activityattachments_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function activityattachments_civicrm_xmlMenu(&$files) {
  _activityattachments_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function activityattachments_civicrm_install() {
  _activityattachments_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function activityattachments_civicrm_postInstall() {
  _activityattachments_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function activityattachments_civicrm_uninstall() {
  _activityattachments_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function activityattachments_civicrm_enable() {
  _activityattachments_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function activityattachments_civicrm_disable() {
  _activityattachments_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function activityattachments_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _activityattachments_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
function activityattachments_civicrm_managed(&$entities) {
  _activityattachments_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_caseTypes
 */
function activityattachments_civicrm_caseTypes(&$caseTypes) {
  _activityattachments_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
 */
function activityattachments_civicrm_angularModules(&$angularModules) {
  _activityattachments_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function activityattachments_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _activityattachments_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function activityattachments_civicrm_entityTypes(&$entityTypes) {
  _activityattachments_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_themes().
 */
function activityattachments_civicrm_themes(&$themes) {
  _activityattachments_civix_civicrm_themes($themes);
}

/**
 * Implements hook_civicrm_alterReportVar().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterReportVar
 */
function activityattachments_civicrm_alterReportVar($varType, &$var, &$object) {
  $className = get_class($object);
  if (in_array($className, [
    'CRM_Extendedreport_Form_Report_ActivityExtended',
    'CRM_Report_Form_Activity',
  ])) {

    if ($varType == 'rows') {
      $key = 'civicrm_activity_id';
      if ($className == 'CRM_Extendedreport_Form_Report_ActivityExtended') {
        $key = 'civicrm_activity_activity_id';
      }

      foreach ($var as &$row) {
        if (array_key_exists('civicrm_activity_activity_attachments', $row)
          && !empty($row[$key])
        ) {
          $row['civicrm_activity_activity_attachments'] = CRM_Core_BAO_File::paperIconAttachment(
            'civicrm_activity', $row[$key]
          );
        }
      }
    }

    if ($varType == 'columns') {
      $field = [
        'title' => ts('Activity Attachments'),
        'dbAlias' => '""',
        'is_fields' => 1,
        'table_key' => 'civicrm_activity',
        'is_group_bys' => NULL,
        'is_join_filters' => NULL,
        'is_aggregate_columns' => NULL,
        'is_aggregate_rows' => NULL,
        'is_filters' => FALSE,
        'is_order_bys' => FALSE,
        'alias' => 'civicrm_activity_activity_attachments',
        'type' => CRM_Utils_Type::T_TEXT,
      ];
      if ($className == 'CRM_Extendedreport_Form_Report_ActivityExtended') {
        $var['civicrm_activity']['metadata']['activity_attachments'] = $field;
      }
      else {
        $var['civicrm_activity']['fields']['activity_attachments'] = $field;
      }

    }
  }
}
