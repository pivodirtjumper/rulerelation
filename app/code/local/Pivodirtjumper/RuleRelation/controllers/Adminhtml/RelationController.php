<?php
/**
 * Created by JetBrains PhpStorm.
 * @author: pivodirtjumper
 * @date: 7/1/13
 * @time: 3:21 PM
 */
class Pivodirtjumper_RuleRelation_Adminhtml_RelationController extends Mage_Adminhtml_Controller_Action
{

    public function _initRelationRule()
    {

    }

    public function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('catalog/rulerelation')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Rule based relations'), Mage::helper('adminhtml')->__('Rule based relations'));

        return $this;
    }

    public function indexAction()
    {
        $this->_initAction();
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('pivodirtjumper_rulerelation/rulerelation');

        if ($id) {
            $model->load($id);
            if (!$model->getRuleId()) {
                Mage::getSingleton('adminhtml/session')
                    ->addError(Mage::helper('salesrule')
                        ->__('This rule no longer exists.'));
                $this->_redirect('*/*');
                return;
            }
        }

        $data = Mage::getSingleton('adminhtml/session')->getPageData(true);
        if (!empty($data)) {
            $model->addData($data);
        }

        $model->getConditions()->setJsFormObject('rule_match_conditions_fieldset');
        $model->getActions()->setJsFormObject('rule_display_conditions_fieldset');

        Mage::register('pivodirtjumper_rulerelation_data', $model);


        $this->_initAction()
            ->renderLayout();
    }

    public function saveAction()
    {
        if ($this->getRequest()->getPost()) {
            try {
                $model = Mage::getModel('pivodirtjumper_rulerelation/rulerelation');
                Mage::dispatchEvent('adminhtml_controller_rulerelation_prepare_save',
                    array(
                        'request' => $this->getRequest()
                    ));
                $data = $this->getRequest()->getPost('rule');


                $id = $this->getRequest()->getParam('id');
                if ($id) {
                    $model->load($id);
                    if ($id != $model->getId()) {
                        Mage::throwException(Mage::helper('salesrule')
                            ->__('Wrong rule specified.'));
                    }
                }

                $session = Mage::getSingleton('adminhtml/session');

                $validateResult = $model
                    ->validateData(new Varien_Object($data));
                if ($validateResult !== true) {
                    foreach ($validateResult as $errorMessage) {
                        $session->addError($errorMessage);
                    }
                    $session->setPageData($data);
                    $this->_redirect('*/*/edit', array(
                        'id' => $model->getId()
                    ));
                    return;
                }

                //var_dump($data['actions']);
                //die;

                $model->loadPost($data);

                $session->setPageData($model->getData());

                $model->save();
                $session
                    ->addSuccess(Mage::helper('salesrule')
                        ->__('The rule has been saved.'));
                $session->setPageData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this
                        ->_redirect('*/*/edit', array(
                            'id' => $model->getId()
                        ));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
                $id = (int) $this->getRequest()->getParam('rule_id');
                if (!empty($id)) {
                    $this->_redirect('*/*/edit', array(
                        'id' => $id
                    ));
                } else {
                    $this->_redirect('*/*/new');
                }
                return;

            } catch (Exception $e) {
                $this->_getSession()
                    ->addError(Mage::helper('salesrule')
                        ->__('An error occurred while saving the rule data. Please review the log and try again.'));
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->setPageData($data);
                $this
                    ->_redirect('*/*/edit',
                        array(
                            'id' => $this->getRequest()->getParam('rule_id')
                        ));
                return;
            }
        }
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            try {
                $model = Mage::getModel('pivodirtjumper_rulerelation/rulerelation');
                $model->load($id);
                $model->delete();
                Mage::getSingleton('adminhtml/session')
                    ->addSuccess(Mage::helper('salesrule')
                        ->__('The rule has been deleted.'));
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()
                    ->addError(Mage::helper('salesrule')
                        ->__('An error occurred while deleting the rule. Please review the log and try again.'));
                Mage::logException($e);
                $this
                    ->_redirect('*/*/edit',
                        array(
                            'id' => $this->getRequest()->getParam('id')
                        ));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')
            ->addError(Mage::helper('salesrule')
                ->__('Unable to find a rule to delete.'));
        $this->_redirect('*/*/');
    }

    public function newConditionHtmlAction()
    {
        $id = $this->getRequest()->getParam('id');
        $typeArr = explode('|', str_replace('-', '/', $this->getRequest()->getParam('type')));
        $type = $typeArr[0];

        $model = Mage::getModel($type)
            ->setId($id)
            ->setType($type)
            ->setRule(Mage::getModel('pivodirtjumper_rulerelation/rulerelation'))
            ->setPrefix('conditions');
        if (!empty($typeArr[1])) {
            $model->setAttribute($typeArr[1]);
        }

        if ($model instanceof Mage_Rule_Model_Condition_Abstract) {
            $model->setJsFormObject($this->getRequest()->getParam('form'));
            $html = $model->asHtmlRecursive();
        } else {
            $html = '';
        }
        $this->getResponse()->setBody($html);
    }

    public function newActionHtmlAction()
    {
        $id = $this->getRequest()->getParam('id');
        $typeArr = explode('|', str_replace('-', '/', $this->getRequest()->getParam('type')));
        $type = $typeArr[0];

        $model = Mage::getModel($type)
            ->setId($id)
            ->setType($type)
            ->setRule(Mage::getModel('pivodirtjumper_rulerelation/rulerelation'))
            ->setPrefix('actions');
        if (!empty($typeArr[1])) {
            $model->setAttribute($typeArr[1]);
        }

        if ($model instanceof Mage_Rule_Model_Condition_Abstract) {
            $model->setJsFormObject($this->getRequest()->getParam('form'));
            $html = $model->asHtmlRecursive();
        } else {
            $html = '';
        }
        $this->getResponse()->setBody($html);
    }

    public function gridAction()
    {
        $this->_initAction();
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('pivodirtjumper_rulerelation/adminhtml_rulerelation_grid')->toHtml()
        );
    }



    //Added by quickfix script. Take note when upgrading this module! Powered by SupportDesk (www.supportdesk.nu)
    function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('rulerelation');
    }
}