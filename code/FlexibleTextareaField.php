<?php

class FlexibleTextareaField extends TextareaField
{

    protected $extraAttributes = array();

    public function __construct($name, $title = null, $extraAttributes = null, $rows = 5, $cols = 20, $value = "", $form = null)
    {
        if (is_array($extraAttributes)) {
            $this->extraAttributes = $extraAttributes;
        }

        $this->rows = $rows;
        $this->cols = $cols;
        parent::__construct($name, $title, $value, $form);
    }

    public function Field()
    {
        if ($this->readonly) {
            $attributes = array_merge(array(
                'id' => $this->id(),
                'class' => 'readonly' . ($this->extraClass() ? $this->extraClass() : ''),
                'name' => $this->name,
                'tabindex' => $this->getTabIndex(),
                'readonly' => 'readonly'
            ), $this->extraAttributes);

            return $this->createTag(
                'span',
                $attributes,
                (($this->value) ? nl2br(htmlentities($this->value, ENT_COMPAT, 'UTF-8')) : '<i>(' . _t('FormField.NONE', 'none') . ')</i>')
            );
        } else {
            $attributes = array_merge(array(
                'id' => $this->id(),
                'class' => ($this->extraClass() ? $this->extraClass() : ''),
                'name' => $this->name,
                'rows' => $this->rows,
                'cols' => $this->cols
            ), $this->extraAttributes);

            if($this->disabled) $attributes['disabled'] = 'disabled';

            return $this->createTag('textarea', $attributes, htmlentities($this->value, ENT_COMPAT, 'UTF-8'));
        }
    }

}
