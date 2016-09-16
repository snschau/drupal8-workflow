<?php

namespace Drupal\downloads_widget\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Class DownloadsWidgetForm.
 *
 * @package Drupal\downloads_widget\Form
 */
class DownloadsWidgetForm extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'downloads_widget_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['filename'] = [
      '#type' => 'select',
      '#title' => $this->t('Filename'),
      '#description' => $this->t('Select the file that you want to download.'),
      '#options' => $this->getDocuments(),
      '#size' => 1,
      '#required' => True,
    ];

    $user = \Drupal::currentUser();

#    $form['email'] = array(
#      '#type' => 'email',
#      '#title' => $this->t('Email'),
#      '#required' => TRUE,
#      '#default_value' => $user->getEmail(),
#    );

    $form['pass_phrase'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Pass phrase'),
      '#size' => 60,
      '#maxlength' => 128,
      '#required' => TRUE,
    );

    $form['submit'] = [
        '#type' => 'submit',
        '#value' => t('Download File'),
    ];

    return $form;
  }

  /**
    * {@inheritdoc}
    */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
    $uri = $form_state->getValue('filename');
    
    // Create a query of the table that holds files.
    $fid = \Drupal::database()->select('file_managed', 'fm')
      ->condition('fm.uri', $uri)
      ->fields('fm', array('fid'))
      -> execute()
      ->fetchField();
    //Get the file ID that matches the file selected.
    //$fid = $query->execute()->fetchField();
    //Create a quiery of the pass phrase table.
    $query = \Drupal::database()->select('file__field_pass_phrase', 'ffpp');
    // Look for the record that matches the file ID.
    $query->condition('ffpp.entity_id', $fid);
    $query->fields('ffpp', array('field_pass_phrase_value'));
    // Get the pass phrase for the file.
    $pass_phrase = $query->execute()->fetchField();

     $user_pass_phrase = $form_state->getValue('pass_phrase');
   
    // Set an error if the user enters the wrong pass phrase
    if ($pass_phrase != $user_pass_phrase) {
      $form_state->setErrorByName('pass_phrase', t('You entered the wrong pass phrase. No document for you!'));
    }
  }


  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Display result.
    #foreach ($form_state->getValues() as $key => $value) {
     #   drupal_set_message($key . ': ' . $value);
    $uri = $form_state->getValue('filename');
    $response = new BinaryFileResponse($uri);
    $response->setContentDisposition('attachment');

    # Downloads the file as an attachement as opposed to redirecting to the files's URL>
   # $response->setContentDisposition('attachement');

    # Createds the response.
    $form_state->setResponse($response);
  // ksm($form_state);  
 # }
}

  /**
    * helper function that returns documetns.
    */
  public function getDocuments() {
    $documents_query = \Drupal::database()->select('file_managed', 'f')
      ->condition('f.type', 'document')
      ->fields('f', array('filename', 'uri'))
      ->execute()
      ->fetchAll();
    $documents = array();
    foreach ($documents_query as $document) {
     # kint($document);
      $documents[$document->uri] = $document->filename;
    }
    return $documents;
    }

}

