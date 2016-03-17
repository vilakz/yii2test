<?php

namespace app\models;

use consultnn\embedded\EmbeddedDocument;

class EAV extends EmbeddedDocument {
    public $id;
    public $label;
    public $value;

    public function rules()
    {
        return [
            [['label', 'value','id'], 'safe'],
        ];
    }    
}