<?php

class FlexibleEmailField extends EmailField
{

    protected $extraAttributes = array();

    public function __construct($name, $title = null, $value = "", $extraAttributes = null, $maxLength = null, $form = null)
    {

        if (is_array($extraAttributes)) {
            $this->extraAttributes = $extraAttributes;
        }

        parent::__construct($name, $title, $value, $maxLength, $form);

    }

    public function Field()
    {
        $attributes = array_merge(array(
            'type' => 'text',
            'class' => 'text' . ($this->extraClass() ? $this->extraClass() : ''),
            'id' => $this->id(),
            'name' => $this->Name(),
            'value' => $this->Value(),
            'tabindex' => $this->getTabIndex(),
            'maxlength' => ($this->maxLength) ? $this->maxLength : null,
            'size' => ($this->maxLength) ? min( $this->maxLength, 30 ) : null
        ), $this->extraAttributes);

        if($this->disabled) $attributes['disabled'] = 'disabled';

        return $this->createTag('input', $attributes);
    }

}
