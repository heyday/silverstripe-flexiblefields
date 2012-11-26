<?php

class FlexibleDropdownField extends DropdownField
{

    protected $extraAttributes = array();

    public function __construct($name, $title = null, $source = array(), $value = "", $extraAttributes = null, $form = null, $emptyString = null)
    {
        if (is_array($extraAttributes)) {
            $this->extraAttributes = $extraAttributes;
        }

        parent::__construct($name, $title, $source, $value, $extraAttributes, $form, $emptyString);
    }

    public function Field()
    {
        $options = '';

        $source = $this->getSource();
        if ($source) {
            // For SQLMap sources, the empty string needs to be added specially
            if (is_object($source) && $this->emptyString) {
                $options .= $this->createTag('option', array('value' => ''), $this->emptyString);
            }

            foreach ($source as $value => $title) {

                // Blank value of field and source (e.g. "" => "(Any)")
                if ($value === '' && ($this->value === '' || $this->value === null)) {
                    $selected = 'selected';
                } else {
                    // Normal value from the source
                    if ($value) {
                        $selected = ($value == $this->value) ? 'selected' : null;
                    } else {
                        // Do a type check comparison, we might have an array key of 0
                        $selected = ($value === $this->value) ? 'selected' : null;
                    }

                    $this->isSelected = ($selected) ? true : false;
                }

                $options .= $this->createTag(
                    'option',
                    array(
                        'selected' => $selected,
                        'value' => $value
                    ),
                    Convert::raw2xml($title)
                );
            }
        }

        $attributes = array_merge(array(
            'class' => ($this->extraClass() ? $this->extraClass() : ''),
            'id' => $this->id(),
            'name' => $this->name,
            'tabindex' => $this->getTabIndex()
        ), $this->extraAttributes);

        if($this->disabled) $attributes['disabled'] = 'disabled';

        return $this->createTag('select', $attributes, $options);
    }

}
