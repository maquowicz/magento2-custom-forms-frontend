<?php
/**
 * Copyright © Alekseon sp. z o.o.
 * http://www.alekseon.com/
 */
declare(strict_types=1);

namespace Alekseon\CustomFormsFrontend\Block\Form\Field;

/**
 * Class AbstractField
 * @package Alekseon\CustomFormsFrontend\Block\Form\Field
 */
class AbstractField extends \Magento\Framework\View\Element\Template
{
    /**
     * @var
     */
    private $dataValidateParams;
    /**
     * @var
     */
    private $validationClass;

    /**
     * @return bool
     */
    public function isRequired()
    {
        return (bool) $this->getField()->getIsRequired();
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->getField()->getFrontendLabel();
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->getField()->getAttributeCode();
    }

    /**
     * @return string
     */
    public function getId()
    {
        return 'form_field' . $this->getForm()->getId() . '_' . $this->getField()->getAttributeCode();
    }

    /**
     * @return array
     */
    public function getDataValidateParams()
    {
        if ($this->dataValidateParams === null) {
            $this->validationClass = '';
            $this->dataValidateParams = [];
            if ($this->isRequired()) {
                $this->dataValidateParams['required'] = true;
            }

            $inputValidators = $this->getField()->getInputValidators();
            foreach ($inputValidators as $validator) {
                $validateParams = $validator->getDataValidateParams();
                foreach ($validateParams as $key => $value) {
                    $this->dataValidateParams[$key] = $value;
                }

                $this->validationClass .= $validator->getValidationFieldClass();
            }
        }

        return $this->dataValidateParams;
    }

    /**
     * @return mixed
     */
    public function getValidationClass()
    {
        $this->getDataValidateParams();
        return $this->validationClass;
    }

    /**
     *
     */
    public function getDataValidateJson()
    {
       $dataValidate = $this->getDataValidateParams();
       return json_encode($dataValidate);
    }

    /**
     * @return mixed
     */
    public function getNote()
    {
       return $this->getField()->getNote();
    }

    /**
     *
     */
    public function getPlaceholder()
    {
        return '';
    }

    /**
     *
     */
    public function getDefaultValue()
    {
        return $this->getField()->getDefaultValue();
    }
}
