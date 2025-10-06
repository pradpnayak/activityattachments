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
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function activityattachments_civicrm_install() {
  _activityattachments_civix_civicrm_install();
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
