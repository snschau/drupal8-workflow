<?php

namespace Drupal\downloads_widget\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class DownloadsWidgetAdminSettingsForm.
 *
 * @package Drupal\downloads_widget\Form
 */
class DownloadsWidgetAdminSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'downloads_widget.DownloadsWidgetAdminSettings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'downloads_widget_admin_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('downloads_widget.DownloadsWidgetAdminSettings');
    $form['file_types'] = [
      '#type' => 'select',
      '#title' => $this->t('File types to include in the downloads widget'),
      '#options' => array('option1' => $this->t('option1'), 'option2' => $this->t('option2')),
      '#size' => 1,
      '#default_value' => $config->get('file_types'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('downloads_widget.DownloadsWidgetAdminSettings')
      ->set('file_types', $form_state->getValue('file_types'))
      ->save();
  }

}
